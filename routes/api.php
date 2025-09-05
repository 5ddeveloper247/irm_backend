<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\LectureController;
use App\Http\Controllers\API\BookLibraryController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollCourseController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\MembershipController;
use App\Http\Controllers\API\NewsEventController;
use App\Http\Controllers\API\YoutubeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\JoinUsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/settings', [AdminController::class, 'get_settings'])->name('get_settings');
// getCampaigns
Route::get('/getCampaigns', [CampaignController::class, 'getCampaigns'])->name('getCampaigns');
// with id params
Route::get('/getSpecificCampaign/{id}', [CampaignController::class, 'getSpecificCampaign'])->name('getSpecificCampaign');
// stipe
Route::post('/stripePayment', [CampaignController::class, 'stripePayment'])->name('stripePayment');

Route::post('manualPayment', [CampaignController::class, 'manualPayment']);


// getBlogs
Route::get('/getBlogs', [BlogController::class, 'getBlogs'])->name('getBlogs');
// with id params
Route::get('/getSpecificBlog/{id}', [BlogController::class, 'getSpecificBlog'])->name('getSpecificBlog');



// Countries
Route::get('/getCountries', [CountryController::class, 'getCountries'])->name('getCountries');




// Lectures
// getLectures
Route::get('/getLectures/{categoryId?}', [LectureController::class, 'getLectures'])->name('getLectures');
// with id params
Route::get('/getSpecificLecture/{id}', [LectureController::class, 'getSpecificLecture'])->name('getSpecificLecture');
// getCategory
Route::get('/getCategory', [LectureController::class, 'getCategory'])->name('getCategory');
Route::get('/getAudioCategoriesWithAudioLectures', [LectureController::class, 'getAudioCategoriesWithAudioLectures'])->name('getAudioCategoriesWithAudioLectures');




// BookLibrary
Route::get('/getBooks', [BookLibraryController::class, 'getBooks'])->name('getBooks');
// with id params
Route::get('/getSpecificBook/{id}', [BookLibraryController::class, 'getSpecificBook'])->name('getSpecificBook');
// getLastestBooks
Route::get('/getLastestBooks', [BookLibraryController::class, 'getLastestBooks'])->name('getLastestBooks');
// downloadBook
Route::get('/downloadBook/{id}', [BookLibraryController::class, 'downloadBook'])->name('downloadBook');
// viewBook
Route::get('/viewBook/{id}', [BookLibraryController::class, 'viewBook'])->name('viewBook');



// Gallery
// getGalleryWithAttachments
Route::get('/getGalleryWithAttachments', [GalleryController::class, 'getGalleryWithAttachments'])->name('getGalleryWithAttachments');
// getGalleryAttachmentWithGalleryName
Route::get('/getGalleryAttachmentWithGalleryName', [GalleryController::class, 'getGalleryAttachmentWithGalleryName'])->name('getGalleryAttachmentWithGalleryName');
// getGalleryAttachmentWithGalleryNameAndType
Route::get('/getGalleryAttachmentWithGalleryNameAndType/{type_id?}', [GalleryController::class, 'getGalleryAttachmentWithGalleryNameAndType'])->name('getGalleryWithAttachmentAndType');

// courses
Route::get('/getCourses', [CourseController::class, 'getCourses'])->name('getCourses');
// get 3 lastest courses
Route::get('/getLastestCourses', [CourseController::class, 'getLastestCourses'])->name('getLastestCourses');
// getSpecificCourse
Route::get('/getSpecificCourse/{id}', [CourseController::class, 'getSpecificCourse'])->name('getSpecificCourse');

// Contact Us
Route::post('/saveContact', [ContactController::class, 'saveContact'])->name('saveContact');

// Memberships
// saveMembership
Route::post('/saveMembership', [MembershipController::class, 'saveMembership'])->name('saveMembership');

// getNewsEvents
Route::get('/getNewsEvents', [NewsEventController::class, 'getNewsEvents'])->name('getNewsEvents');
// getSpecificNewsEvent
Route::get('/getSpecificNewsEvent/{id}', [NewsEventController::class, 'getSpecificNewsEvent'])->name('getSpecificNewsEvent');

Route::post('/getPlaylist', [YoutubeController::class, 'getPlaylist'])->name('getPlaylist');
// getPlaylists
Route::get('/getPlaylists/{playlistId?}', [YoutubeController::class, 'getPlaylists'])->name('getPlaylists');
Route::get('/youtube-video/{videoId}', [YoutubeController::class, 'videoDetail']);

// Add this route to your existing routes/api.php file
Route::get('loadMoreVideos/{playlistId}', [YoutubeController::class, 'loadMoreVideos']);

Route::get('/youtube-live/{channelId?}', [YoutubeController::class, 'getYoutubeLiveStatus']);
Route::get('/facebook-live/{pageId?}', [YoutubeController::class, 'getFacebookLiveStatus']);
Route::get('/live-status', [YoutubeController::class, 'getLiveStatus']);


Route::get('audio-source', [YoutubeController::class, 'getAudioSource']);
Route::get('audio-status', [YoutubeController::class, 'getCurrentAudioStatus']);
Route::get('audio-playlist', [YoutubeController::class, 'getAudioPlaylist']);



// getLocations
Route::get('/getLocations', [LocationController::class, 'getLocations'])->name('getLocations');
// saveJoinUs
Route::post('/saveJoinUs', [JoinUsController::class, 'saveJoinUs'])->name('saveJoinUs');
// AUTH
Route::post('/customer_register', [AuthController::class, 'customerregister']);
Route::post('/customer_login', [AuthController::class, 'login']);
Route::middleware('auth:register')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    // verifyToken
    Route::post('verifyToken', [AuthController::class, 'verifyToken']);
    // enrollCourse
    Route::post('enrollCourse', [EnrollCourseController::class, 'enrollCourse']);
    // enrollCourseWithUserDetail
    Route::post('enrollCourseWithUserDetail', [EnrollCourseController::class, 'enrollCourseWithUserDetail']);
    // getMyCourses
    Route::get('getMyCourses', [EnrollCourseController::class, 'getMyCourses']);
    // myCourseDetail
    Route::get('myCourseDetail/{id}', [EnrollCourseController::class, 'myCourseDetail']);
    // updateCourseViewIndex
    Route::post('updateCourseViewIndex', [EnrollCourseController::class, 'updateCourseViewIndex']);
});
