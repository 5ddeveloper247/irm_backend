<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Youtube;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class YoutubeController extends Controller
{
    // private $apiKey = env('youtube_apiKey');
    // private $playlistId = env('youtube_playlistId');
    private $apiKey = 'AIzaSyBk1z-xAVabyzCk4VJOCSDJh_i49MlMpPI';
    // private $playlistId = 'PLgohHfkVYNArdtwrYAw-F0QfHYe1u7IdU&si=cXp8QUBiDwZLOxYV';
    private $playlistId = 'PLnWyyZtBFGDVV3g7EQVjNlouzVZ9eSzcv';
    // Fallback playlist IDs
    private $facebookFallbackPlaylist = 'PLnWyyZtBFGDVV3g7EQVjNlouzVZ9eSzcv';
    private $youtubeFallbackPlaylist = 'PLnWyyZtBFGDWIFkWVarFzluPNeMR3Hgx-&si=VI866qgaXqPmahNr';

    // public function getPlaylists(Request $request, $playlistId = null)
    // {
    //     $playlist = null;
    //     $lastestPlaylists = Youtube::where('status', 1)->latest()->first();
    //     if ($lastestPlaylists == null) {
    //         return response()->json([
    //             'message' => 'Playlist not found',
    //             'status' => 404
    //         ]);
    //     }
    //     if ($playlistId) {
    //         $playlist = Youtube::where('playlist_id', $playlistId)->where('status', 1)->first();
    //     } else {
    //         $playlist = Youtube::where('playlist_id', $lastestPlaylists->playlist_id)->where('status', 1)->first();
    //     }
    //     if (!$playlist) {
    //         return response()->json([
    //             'message' => 'Playlist not found',
    //             'status' => 404
    //         ]);
    //     }
    //     $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$playlist->playlist_id}&key={$this->apiKey}";
    //     $playlistDetails = $this->fetchData($playlistDetailsUrl);
    //     $playlist->details = $playlistDetails['items'][0] ?? null;
    //     // vedios
    //     $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlist->playlist_id}&key={$this->apiKey}";
    //     $videos = $this->fetchAllVideos($playlistItemsUrl);
    //     $playlist->videos = $videos;
    //     $youtubeChannelLists = Youtube::where('status', 1)->latest()->get();
    //     $youtubeChannelLists->map(function ($list) {
    //         $words = explode(' ', $list->playlist_title); // Split the string into an array of words
    //         $firstTwoWords = implode(' ', array_slice($words, 0, 2)); // Take the first two words
    //         $list->stitle = $firstTwoWords;
    //     });
    //     return response()->json([
    //         'playlist' => $playlist,
    //         'lastestPlaylists' => $lastestPlaylists,
    //         'youtubeChannelLists' => $youtubeChannelLists,
    //         'status' => 200
    //     ]);
    // }

    public function getPlaylists(Request $request, $playlistId = null)
    {
        // Get latest playlist or use requested one
        $latestPlaylist = Youtube::where('status', 1)->latest()->first();
        // return response()->json(['latestPlaylist',$latestPlaylist]);
        if (!$latestPlaylist) {
            return response()->json(['message' => 'Playlist not found', 'status' => 404]);
        }

        // Select playlist based on ID or fallback to latest
        $playlist = null;
        if ($playlistId) {
            $playlist = Youtube::where('playlist_id', $playlistId)->where('status', 1)->first();
            // Handle API playlists not in database
            if (!$playlist) {
                $parentChannel = Youtube::where('status', 1)->first();
                if ($parentChannel) {
                    $playlist = clone $parentChannel;
                    $playlist->playlist_id = $playlistId;
                }
            }
        } else {
            // $playlist = $latestPlaylist;
            $playlist = new \stdClass();
            $playlist->created_at = "2025-04-17T09:50:28.000000Z";
            $playlist->id = 5;
            $playlist->playlist_id = "PLnWyyZtBFGDVRjIDcrha-IH_dyusWw8Ee";
            $playlist->playlist_title = "International Annual";
            $playlist->status = 1;
            $playlist->updated_at = "2025-04-17T09:51:25.000000Z";
        }

        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found', 'status' => 404]);
        }

        // Initialize collections and determine if we're dealing with a channel
        $databaseChannels = Youtube::where('status', 1)->latest()->get();
        $youtubeChannelLists = collect([]);
        $isChannelId = strpos($playlist->playlist_id, 'UC') === 0;
        $selectedPlaylistId = $playlistId ?: $playlist->playlist_id;

        if ($isChannelId) {
            // CHANNEL HANDLING
            $channelId = $playlist->playlist_id;

            // Get channel details
            $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
            $channelDetails = $this->fetchData($channelUrl);
            $playlist->details = $channelDetails['items'][0] ?? null;

            // Get all playlists from this channel
            $channelPlaylistsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId={$channelId}&maxResults=50&key={$this->apiKey}";
            $channelPlaylistsData = $this->fetchData($channelPlaylistsUrl);
            $filteredPlaylists = collect($channelPlaylistsData['items'] ?? [])
                ->filter(function ($item) {
                    return isset($item['id']) && strpos($item['id'], 'PL') === 0;
                })
                ->values()
                ->all();

            // Build sidebar channel list
            foreach ($databaseChannels as $dbChannel) {
                if ($dbChannel->playlist_id == $channelId) {
                    // Add channel to sidebar
                    $channelItem = clone $dbChannel;
                    $channelItem->api_title = $channelDetails['items'][0]['snippet']['title'] ?? $dbChannel->playlist_title;
                    // $channelItem->is_channel = true;
                    // $youtubeChannelLists->push($channelItem);

                    // Add all playlists from this channel to sidebar
                    foreach ($filteredPlaylists as $pl) {
                        $playlistItem = new \stdClass();
                        $playlistItem->id = $pl['id'];
                        $playlistItem->playlist_id = $pl['id'];
                        $playlistItem->playlist_title = $pl['snippet']['title'];
                        $playlistItem->api_title = $pl['snippet']['title'];
                        $playlistItem->is_playlist = true;
                        $playlistItem->parent_channel_id = $channelId;
                        $youtubeChannelLists->push($playlistItem);
                    }
                } else {
                    // Add other channels
                    // $channelItem = clone $dbChannel;
                    // $channelItem->is_channel = true;
                    // $youtubeChannelLists->push($channelItem);
                }
            }

            // Set playlist data
            $playlist->playlist_list = $filteredPlaylists;

            // Determine which playlist videos to show
            $targetPlaylistId = null;
            $targetPlaylistTitle = '';

            if ($playlistId && strpos($playlistId, 'PL') === 0) {
                // Show selected playlist
                $targetPlaylistId = $playlistId;
                foreach ($filteredPlaylists as $pl) {
                    if ($pl['id'] == $targetPlaylistId) {
                        $targetPlaylistTitle = $pl['snippet']['title'] ?? '';
                        break;
                    }
                }
            } elseif (!empty($filteredPlaylists)) {
                // Show first playlist as default
                $targetPlaylistId = $filteredPlaylists[0]['id'];
                $targetPlaylistTitle = $filteredPlaylists[0]['snippet']['title'] ?? '';
            }

            // Get videos for target playlist
            if ($targetPlaylistId) {
                $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$targetPlaylistId}&key={$this->apiKey}";
                $playlist->videos = $this->fetchAllVideos($playlistItemsUrl);
                $playlist->selected_playlist_title = $targetPlaylistTitle;
                $playlist->selected_playlist_id = $targetPlaylistId;
            } else {
                $playlist->videos = [];
                $playlist->selected_playlist_title = '';
                $playlist->selected_playlist_id = '';
            }
        } else {
            // REGULAR PLAYLIST HANDLING
            $currentPlaylistId = $playlistId ?: $playlist->playlist_id;

            // Get playlist details
            $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$currentPlaylistId}&key={$this->apiKey}";
            $playlistDetails = $this->fetchData($playlistDetailsUrl);
            $playlist->details = $playlistDetails['items'][0] ?? null;

            // Set playlist metadata
            if (isset($playlistDetails['items'][0]['snippet']['title'])) {
                $playlist->api_title = $playlistDetails['items'][0]['snippet']['title'];
            }
            $playlist->selected_playlist_title = $playlistDetails['items'][0]['snippet']['title'] ?? '';
            $playlist->selected_playlist_id = $currentPlaylistId;

            // Get videos for this playlist
            $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$currentPlaylistId}&key={$this->apiKey}";
            $playlist->videos = $this->fetchAllVideos($playlistItemsUrl);

            // Handle sidebar content - add channel and sibling playlists
            if (isset($playlistDetails['items'][0]['snippet']['channelId'])) {
                $channelId = $playlistDetails['items'][0]['snippet']['channelId'];
                $channelPlaylistsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId={$channelId}&maxResults=50&key={$this->apiKey}";
                $channelPlaylists = $this->fetchData($channelPlaylistsUrl);

                foreach ($databaseChannels as $dbChannel) {
                    // Add channel to sidebar
                    // $channelItem = clone $dbChannel;
                    // $channelItem->is_channel = true;
                    // $youtubeChannelLists->push($channelItem);

                    // Add related playlists if this is related to current playlist's channel
                    $isRelated = ($dbChannel->playlist_id == $playlist->playlist_id ||
                        (isset($playlistDetails['items'][0]['snippet']['channelId']) &&
                            $dbChannel->playlist_id == $playlistDetails['items'][0]['snippet']['channelId']));

                    if ($isRelated) {
                        foreach ($channelPlaylists['items'] ?? [] as $pl) {
                            if (isset($pl['id'])) {
                                $playlistItem = new \stdClass();
                                $playlistItem->id = $pl['id'];
                                $playlistItem->playlist_id = $pl['id'];
                                $playlistItem->playlist_title = $pl['snippet']['title'];
                                $playlistItem->api_title = $pl['snippet']['title'];
                                $playlistItem->is_playlist = true;
                                $playlistItem->parent_channel_id = $channelId;
                                $youtubeChannelLists->push($playlistItem);
                            }
                        }
                    }
                }
            }
        }

        // Create shortened titles for UI
        $youtubeChannelLists = $youtubeChannelLists->map(function ($item) {
            $title = $item->api_title ?? $item->playlist_title;
            $words = explode(' ', $title);
            $item->stitle = implode(' ', array_slice($words, 0, 2));
            return $item;
        });


        $responsePlaylist = new \stdClass();
        // $responsePlaylist->id = !$youtubeChannelLists->isEmpty() ? $youtubeChannelLists->first()->id : null;
        // Find the specific record with the desired ID
        $specificRecord = $youtubeChannelLists->firstWhere('id', 'PLnWyyZtBFGDVRjIDcrha-IH_dyusWw8Ee');

        // Set the ID from the specific record, or null if not found
        $responsePlaylist->id = $specificRecord ? $specificRecord->id : null;
        // Copy other needed properties
        $responsePlaylist->playlist_id = $latestPlaylist->playlist_id;
        $responsePlaylist->playlist_title = $latestPlaylist->playlist_title;
        $responsePlaylist->created_at = $latestPlaylist->created_at;
        $responsePlaylist->details = $latestPlaylist->details;
        $responsePlaylist->playlist_list = $latestPlaylist->playlist_list;
        $responsePlaylist->selected_playlist_id = $latestPlaylist->selected_playlist_id;
        $responsePlaylist->updated_at = $latestPlaylist->updated_at;
        $responsePlaylist->status = $latestPlaylist->status;
        $responsePlaylist->videos = $latestPlaylist->videos;

        return response()->json([

            'playlist' => $playlist,
            'lastestPlaylists' => $responsePlaylist,
            'youtubeChannelLists' => $youtubeChannelLists,
            'responsePlaylist' => $responsePlaylist,
            // 'test' => $youtubeChannelLists->first()->id,
            'status' => 200
        ]);
    }

    public function getChannel($channelId)
    {

        $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
        $channelDetails = $this->fetchData($channelUrl);

        return response()->json([
            'channel' => $channelDetails['items'][0] ?? null,
            'status' => 200
        ]);


        return response()->json([
            'message' => 'Channel ID is required',
            'status' => 400
        ]);
    }
    public function getPlaylist(Request $request)
    {
        if (!$request->has('playlist_id')) {
            return response()->json([
                'message' => 'Channel ID is required',
                'status' => 400
            ]);
        }

        $channelId = $request->playlist_id;

        // Get channel data directly instead of calling the response-returning method
        $channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$this->apiKey}";
        $channelDetails = $this->fetchData($channelUrl);

        // Format the response to match what your frontend expects
        $channelResponse = [
            'original' => [
                'channel' => $channelDetails['items'][0] ?? null
            ]
        ];

        return response()->json([
            'channels' => $channelResponse,
            'status' => 200
        ]);
    }
    public function videoDetail($videoId)
    {
        $videoDetailsUrl = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id={$videoId}&key={$this->apiKey}";
        $commentsUrl = "https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&videoId={$videoId}&key={$this->apiKey}&maxResults=10";
        $videoDetails = $this->fetchData($videoDetailsUrl);
        $comments = $this->fetchData($commentsUrl);
        return ([
            'video' => $videoDetails['items'][0] ?? null,
            'comments' => $comments['items'] ?? []
        ]);
    }
    // get playlist videos
    public function getPlaylistVideos($playlistId)
    {
        $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}";
        $videos = $this->fetchAllVideos($playlistItemsUrl);
        return response()->json([
            'videos' => $videos,
            'status' => 200
        ]);
    }
    private function fetchData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
    private function fetchAllVideos($url)
    {
        $allVideos = [];
        do {
            $data = $this->fetchData($url);
            if (!isset($data['items'])) break;
            $allVideos = array_merge($allVideos, $data['items']);
            $url = isset($data['nextPageToken']) ? $url . '&pageToken=' . $data['nextPageToken'] : null;
        } while ($url);
        return $allVideos;
    }


    public function getYoutubeLiveStatus($channelId = null)
    {
        try {
            // Static channel ID for testing - this channel is currently live
            $channelId = 'UC0Um3pnZ2WGBEeoA3BX2sKw';

            // Log the channel ID being used
            Log::info('Testing YouTube Live Status with Channel ID: ' . $channelId);

            // Cache the result for 1 minute for testing (shorter cache time)
            $cacheKey = "youtube_live_status_{$channelId}";

            $result = Cache::remember($cacheKey, 60, function () use ($channelId) {
                // Check for live videos
                $searchUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId={$channelId}&eventType=live&type=video&key={$this->apiKey}&maxResults=5";

                Log::info('YouTube API Request URL: ' . $searchUrl);

                $searchResponse = Http::timeout(30)->get($searchUrl);

                if (!$searchResponse->successful()) {
                    $errorMsg = 'YouTube API Error: ' . $searchResponse->status() . ' - ' . $searchResponse->body();
                    Log::error($errorMsg);

                    // Return fallback playlist data when API fails
                    return [
                        'isLive' => false,
                        'error' => $errorMsg,
                        'fallbackPlaylist' => $this->youtubeFallbackPlaylist,
                        'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->youtubeFallbackPlaylist}&autoplay=1",
                        'message' => 'API unavailable - showing recent videos',
                        'apiUrl' => $searchUrl
                    ];
                }

                $searchData = $searchResponse->json();

                // Log the complete response for debugging
                Log::info('YouTube Live Search Response', [
                    'channelId' => $channelId,
                    'itemsCount' => count($searchData['items'] ?? []),
                    'data' => $searchData
                ]);

                if (!empty($searchData['items'])) {
                    $liveVideo = $searchData['items'][0];

                    Log::info('Found Live Video', [
                        'videoId' => $liveVideo['id']['videoId'],
                        'title' => $liveVideo['snippet']['title']
                    ]);

                    // Get additional video details
                    $videoResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                        'part' => 'snippet,liveStreamingDetails,statistics',
                        'id' => $liveVideo['id']['videoId'],
                        'key' => $this->apiKey
                    ]);

                    $videoDetails = $videoResponse->successful() ? $videoResponse->json() : null;

                    if ($videoDetails) {
                        Log::info('Video Details Retrieved', [
                            'viewers' => $videoDetails['items'][0]['liveStreamingDetails']['concurrentViewers'] ?? 'N/A'
                        ]);
                    }

                    return [
                        'isLive' => true,
                        'videoId' => $liveVideo['id']['videoId'],
                        'title' => $liveVideo['snippet']['title'],
                        'description' => $liveVideo['snippet']['description'] ?? '',
                        'channelTitle' => $liveVideo['snippet']['channelTitle'],
                        'thumbnail' => $liveVideo['snippet']['thumbnails']['high']['url'] ??
                            ($liveVideo['snippet']['thumbnails']['medium']['url'] ?? ''),
                        'embedUrl' => "https://www.youtube.com/embed/{$liveVideo['id']['videoId']}?autoplay=1",
                        'watchUrl' => "https://www.youtube.com/watch?v={$liveVideo['id']['videoId']}",
                        'publishedAt' => $liveVideo['snippet']['publishedAt'],
                        'channelId' => $channelId,
                        'viewerCount' => $videoDetails['items'][0]['liveStreamingDetails']['concurrentViewers'] ?? null,
                        'debug' => [
                            'apiUsed' => 'live search',
                            'totalResults' => $searchData['pageInfo']['totalResults'] ?? 0
                        ]
                    ];
                }

                // Check for upcoming live streams if no live videos found
                Log::info('No live videos found, checking for upcoming streams');

                $upcomingResponse = Http::get('https://www.googleapis.com/youtube/v3/search', [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'eventType' => 'upcoming',
                    'type' => 'video',
                    'key' => $this->apiKey,
                    'maxResults' => 1
                ]);

                if ($upcomingResponse->successful()) {
                    $upcomingData = $upcomingResponse->json();

                    Log::info('Upcoming videos check', [
                        'upcomingCount' => count($upcomingData['items'] ?? [])
                    ]);

                    if (!empty($upcomingData['items'])) {
                        $upcomingVideo = $upcomingData['items'][0];
                        return [
                            'isLive' => false,
                            'isUpcoming' => true,
                            'videoId' => $upcomingVideo['id']['videoId'],
                            'title' => $upcomingVideo['snippet']['title'],
                            'description' => $upcomingVideo['snippet']['description'] ?? '',
                            'channelTitle' => $upcomingVideo['snippet']['channelTitle'],
                            'thumbnail' => $upcomingVideo['snippet']['thumbnails']['high']['url'] ?? '',
                            'scheduledStartTime' => $upcomingVideo['snippet']['publishedAt'],
                            'channelId' => $channelId,
                            'message' => 'Live stream scheduled',
                            'fallbackPlaylist' => $this->youtubeFallbackPlaylist,
                            'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->youtubeFallbackPlaylist}&autoplay=1"
                        ];
                    }
                }

                // Return fallback playlist data when no live or upcoming videos
                return [
                    'isLive' => false,
                    'message' => 'Channel is not currently live - showing recent videos',
                    'channelId' => $channelId,
                    'fallbackPlaylist' => $this->youtubeFallbackPlaylist,
                    'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->youtubeFallbackPlaylist}&autoplay=1",
                    'debug' => [
                        'searchResults' => $searchData['pageInfo']['totalResults'] ?? 0,
                        'apiKey' => substr($this->apiKey, 0, 10) . '...' // Show first 10 chars for debugging
                    ]
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('YouTube Live Status Error: ' . $e->getMessage(), [
                'channelId' => $channelId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'isLive' => false,
                'error' => 'An error occurred while checking live status: ' . $e->getMessage(),
                'channelId' => $channelId,
                'fallbackPlaylist' => $this->youtubeFallbackPlaylist,
                'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->youtubeFallbackPlaylist}&autoplay=1"
            ]);
        }
    }

    public function getFacebookLiveStatus($pageId = null)
    {
        try {
            // STATIC TESTING - Replace with your actual values
            $staticVideoId = '1550122902813653'; // Your actual video ID
            $staticPageName = 'News Live'; // Your page name

            // You can also get these from config or database
            $pageId = $pageId ?? config('services.facebook.page_id', 'irmglobe');
            $accessToken = config('services.facebook.access_token');

            Log::info('Testing Facebook Live Status with Video ID: ' . $staticVideoId);

            // Cache the result for 1 minute for testing
            $cacheKey = "facebook_live_status_{$pageId}";

            $result = Cache::remember($cacheKey, 60, function () use ($staticVideoId, $staticPageName, $pageId, $accessToken) {

                // Try to check actual Facebook live status first
                if ($accessToken) {
                    // Get live videos from the Facebook page
                    $response = Http::get("https://graph.facebook.com/v18.0/{$pageId}/live_videos", [
                        'fields' => 'id,title,description,status,embed_html,permalink_url,creation_time,live_views',
                        'access_token' => $accessToken
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();

                        // Check if there are any live videos
                        if (!empty($data['data'])) {
                            // Find the currently live video
                            foreach ($data['data'] as $video) {
                                if ($video['status'] === 'LIVE') {
                                    Log::info('Found Facebook Live Video', [
                                        'videoId' => $video['id'],
                                        'title' => $video['title'] ?? 'Live Video'
                                    ]);

                                    return [
                                        'isLive' => true,
                                        'videoId' => $video['id'],
                                        'title' => $video['title'] ?? 'Live Video',
                                        'description' => $video['description'] ?? '',
                                        'embedHtml' => $video['embed_html'],
                                        'permalinkUrl' => $video['permalink_url'],
                                        'liveViews' => $video['live_views'] ?? 0,
                                        'embedUrl' => "https://www.facebook.com/plugins/video.php?height=314&href=" . urlencode($video['permalink_url']) . "&show_text=false&width=560",
                                        'pageId' => $pageId
                                    ];
                                }
                            }
                        }
                    } else {
                        Log::error('Facebook API Error', [
                            'status' => $response->status(),
                            'body' => $response->body()
                        ]);
                    }
                }

                // If no live video found or API failed, return fallback playlist
                Log::info('No Facebook live video found, returning fallback playlist');

                return [
                    'isLive' => false,
                    'message' => 'Facebook page is not currently live - showing recent videos',
                    'pageId' => $pageId,
                    'fallbackPlaylist' => $this->facebookFallbackPlaylist,
                    'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->facebookFallbackPlaylist}&autoplay=1",
                    'debug' => [
                        'source' => 'fallback_playlist',
                        'timestamp' => now()->toISOString(),
                        'accessToken' => $accessToken ? 'configured' : 'not_configured'
                    ]
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Facebook Live Status Error: ' . $e->getMessage(), [
                'pageId' => $pageId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'isLive' => false,
                'error' => 'An error occurred while checking Facebook live status: ' . $e->getMessage(),
                'pageId' => $pageId,
                'fallbackPlaylist' => $this->facebookFallbackPlaylist,
                'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->facebookFallbackPlaylist}&autoplay=1",
                'message' => 'Error occurred - showing recent videos'
            ]);
        }
    }

    /**
     * Get combined live status for both platforms
     */
    public function getLiveStatus()
    {
        try {
            // Get YouTube status
            $youtubeResponse = $this->getYoutubeLiveStatus();
            $youtubeData = $youtubeResponse->getData(true);

            // Get Facebook status  
            $facebookResponse = $this->getFacebookLiveStatus();
            $facebookData = $facebookResponse->getData(true);

            return response()->json([
                'youtube' => $youtubeData,
                'facebook' => $facebookData,
                'lastUpdated' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'youtube' => [
                    'isLive' => false,
                    'error' => 'Failed to fetch YouTube status',
                    'fallbackPlaylist' => $this->youtubeFallbackPlaylist,
                    'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->youtubeFallbackPlaylist}&autoplay=1"
                ],
                'facebook' => [
                    'isLive' => false,
                    'error' => 'Failed to fetch Facebook status',
                    'fallbackPlaylist' => $this->facebookFallbackPlaylist,
                    'fallbackEmbedUrl' => "https://www.youtube.com/embed/videoseries?list={$this->facebookFallbackPlaylist}&autoplay=1"
                ],
                'error' => $e->getMessage(),
                'lastUpdated' => now()->toISOString()
            ]);
        }
    }

    /**
     * Get all YouTube channels from database that might have live streams
     */
    public function getChannelsWithLiveStatus()
    {
        $channels = Youtube::where('status', 1)->get();
        $channelsWithLiveStatus = [];

        foreach ($channels as $channel) {
            $channelId = null;

            // Determine if this is a channel ID or needs conversion
            if (strpos($channel->playlist_id, 'UC') === 0) {
                $channelId = $channel->playlist_id;
            } else {
                // Get channel ID from playlist
                $playlistDetailsUrl = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&id={$channel->playlist_id}&key={$this->apiKey}";
                $playlistDetails = $this->fetchData($playlistDetailsUrl);
                if (isset($playlistDetails['items'][0]['snippet']['channelId'])) {
                    $channelId = $playlistDetails['items'][0]['snippet']['channelId'];
                }
            }

            if ($channelId) {
                $liveStatus = $this->getYoutubeLiveStatus($channelId)->getData(true);
                $channelsWithLiveStatus[] = [
                    'channel' => $channel,
                    'channelId' => $channelId,
                    'liveStatus' => $liveStatus
                ];
            }
        }

        return response()->json([
            'channels' => $channelsWithLiveStatus,
            'status' => 200
        ]);
    }




    // Add these methods to your existing YoutubeController class

    /**
     * Get audio source based on live status and fallback logic
     */
    public function getAudioSource()
    {
        try {
            Log::info('Getting audio source based on live status');

            // Get current live status for both platforms
            $youtubeResponse = $this->getYoutubeLiveStatus();
            $youtubeData = $youtubeResponse->getData(true);

            $facebookResponse = $this->getFacebookLiveStatus();
            $facebookData = $facebookResponse->getData(true);

            // Priority 1: YouTube Live Audio
            if ($youtubeData['isLive'] ?? false) {
                Log::info('Using YouTube live audio', ['videoId' => $youtubeData['videoId']]);

                return response()->json([
                    'source' => 'youtube_live',
                    'type' => 'live',
                    'videoId' => $youtubeData['videoId'],
                    'title' => $youtubeData['title'],
                    'audioUrl' => $this->getYouTubeAudioUrl($youtubeData['videoId']),
                    'embedUrl' => $youtubeData['embedUrl'],
                    'isLive' => true,
                    'platform' => 'youtube'
                ]);
            }

            // Priority 2: Facebook Live Audio (if YouTube not live)
            if ($facebookData['isLive'] ?? false) {
                Log::info('Using Facebook live audio', ['videoId' => $facebookData['videoId']]);

                return response()->json([
                    'source' => 'facebook_live',
                    'type' => 'live',
                    'videoId' => $facebookData['videoId'],
                    'title' => $facebookData['title'],
                    'audioUrl' => null, // Facebook live audio extraction is complex
                    'embedUrl' => $facebookData['embedUrl'],
                    'isLive' => true,
                    'platform' => 'facebook',
                    'note' => 'Facebook live audio requires special handling'
                ]);
            }

            // Priority 3: Fallback to random playlist video
            Log::info('No live streams found, using random playlist video');

            $randomVideo = $this->getRandomPlaylistVideo();

            return response()->json([
                'source' => 'playlist_random',
                'type' => 'recorded',
                'videoId' => $randomVideo['videoId'],
                'title' => $randomVideo['title'],
                'audioUrl' => $this->getYouTubeAudioUrl($randomVideo['videoId']),
                'embedUrl' => "https://www.youtube.com/embed/{$randomVideo['videoId']}?autoplay=1",
                'isLive' => false,
                'platform' => 'youtube',
                'playlistId' => $randomVideo['playlistId']
            ]);
        } catch (\Exception $e) {
            Log::error('Audio Source Error: ' . $e->getMessage());

            return response()->json([
                'source' => 'error',
                'error' => 'Failed to get audio source: ' . $e->getMessage(),
                'isLive' => false
            ], 500);
        }
    }

    /**
     * Get a random video from the specified playlist
     */
    private function getRandomPlaylistVideo()
    {
        // Use your fallback playlist ID
        $playlistId = $this->youtubeFallbackPlaylist;

        Log::info('Getting random video from playlist', ['playlistId' => $playlistId]);

        // Get playlist videos
        $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}";
        $videos = $this->fetchAllVideos($playlistItemsUrl);

        if (empty($videos)) {
            throw new \Exception('No videos found in fallback playlist');
        }

        // Filter out unavailable videos and get random one
        $availableVideos = array_filter($videos, function ($video) {
            return isset($video['snippet']['resourceId']['videoId']) &&
                $video['snippet']['title'] !== 'Private video' &&
                $video['snippet']['title'] !== 'Deleted video';
        });

        if (empty($availableVideos)) {
            throw new \Exception('No available videos in playlist');
        }

        $randomVideo = $availableVideos[array_rand($availableVideos)];

        return [
            'videoId' => $randomVideo['snippet']['resourceId']['videoId'],
            'title' => $randomVideo['snippet']['title'],
            'playlistId' => $playlistId,
            'thumbnail' => $randomVideo['snippet']['thumbnails']['high']['url'] ??
                $randomVideo['snippet']['thumbnails']['default']['url'] ?? '',
            'publishedAt' => $randomVideo['snippet']['publishedAt']
        ];
    }

    /**
     * Generate YouTube audio stream URL
     * Note: This is a simplified approach. For production, you might need more sophisticated audio extraction
     */
    private function getYouTubeAudioUrl($videoId)
    {
        // Return embed URL with audio-focused parameters
        // For actual audio extraction, you'd need additional tools/services
        return "https://www.youtube.com/embed/{$videoId}?autoplay=1&enablejsapi=1&origin=" . config('app.url');
    }

    /**
     * Get current audio status (what's currently playing)
     */
    public function getCurrentAudioStatus()
    {
        $audioSource = $this->getAudioSource();
        $sourceData = $audioSource->getData(true);

        return response()->json([
            'currentAudio' => $sourceData,
            'timestamp' => now()->toISOString(),
            'nextCheck' => now()->addMinutes(2)->toISOString()
        ]);
    }

    /**
     * Get audio playlist for continuous playback
     */
    public function getAudioPlaylist()
    {
        try {
            $playlistId = $this->youtubeFallbackPlaylist;

            // Get all videos from the playlist
            $playlistItemsUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId={$playlistId}&key={$this->apiKey}";
            $videos = $this->fetchAllVideos($playlistItemsUrl);

            // Format for audio player
            $audioPlaylist = [];
            foreach ($videos as $video) {
                if (
                    isset($video['snippet']['resourceId']['videoId']) &&
                    $video['snippet']['title'] !== 'Private video' &&
                    $video['snippet']['title'] !== 'Deleted video'
                ) {

                    $videoId = $video['snippet']['resourceId']['videoId'];
                    $audioPlaylist[] = [
                        'id' => $videoId,
                        'title' => $video['snippet']['title'],
                        'audioUrl' => $this->getYouTubeAudioUrl($videoId),
                        'thumbnail' => $video['snippet']['thumbnails']['default']['url'] ?? '',
                        'duration' => null, // Would need additional API call to get duration
                        'publishedAt' => $video['snippet']['publishedAt']
                    ];
                }
            }

            // Shuffle for random playback
            shuffle($audioPlaylist);

            return response()->json([
                'playlist' => $audioPlaylist,
                'totalTracks' => count($audioPlaylist),
                'playlistId' => $playlistId,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            Log::error('Audio Playlist Error: ' . $e->getMessage());

            return response()->json([
                'playlist' => [],
                'error' => 'Failed to load audio playlist: ' . $e->getMessage()
            ], 500);
        }
    }
}
