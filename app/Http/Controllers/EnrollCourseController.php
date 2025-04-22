<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrollCourse;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
// APIYoutubeController
use App\Http\Controllers\API\YoutubeController as APIYoutubeController;

class EnrollCourseController extends Controller
{
    // updateCourseViewIndex users table
    public function updateCourseViewIndex(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
            // view_index
            'view_index' => 'required|numeric|min:0'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        auth()->user()->course_view_index = $request->view_index;
        auth()->user()->save();
        return response()->json([
            'message' => 'Course View Index Updated Successfully',
            'data' => auth()->user()
        ], 200);
    }
    // enrollCourses
    public function enrollCourses()
    {
        return view('admin.enrollcourses');
    }
    // getAllEnrollCourse
    public function getEnrollCoursesPageData()
    {
        // $data['enrollCourse_list'] = EnrollCourse::with('course')->orderBy('id','desc')->get();
        $query = EnrollCourse::with('course')->orderBy('id', 'desc')->latest();
        // name: 
        if (request()->has('name') && request('name') != '') {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
        // email: 
        if (request()->has('email') && request('email') != '') {
            $query->where('email', 'like', '%' . request('email') . '%');
        }
        // course_title: 
        if (request()->has('course_title') && request('course_title') != '') {
            $query->whereHas('course', function ($query) {
                $query->where('title', 'like', '%' . request('course_title') . '%');
            });
        }

        // instructor_name: 
        if (request()->has('instructor_name') && request('instructor_name') != '') {
            $instructorNames = explode(',', request('instructor_name'));

            // Ensure each name is trimmed properly
            $instructorNames = array_map('trim', $instructorNames);

            $query->whereHas('course', function ($query) use ($instructorNames) {
                foreach ($instructorNames as $instructorName) {
                    $query->where('instructor_name', 'like', '%' . $instructorName . '%');
                }
            });
        }

        // level: 
        if (request()->has('level') && request('level') != '') {
            $query->whereHas('course', function ($query) {
                $query->where('level', request('level'));
            });
        }
        // date: 
        if (request()->has('date') && request('date') != '') {
            $query->whereDate('created_at', request('date'));
        }
        $data['enrollCourse_list'] = $query->get();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // enroll course
    public function enrollCourse(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        // check if user already enrolled in the course
        $isEnrollCourse = EnrollCourse::where('course_id', $request->course_id)->where('user_id', auth()->user()->id)->first();
        if ($isEnrollCourse) {
            return response()->json([
                'message' => 'You have already enrolled in this course'
            ], 400);
        }
        $enrollCourse = new EnrollCourse();
        $enrollCourse->course_id = $request->course_id;
        $enrollCourse->user_id = auth()->user()->id;
        // 
        $enrollCourse->save();
        return response()->json([
            'message' => 'Course Enrolled Successfully',
            'data' => $enrollCourse
        ], 201);
    }
    // enrollCourseWithUserDetail
    public function enrollCourseWithUserDetail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'course_id' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        // return response()->json([
        //     'message' => 'Course Enrolled Successfully',
        //     'data' => $request->all()
        // ], 201);
        // check if user already enrolled in the course
        $isEnrollCourse = EnrollCourse::where('course_id', $request->course_id)->where('user_id', auth()->user()->id)->first();
        if ($isEnrollCourse) {
            return response()->json([
                'message' => 'You have already enrolled in this course'
            ], 400);
        }
        $enrollCourse = new EnrollCourse();
        $enrollCourse->course_id = $request->course_id;
        $enrollCourse->user_id = auth()->user()->id;
        $enrollCourse->address = $request->address;
        $enrollCourse->email = $request->email;
        $enrollCourse->name = $request->name;
        $enrollCourse->phone = $request->phone;
        $enrollCourse->save();
        // send email
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        );
        $tags = ["@@name@@", "@@email@@", "@@phone@@", "@@address@@"];
        $template = "Hello @@name@@, <br><br> Your course has been enrolled successfully. <br><br> Regards, <br> Team";
        // subject add tags
        $subject = "Course Enrolled - @@name@@";
        $subject = str_replace($tags, $data, $subject);
        // message add tags
        $template = str_replace($tags, $data, $template);
        try {
            sendMail($request->name, $request->email, $subject, $template);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Something went wrong. Please try again later.']);
        }
        return response()->json([
            'message' => 'Course Enrolled Successfully',
            'data' => $enrollCourse
        ], 201);
    }
    // getMyCourses
    public function getMyCourses()
    {
        $myCourses = EnrollCourse::where('user_id', auth()->user()->id)->with('course')->get()->map(function ($enrollCourse) {
            // course image baseurl
            $enrollCourse->course->image = url('/' . $enrollCourse->course->thumbnail);
            // cut the description
            $enrollCourse->course->description = substr($enrollCourse->course->description, 0, 100);
            // course map and set instructor_name_list with comma separated
            $enrollCourse->course->instructor_name_list  =  implode(', ', $enrollCourse->course->instructor_name);
            return $enrollCourse;
        });
        return response()->json([
            'data' => $myCourses
        ], 200);
    }
    // private function _getYouTubeVideoId($url) {
    //     preg_match('/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/embed\/)([^"&?\/\s]{11})/', $url, $matches);
    //     return $matches[1] ?? null;
    // }
    private function _getYouTubeVideoId($url)
    {
        $pattern = '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|live\/|v\/|shorts\/|.*[?&]v=))([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
    private function _getYouTubePlaylistId($url)
    {
        // Extracts the playlist ID from a playlist URL
        preg_match('/[?&]list=([a-zA-Z0-9_-]+)/', $url, $matches);
        return $matches[1] ?? null;
    }

    private function _formatYouTubeDuration($duration)
    {
        preg_match('/PT(\d+H)?(\d+M)?(\d+S)?/', $duration, $matches);

        $hours = isset($matches[1]) ? (int) filter_var($matches[1], FILTER_SANITIZE_NUMBER_INT) : 0;
        $minutes = isset($matches[2]) ? (int) filter_var($matches[2], FILTER_SANITIZE_NUMBER_INT) : 0;
        $seconds = isset($matches[3]) ? (int) filter_var($matches[3], FILTER_SANITIZE_NUMBER_INT) : 0;

        if ($hours > 0) {
            return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds); // Format as H:MM:SS
        } else {
            return sprintf("%d:%02d", $minutes, $seconds); // Format as MM:SS
        }
    }

