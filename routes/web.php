<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\ContactController;
// Payment
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookOrderController;
use App\Http\Controllers\EnrollCourseController;
use App\Http\Controllers\ContactController as WebContactController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\WorkLocationController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JoinUsController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Artisan;

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

// try {
//     DB::connection()->getPdo();
//     echo 'Database connection is established!';
// } catch (\Exception $e) {
//     echo 'Could not connect to the database. Please check your configuration.<br>' . $e->getMessage();
// }

Route::get('/', [AdminController::class, 'index']);
Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/forgetpassword', [AdminController::class, 'forgetpassword'])->name('forgetpass');
Route::post('/verifyForgetEmail', [AdminController::class, 'verifyForgetEmail'])->name('verifyForgetEmail');
Route::post('/verifyForgetOtp', [AdminController::class, 'verifyForgetOtp'])->name('verifyForgetOtp');
Route::post('/verifyForgetPassword', [AdminController::class, 'verifyForgetPassword'])->name('verifyForgetPassword');
//testApi
Route::get('/test1', [AdminController::class, 'testApi'])->name('testApi');

Route::group(['middleware' => ['AdminAuth']], function () {
   
    Route::group(['middleware' => ['CheckSubAdminAccess']], function () {
        // add third group middleware sections
        /************** PAGE ROUTES ******************/
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/audio_lectures', [AdminController::class, 'audio_lectures'])->name('audio_lectures');
        Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('campaigns');
        Route::get('/books_library', [AdminController::class, 'books_library'])->name('books_library');
        Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
        Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
        Route::get('/news_events', [AdminController::class, 'news_events'])->name('news_events');
        Route::get('/irm_settings', [AdminController::class, 'settings'])->name('irm_settings');
        // payments
        Route::get('/payments', [PaymentController::class, 'payments'])->name('payments');
        // bookorders
        Route::get('/bookorders', [BookOrderController::class, 'bookorders'])->name('bookorders');
        // enrollCourses
        Route::get('/enrollCourses', [EnrollCourseController::class, 'enrollCourses'])->name('enrollCourses');
        // viewContact
        Route::get('/viewContact', [WebContactController::class, 'viewContact'])->name('viewContact');
        // memberships
        Route::get('/memberships', [MembershipController::class, 'memberships'])->name('memberships');
        // youtube
        Route::get('/youtube', [YoutubeController::class, 'youtube'])->name('youtube');
        // worklocations
        Route::get('/worklocation', [WorkLocationController::class, 'worklocation'])->name('worklocation');
        // sub-admins
        Route::get('/sub-admins', [UserController::class, 'subAdmins'])->name('sub-admins');
        // joinUs
        Route::get('/joinUs', [JoinUsController::class, 'joinUs'])->name('joinUs');
    });

    // saveAdminProfile
    Route::post('/saveAdminProfile', [UserController::class, 'saveAdminProfile'])->name('saveAdminProfile');
    // admin.settings.update
    Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    // getTasks
    Route::post('/getTasks', [AdminController::class, 'getTasks'])->name('getTasks');
    // getPaymentsPageData
    Route::post('/getPaymentsPageData', [PaymentController::class, 'getPaymentsPageData'])->name('getPaymentsPageData');
    // getCampaignPayments
    Route::post('/getCampaignPayments', [PaymentController::class, 'getCampaignPayments'])->name('getCampaignPayments');
    // getBookOrdersPageData
    Route::post('/getBookOrdersPageData', [BookOrderController::class, 'getBookOrdersPageData'])->name('getBookOrdersPageData');
    // getBookOrders
    Route::post('/getBookOrders', [BookOrderController::class, 'getBookOrders'])->name('getBookOrders');
    // changeStatus
    Route::post('/changeStatus', [BookOrderController::class, 'changeStatus'])->name('changeStatus');
    // viewBookOrder
    Route::post('/viewBookOrder', [BookOrderController::class, 'viewBookOrder'])->name('viewBookOrder');

    // getAllEnrollCourse
    Route::post('/getEnrollCoursesPageData', [EnrollCourseController::class, 'getEnrollCoursesPageData'])->name('getEnrollCoursesPageData');


    // Contact

    // getContactPageData 
    Route::post('/getContactPageData', [WebContactController::class, 'getContactPageData'])->name('getContactPageData');
    // getContactDetail
    Route::post('/getContactDetail', [WebContactController::class, 'getContactDetail'])->name('getContactDetail');
    // saveRelyContact
    Route::post('/saveRelyContact', [WebContactController::class, 'saveRelyContact'])->name('saveRelyContact');


    // Memberships

    // getMembershipsPageData
    Route::post('/getMembershipsPageData', [MembershipController::class, 'getMembershipsPageData'])->name('getMembershipsPageData');
    // url = '/viewMember';
    Route::post('/viewMember', [MembershipController::class, 'viewMember'])->name('viewMember');

    // saveYoutube
    Route::post('/saveYoutube', [YoutubeController::class, 'saveYoutube'])->name('saveYoutube');
    // getYoutubePageData
    Route::post('/getYoutubePageData', [YoutubeController::class, 'getYoutubePageData'])->name('getYoutubePageData');
    // getSpecificYoutube
    Route::post('/getSpecificYoutube', [YoutubeController::class, 'getSpecificYoutube'])->name('getSpecificYoutube');
    // deleteYoutubePlaylist
    Route::post('/deleteYoutubePlaylist', [YoutubeController::class, 'deleteYoutubePlaylist'])->name('deleteYoutubePlaylist');


    // saveWorklocation
    Route::post('/saveWorklocation', [WorkLocationController::class, 'saveWorklocation'])->name('saveWorklocation');
    // getWorklocationPageData
    Route::post('/getWorklocationPageData', [WorkLocationController::class, 'getWorklocationPageData'])->name('getWorklocationPageData');
    // getSpecificWorklocation
    Route::post('/getSpecificWorklocation', [WorkLocationController::class, 'getSpecificWorklocation'])->name('getSpecificWorklocation');
    // deleteWorklocation
    Route::post('/deleteWorklocation', [WorkLocationController::class, 'deleteWorklocation'])->name('deleteWorklocation');


    // getUsersPageData
    Route::post('/getUsersPageData', [UserController::class, 'getUsersPageData'])->name('getUsersPageData');
    // getSpecificUser
    Route::post('/getSpecificUser', [UserController::class, 'getSpecificUser'])->name('getSpecificUser');
    // saveUser
    Route::post('/saveUser', [UserController::class, 'saveUser'])->name('saveUser');
    // deleteUser
    Route::post('/deleteUser', [UserController::class, 'deleteUser'])->name('deleteUser');
    // getJoinUsPageData
    Route::post('/getJoinUsPageData', [JoinUsController::class, 'getJoinUsPageData'])->name('getJoinUsPageData');
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
    // manual_payment_form
    Route::post('/manual_payment_form', [AdminController::class, 'manual_payment_form'])->name('manual_payment_form');
    Route::post('/getSpecificCampaign', [AdminController::class, 'getSpecificCampaign'])->name('getSpecificCampaign');
    Route::post('/deleteCampaign', [AdminController::class, 'deleteCampaign'])->name('deleteCampaign');
    Route::post('/deleteCampaignTask', [AdminController::class, 'deleteCampaignTask'])->name('deleteCampaignTask');

    // Books Library Page Routes
    Route::post('/getBooksPageData', [AdminController::class, 'getBooksPageData'])->name('getBooksPageData');
    // saveBookCategory 
    Route::post('/saveBookCategory', [AdminController::class, 'saveBookCategory'])->name('saveBookCategory');
    // deleteBookCategory
    Route::post('/deleteBookCategory', [AdminController::class, 'deleteBookCategory'])->name('deleteBookCategory');
    // getSpecificBookCategory
    Route::post('/getSpecificBookCategory', [AdminController::class, 'getSpecificBookCategory'])->name('getSpecificBookCategory');
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

    // Course Type Page Routes
    Route::post('/getCourseTypesPageData', [AdminController::class, 'getCourseTypesPageData'])->name('getCourseTypesPageData');
    Route::post('/saveCourseType', [AdminController::class, 'saveCourseType'])->name('saveCourseType');
    Route::post('/getSpecificCourseType', [AdminController::class, 'getSpecificCourseType'])->name('getSpecificCourseType');
    Route::post('/deleteCourseType', [AdminController::class, 'deleteCourseType'])->name('deleteCourseType');

    // Gallery Page Routes
    Route::post('/saveCourse', [AdminController::class, 'saveCourse'])->name('saveCourse');
    Route::post('/getSpecificCourse', [AdminController::class, 'getSpecificCourse'])->name('getSpecificCourse');
    Route::post('/deleteCourseVideo', [AdminController::class, 'deleteCourseVideo'])->name('deleteCourseVideo');
    Route::post('/deleteCourse', [AdminController::class, 'deleteCourse'])->name('deleteCourse');

    // News & Events Page Routes
    Route::post('/getNewsEventsPageData', [AdminController::class, 'getNewsEventsPageData'])->name('getNewsEventsPageData');
    Route::post('/saveEvent', [AdminController::class, 'saveEvent'])->name('saveEvent');
    Route::post('/getSpecificEvent', [AdminController::class, 'getSpecificEvent'])->name('getSpecificEvent');
    Route::post('/deleteEventAtt', [AdminController::class, 'deleteEventAtt'])->name('deleteEventAtt');
    Route::post('/deleteEvent', [AdminController::class, 'deleteEvent'])->name('deleteEvent');
});
// run migration
Route::get('/run-migration', function () {
    $migrations = [
        // 'database/migrations/2025_04_07_050330_create_book_category_table.php',
        // 'database/migrations/2025_04_07_050450_add_book_category_id_to_books_library_table.php',
        'database/migrations/2025_04_09_095713_add_total_course_duration_to_courses_table.php',
    ];
    foreach ($migrations as $migration) {
        Artisan::call('migrate', [
            '--path' => $migration,
            '--force' => true,
        ]);
    }
    return 'Migration created!';
});
// Route::get('/', function () {
//     return view('welcome');
// });
// sendMessage
// Route::get('/sendMessage', function () {
//     $to = '+923058757575';
//     $body = 'Hello, this is a test message from UltraMsg API.';
//     $response = app('App\Http\Controllers\WhatsAppController')->sendMessage($to, $body);
//     return $response;
// });