<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AdminController::class, 'index']);
Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/forgetpassword', [AdminController::class, 'forgetpassword'])->name('forgetpass');
Route::post('/verifyForgetEmail', [AdminController::class, 'verifyForgetEmail'])->name('verifyForgetEmail');
Route::post('/verifyForgetOtp', [AdminController::class, 'verifyForgetOtp'])->name('verifyForgetOtp');
Route::post('/verifyForgetPassword', [AdminController::class, 'verifyForgetPassword'])->name('verifyForgetPassword');


Route::group(['middleware' => ['AdminAuth']], function () {

    /************** PAGE ROUTES ******************/
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/audio_lectures', [AdminController::class, 'audio_lectures'])->name('audio_lectures');
    Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('campaigns');
    Route::get('/books_library', [AdminController::class, 'books_library'])->name('books_library');
    Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
    
    // Route::post('/createStaticUser', [AdminController::class, 'createStaticUser'])->name('createStaticUser');
    

    /*************** AJAX ROUTES ****************** */
    Route::post('/getAudioLecturesPageData', [AdminController::class, 'getAudioLecturesPageData'])->name('getAudioLecturesPageData');
    Route::post('/saveAudioCategory', [AdminController::class, 'saveAudioCategory'])->name('saveAudioCategory');
    Route::post('/getSpecificAudioCategory', [AdminController::class, 'getSpecificAudioCategory'])->name('getSpecificAudioCategory');
    Route::post('/deleteAudioCategory', [AdminController::class, 'deleteAudioCategory'])->name('deleteAudioCategory');

    // Audio Lectures Page Routes
    Route::post('/saveAudioLecture', [AdminController::class, 'saveAudioLecture'])->name('saveAudioLecture');
    Route::post('/getSpecificAudioLecture', [AdminController::class, 'getSpecificAudioLecture'])->name('getSpecificAudioLecture');
    Route::post('/deleteAudioLectureAtt', [AdminController::class, 'deleteAudioLectureAtt'])->name('deleteAudioLectureAtt');
    Route::post('/deleteAudioLecture', [AdminController::class, 'deleteAudioLecture'])->name('deleteAudioLecture');
    
    // Campaigns Page Routes
    Route::post('/getCampaignsPageData', [AdminController::class, 'getCampaignsPageData'])->name('getCampaignsPageData');
    Route::post('/saveCampaign', [AdminController::class, 'saveCampaign'])->name('saveCampaign');
    Route::post('/getSpecificCampaign', [AdminController::class, 'getSpecificCampaign'])->name('getSpecificCampaign');
    Route::post('/deleteCampaign', [AdminController::class, 'deleteCampaign'])->name('deleteCampaign');
    Route::post('/deleteCampaignTask', [AdminController::class, 'deleteCampaignTask'])->name('deleteCampaignTask');
    
    // Books Library Page Routes
    Route::post('/getBooksPageData', [AdminController::class, 'getBooksPageData'])->name('getBooksPageData');
    Route::post('/saveBook', [AdminController::class, 'saveBook'])->name('saveBook');
    Route::post('/getSpecificBook', [AdminController::class, 'getSpecificBook'])->name('getSpecificBook');
    Route::post('/deleteBook', [AdminController::class, 'deleteBook'])->name('deleteBook');
    
    // Blogs Page Routes
    Route::post('/getBlogsPageData', [AdminController::class, 'getBlogsPageData'])->name('getBlogsPageData');
    Route::post('/saveBlog', [AdminController::class, 'saveBlog'])->name('saveBlog');
    Route::post('/getSpecificBlog', [AdminController::class, 'getSpecificBlog'])->name('getSpecificBlog');
    Route::post('/deleteBlog', [AdminController::class, 'deleteBlog'])->name('deleteBlog');
    
    // Gallery Type Page Routes
    Route::post('/getGalleryTypesPageData', [AdminController::class, 'getGalleryTypesPageData'])->name('getGalleryTypesPageData');
    Route::post('/saveGalleryType', [AdminController::class, 'saveGalleryType'])->name('saveGalleryType');
    Route::post('/getSpecificGalleryType', [AdminController::class, 'getSpecificGalleryType'])->name('getSpecificGalleryType');
    Route::post('/deleteGalleryType', [AdminController::class, 'deleteGalleryType'])->name('deleteGalleryType');

    // Gallery Page Routes
    Route::post('/saveGallery', [AdminController::class, 'saveGallery'])->name('saveGallery');
    Route::post('/getSpecificGallery', [AdminController::class, 'getSpecificGallery'])->name('getSpecificGallery');
    Route::post('/deleteGalleryAtt', [AdminController::class, 'deleteGalleryAtt'])->name('deleteGalleryAtt');
    Route::post('/deleteGallery', [AdminController::class, 'deleteGallery'])->name('deleteGallery');
});

// Route::get('/', function () {
//     return view('welcome');
// });