    // myCourseDetail
    // public function myCourseDetail($id)
    // {
    //     $view_index = auth()->user()->course_view_index;
    //     $course = Course::with('type', 'videos', 'enrollCourses')->where('id', $id)->first();
    //     // return response()->json(['status' => 200, 'course' => $course, 'view_index' => $view_index]);
    //     if ($course) {
    //         // instructor_name
    //         $course->instructor_name_list  =  implode(', ', $course->instructor_name);
    //         // count enrolled courses
    //         $course->enrolled = count($course->enrollCourses);
    //         // add base url to thumbnail
    //         $course->image = url('/' . $course->thumbnail);
    //         // duration_minutes to duration_hours
    //         $course->duration_hours = round(($course->duration_minutes / 60), 1);
    //         // Initialize YouTube Controller using Laravel's app() helper
    //         $youtube = app(APIYoutubeController::class);
    //         // return response()->json(['status' => 200, 'vv' => $course->videos, 'view_index' => $view_index]);
    //         // Process course videos
    //         // $course->videos = $course->videos->map(function ($video) use ($youtube) {
    //         //     // Extract YouTube video ID
    //         //     $videoId = $this->_getYouTubeVideoId($video->video_url);
    //         //     $video->video_url = "https://www.youtube.com/embed/" . $videoId;
    //         //     // Fetch YouTube video details
    //         //     $video->youtube_details = $youtube->videoDetail($videoId);
    //         //     $video->duration = $this->_formatYouTubeDuration($video->youtube_details['video']['contentDetails']['duration'] ?? '');
    //         //     return $video;
    //         // });
    //         $temp_list_vedios = [];
    //         $course->videos = $course->videos->map(function ($video) use ($youtube) {
    //             $videoId = $this->_getYouTubeVideoId($video->video_url);
    //             $playlistId = $this->_getYouTubePlaylistId($video->video_url);

    //             if ($videoId) {
    //                 // It's a video (normal or live)
    //                 $video->video_url = "https://www.youtube.com/embed/" . $videoId;
    //                 $video->youtube_details = $youtube->videoDetail($videoId);
    //                 $video->duration = $this->_formatYouTubeDuration($video->youtube_details['video']['contentDetails']['duration'] ?? '');
    //             } elseif ($playlistId) {
    //                 // getPlaylistVideos
    //                 // $all_playlist = $youtube->getPlaylistVideos($playlistId);
    //                 $playlistResponse = $youtube->getPlaylistVideos($playlistId);
    //                 $playlistData = $playlistResponse->getData();

    //                 foreach ($playlistData->videos as $item) {
    //                     $tempVideoId = $item->snippet->resourceId->videoId ?? null;

    //                     if ($tempVideoId) {
    //                         $videoDetails = $youtube->videoDetail($tempVideoId);

    //                         // $processedVideos->push((object)[
    //                         //     'video_url' => "https://www.youtube.com/embed/" . $tempVideoId,
    //                         //     'youtube_details' => $videoDetails,
    //                         //     'duration' => $this->_formatYouTubeDuration($videoDetails['video']['contentDetails']['duration'] ?? ''),
    //                         // ]);
    //                         $temp_list_vedios[] = (object)[
    //                             'course_id' => $video->course_id,
    //                             'video_id' => $video->id,
    //                             'created_at' => $video->created_at,
    //                             'updated_at' => $video->updated_at,
    //                             'video_url' => "https://www.youtube.com/embed/" . $tempVideoId,
    //                             'youtube_details' => $videoDetails,
    //                             'duration' => $this->_formatYouTubeDuration($videoDetails['video']['contentDetails']['duration'] ?? ''),
    //                         ];
    //                         $video->temp_list_vedios = $temp_list_vedios;
    //                     }
    //                 }
    //                 // return response()->json([
    //                 //     'status' => 200,
    //                 //     'playlist' => $video->playlist,
    //                 // ]);
    //                 // It's a playlist
    //                 // $video->video_url = "https://www.youtube.com/embed/videoseries?list=" . $playlistId;
    //                 // $video->youtube_details = ['playlist_id' => $playlistId];
    //                 // $video->duration = null; // or calculate total playlist duration if needed
    //             } else {
    //                 $video->youtube_details = null;
    //                 $video->duration = null;
    //             }

    //             return $video;
    //         });


    //         $tempVideos = [];

    //         foreach ($course->videos as $video) {
    //             if (isset($video->temp_list_vedios)) {
    //                 foreach ($video->temp_list_vedios as $temp_video) {
    //                     array_push($tempVideos, $temp_video);
    //                 }
    //             } else {
    //                 array_push($tempVideos, $video);
    //             }
    //         }

    //         // Merge temp videos with course videos (as plain arrays)
    //         // $course->videos2 =(array)array_merge((array)$course->videos, $tempVideos);
    //         // $allVideos = collect($course->videos);
    //         // foreach ($tempVideos as $tempVideo) {
    //         //     $allVideos->push($tempVideo);
    //         // }
    //         // $course->videos2 = $allVideos;

    //         $videosArray = $course->videos->toArray();
    //         $cleanedVideos = [];

    //         // Process videos array
    //         foreach ($videosArray as $video) {
    //             if (isset($video['temp_list_vedios'])) {
    //                 unset($video['temp_list_vedios']);
    //             }
    //             $cleanedVideos[] = $video;
    //         }

    //         // Process temp videos
    //         $cleanedTempVideos = [];
    //         foreach ($tempVideos as $video) {
    //             $videoArray = (array)$video; // Convert to array if it's an object
    //             if (isset($videoArray['temp_list_vedios'])) {
    //                 unset($videoArray['temp_list_vedios']);
    //             }
    //             $cleanedTempVideos[] = (object)$videoArray; // Convert back to object
    //         }

    //         $course->videos2 = array_merge($cleanedVideos, $cleanedTempVideos);


    //         // releated courses
    //         $releatedCourses = Course::with('videos', 'type')->where('status', 1)->where('type_id', $course->type_id)->where('id', '!=', $id)->limit(3)->get()->map(function ($course) {
    //             // add base url to thumbnail
    //             $course->image = url('/' . $course->thumbnail);
    //             // duration_minutes to duration_hours
    //             $course->duration_hours = round(($course->duration_minutes / 60), 1);
    //             return $course;
    //         });
    //         return response()->json(['status' => 200, 'course' => $course, 'releatedCourses' => $releatedCourses, 'view_index' => $view_index]);
    //     } else {
    //         return response()->json(['status' => 404, 'message' => 'Course not found']);
    //     }
    // }


    // myCourseDetail
    public function myCourseDetail($id)
    {
        $view_index = auth()->user()->course_view_index;
        $course = Course::with('type', 'videos', 'enrollCourses')->where('id', $id)->first();

        if ($course) {
            // instructor_name
            $course->instructor_name_list  =  implode(', ', $course->instructor_name);
            // count enrolled courses
            $course->enrolled = count($course->enrollCourses);
            // add base url to thumbnail
            $course->image = url('/' . $course->thumbnail);
            // duration_minutes to duration_hours
            $course->duration_hours = round(($course->duration_minutes / 60), 1);
            // Initialize YouTube Controller using Laravel's app() helper
            $youtube = app(APIYoutubeController::class);

            $temp_list_vedios = [];
            $course->videos = $course->videos->map(function ($video) use ($youtube) {
                $videoId = $this->_getYouTubeVideoId($video->video_url);
                $playlistId = $this->_getYouTubePlaylistId($video->video_url);

                if ($videoId) {
                    // It's a video (normal or live)
                    $video->video_url = "https://www.youtube.com/embed/" . $videoId;
                    $video->youtube_details = $youtube->videoDetail($videoId);
                    $video->duration = $this->_formatYouTubeDuration($video->youtube_details['video']['contentDetails']['duration'] ?? '');
                } elseif ($playlistId) {
                    // It's a playlist - get all videos from the playlist
                    $playlistResponse = $youtube->getPlaylistVideos($playlistId);
                    $playlistData = $playlistResponse->getData();

                    foreach ($playlistData->videos as $item) {
                        $tempVideoId = $item->snippet->resourceId->videoId ?? null;

                        if ($tempVideoId) {
                            $videoDetails = $youtube->videoDetail($tempVideoId);

                            $temp_list_vedios[] = (object)[
                                'course_id' => $video->course_id,
                                'video_id' => $video->id,
                                'created_at' => $video->created_at,
                                'updated_at' => $video->updated_at,
                                'video_url' => "https://www.youtube.com/embed/" . $tempVideoId,
                                'youtube_details' => $videoDetails,
                                'duration' => $this->_formatYouTubeDuration($videoDetails['video']['contentDetails']['duration'] ?? ''),
                            ];
                            $video->temp_list_vedios = $temp_list_vedios;
                        }
                    }
                } else {
                    $video->youtube_details = null;
                    $video->duration = null;
                }

                return $video;
            });

            // Create tempVideos array
            $tempVideos = [];

            foreach ($course->videos as $video) {
                if (isset($video->temp_list_vedios)) {
                    foreach ($video->temp_list_vedios as $temp_video) {
                        array_push($tempVideos, $temp_video);
                    }
                } else {
                    array_push($tempVideos, $video);
                }
            }

            // Extract only the necessary fields for videos array
            $videosArray = [];
            foreach ($course->videos as $video) {
                // Skip any video with the specific playlist URL
                if (is_string($video->video_url) && $video->video_url === "https://www.youtube.com/playlist?list=PLnWyyZtBFGDVbSSY0J3xoMCo1jx3hOVI1") {
                    continue;
                }

                // Extract only public attributes and added properties
                $cleanVideo = [
                    'id' => $video->id,
                    'course_id' => $video->course_id,
                    'video_url' => $video->video_url,
                    'created_at' => $video->created_at,
                    'updated_at' => $video->updated_at
                ];

                // Add any additional properties that were added during processing
                if (isset($video->youtube_details)) {
                    $cleanVideo['youtube_details'] = $video->youtube_details;
                }
                if (isset($video->duration)) {
                    $cleanVideo['duration'] = $video->duration;
                }

                $videosArray[] = $cleanVideo;
            }

            // Clean temp videos
            $cleanedTempVideos = [];
            foreach ($tempVideos as $video) {
                // Check if this video has the playlist URL and skip it
                $videoUrl = null;
                if ($video instanceof \Illuminate\Database\Eloquent\Model) {
                    $videoUrl = $video->video_url;
                } elseif (is_object($video)) {
                    $videoUrl = $video->video_url ?? null;
                } else {
                    $videoUrl = $video['video_url'] ?? null;
                }

                // Skip videos with the specific playlist URL
                if ($videoUrl === "https://www.youtube.com/playlist?list=PLnWyyZtBFGDVbSSY0J3xoMCo1jx3hOVI1") {
                    continue;
                }

                if ($video instanceof \Illuminate\Database\Eloquent\Model) {
                    // It's a model, extract specific attributes
                    $cleanVideo = [
                        'id' => $video->id ?? null,
                        'course_id' => $video->course_id ?? null,
                        'video_url' => $video->video_url ?? null,
                        'created_at' => $video->created_at ?? null,
                        'updated_at' => $video->updated_at ?? null
                    ];

                    // Add dynamic properties
                    if (isset($video->youtube_details)) {
                        $cleanVideo['youtube_details'] = $video->youtube_details;
                    }
                    if (isset($video->duration)) {
                        $cleanVideo['duration'] = $video->duration;
                    }
                    if (isset($video->video_id)) {
                        $cleanVideo['video_id'] = $video->video_id;
                    }
                } elseif (is_object($video)) {
                    // Standard object, extract properties
                    $cleanVideo = [
                        'course_id' => $video->course_id ?? null,
                        'video_id' => $video->video_id ?? null,
                        'created_at' => $video->created_at ?? null,
                        'updated_at' => $video->updated_at ?? null,
                        'video_url' => $video->video_url ?? null
                    ];

                    if (isset($video->youtube_details)) {
                        $cleanVideo['youtube_details'] = $video->youtube_details;
                    }
                    if (isset($video->duration)) {
                        $cleanVideo['duration'] = $video->duration;
                    }
                } else {
                    // It's already an array
                    $cleanVideo = [
                        'id' => $video['id'] ?? null,
                        'course_id' => $video['course_id'] ?? null,
                        'video_url' => $video['video_url'] ?? null,
                        'created_at' => $video['created_at'] ?? null,
                        'updated_at' => $video['updated_at'] ?? null
                    ];

                    if (isset($video['youtube_details'])) {
                        $cleanVideo['youtube_details'] = $video['youtube_details'];
                    }
                    if (isset($video['duration'])) {
                        $cleanVideo['duration'] = $video['duration'];
                    }
                    if (isset($video['video_id'])) {
                        $cleanVideo['video_id'] = $video['video_id'];
                    }
                }

                $cleanedTempVideos[] = $cleanVideo;
            }

            // Prevent duplicate videos by using a unique key
            $uniqueVideos = [];
            $uniqueKeys = [];

            // Process original videos first
            foreach ($videosArray as $video) {
                // Create a unique key based on the video URL or ID
                $key = $video['video_url'] ?? $video['id'];

                if (!in_array($key, $uniqueKeys)) {
                    $uniqueKeys[] = $key;
                    $uniqueVideos[] = $video;
                }
            }

            // Then process temp videos
            foreach ($cleanedTempVideos as $video) {
                // Create a unique key based on the video URL
                $key = $video['video_url'] ?? $video['id'] ?? $video['video_id'];

                if (!in_array($key, $uniqueKeys)) {
                    $uniqueKeys[] = $key;
                    $uniqueVideos[] = $video;
                }
            }

            // Replace the merged array with our unique array
            $course->videos2 = $uniqueVideos;

            // Related courses
            $relatedCourses = Course::with('videos', 'type')
                ->where('status', 1)
                ->where('type_id', $course->type_id)
                ->where('id', '!=', $id)
                ->limit(3)
                ->get()
                ->map(function ($course) {
                    // Add base url to thumbnail
                    $course->image = url('/' . $course->thumbnail);
                    // Duration_minutes to duration_hours
                    $course->duration_hours = round(($course->duration_minutes / 60), 1);
                    return $course;
                });

            return response()->json([
                'status' => 200,
                'course' => $course,
                'relatedCourses' => $relatedCourses,
                'view_index' => $view_index
            ]);
        } else {
            return response()->json(['status' => 404, 'message' => 'Course not found']);
        }
    }
}
