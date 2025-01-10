<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\AudioCategory;
use App\Models\AudioLecture;
use App\Models\AudioLectureAttachment;
use App\Models\Campaign;
use App\Models\CampaignTask;
use App\Models\BookLibrary;
use App\Models\Blog;
use App\Models\GalleryType;
use App\Models\Gallery;
use App\Models\GalleryAttachment;
use App\Models\CourseType;
use App\Models\Course;
use App\Models\Setting;
use App\Models\CourseVideo;
use App\Models\NewsEvent;
use App\Models\NewsEventAttachment;




class AdminController extends Controller
{
    public function index(Request $request){
        Auth::logout();
        return view('login');
    }
    
    public function createStaticUser(Request $request){
        
        // $password = 'Admin123#';

        // $User = new User();
        // $User->name = 'Admin';
        // $User->username = 'ADMIN';
        // $User->email = 'admin@5dsolutions.ae';
        // $User->password = bcrypt($password);
        // $User->role = '1';  // 1:Admin, 2:User
        // $User->status = '1';
        // $User->save();
        
        // return 'User Created Successfully...';
    }
    // for api testing
    public function get_settings(Request $request){
        $settings = Setting::first();
        if($settings == null){
            $settings = new \stdClass();
            $settings->company_name = '';
            $settings->company_logo = '';
            $settings->company_address = '';
            $settings->company_phone = '';
            $settings->company_email = '';
            $settings->company_website = '';
            $settings->facebook_link = '';
            $settings->twitter_link = '';
            $settings->instagram_link = '';
            $settings->linkedin_link = '';
            $settings->youtube_link = '';
        }
        if($settings->company_logo != ''){
            $settings->company_logo = url($settings->company_logo);
        }
        return response()->json(['status' => 200, 'message' => 'Settings Fetched Successfully.', 'data' => $settings]);
    }
    // settings
    public function settings(Request $request){
        // dd('settings');
        // $settings = \DB::table('settings')->first();
        $settings = Setting::first();
        if($settings == null){
            $settings = new \stdClass();
            $settings->company_name = '';
            $settings->company_logo = '';
            $settings->company_address = '';
            $settings->company_phone = '';
            $settings->company_email = '';
            $settings->company_website = '';
            $settings->facebook_link = '';
            $settings->twitter_link = '';
            $settings->instagram_link = '';
            $settings->linkedin_link = '';
            $settings->youtube_link = '';
        }
        // dd($settings);        
        return view('admin/settings', ['settings' => $settings]);
    }
    // updateSettings
    public function updateSettings(Request $request){
        $validator = Validator::make($request->all(), [
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=128,height=128', // Must be an image file
            'company_name' => 'required|max:50|string',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|email',

        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }
       
        // save settings
        // $settings = \DB::table('settings')->first();
        $settings = Setting::first();
         // image upload
         if($request->hasFile('company_logo')){
            $company_logo = 'uploads/images/' . time() . '_' . $request->file('company_logo')->getClientOriginalName();
            $request->file('company_logo')->move(public_path('uploads/images'), $company_logo);
            $settings->company_logo = $company_logo;
        }else{
            $company_logo = $settings->company_logo;
        }
        if($settings == null){
            \DB::table('settings')->insert([
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_phone' => $request->company_phone,
                'company_email' => $request->company_email,
                'company_logo' => $company_logo,
                'company_website' => $request->company_website,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'youtube_link' => $request->youtube_link,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }else{
            // $company_logo = $settings->company_logo;
            \DB::table('settings')->where('id', $settings->id)->update([
                'company_name' => $request->company_name,
                'company_address' => $request->company_address,
                'company_phone' => $request->company_phone,
                'company_email' => $request->company_email,
                'company_logo' => $company_logo,
                'company_website' => $request->company_website,
                'facebook_link' => $request->facebook_link,
                'twitter_link' => $request->twitter_link,
                'instagram_link' => $request->instagram_link,
                'linkedin_link' => $request->linkedin_link,
                'youtube_link' => $request->youtube_link,
                'updated_at' => Carbon::now(),
            ]);
        }
        return response()->json(['status' => 200, 'message' => 'Settings Updated Successfully.']);
    }

    public function dashboard(Request $request){
        
        return view('admin/dashboard');
    }

    public function audio_lectures(Request $request){
        
        return view('admin/audio_lectures');
    }

    public function campaigns(Request $request){
        
        return view('admin/campaigns');
    }

    public function books_library(Request $request){
        
        return view('admin/books_library');
    }

    public function blogs(Request $request){
        
        return view('admin/blogs');
    }

    public function gallery(Request $request){
        
        return view('admin/gallery_types');
    }

    public function courses(Request $request){
        
        return view('admin/courses');
    }

    public function news_events(Request $request){
        
        return view('admin/news_events');
    }

    public function forgetpassword(Request $request){
        
        return view('forgetpassword');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            if($user->role == 1 || $user->role == 3){
                return redirect()->intended('/dashboard');

            }else{
            
                return redirect('login')->withErrors([
                    'email' => 'The provided credentials is not valid.',
                ]);
            
            }
        }
        // Authentication failed, redirect back to the login page with error message
        return redirect('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

        return redirect('dashboard');
    }

    public function logout(Request $request)
    {
        // Log out the currently authenticated user
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the admin login page
        return redirect('login');
    }

    public function verifyForgetEmail(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = \DB::table('users')
                        ->where('email', $value)
                        ->where('role', 1)
                        ->where('status', 1)
                        ->first();
        
                    if (!$user) {
                        $fail("The $attribute must belong to an active user with admin role.");
                    }
                },
            ],
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $otp = random_int(100000, 999999);
        
            $user = User::where('email', $request->email)->first();
            $user->otp = $otp;
            $user->save();
            
            $mailData = [];
            $mailData['otp'] = $otp;
            $mailData['username'] = $user->name;
            $body = view('email.forget_otp_template', $mailData);
            // sendMail($user->first_name, $user->email, 'Password Reset Request', $body);
            sendMail($user->first_name, 'hamza@5dsolutions.ae', 'Password Reset Request', $body);

            return response()->json([
                'success' => true,
                'message' => 'Email Verified, Now add OTP which is send to your email address.'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function verifyForgetOtp(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = \DB::table('users')
                        ->where('email', $value)
                        ->where('role', 1)
                        ->where('status', 1)
                        ->first();
        
                    if (!$user) {
                        $fail("The $attribute must belong to an active user with admin role.");
                    }
                },
            ],
            'otp' => 'required|min:6',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $user = User::where('email', $request->email)->first();
            
            if($user->otp == $request->otp){

                return response()->json([
                    'success' => true,
                    'message' => 'OTP (One Time Password) verified successfully.'
                ], 200);
            }
            

            return response()->json([
                'success' => false,
                'message' => 'Please enter valid OTP (One Time Password).'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function verifyForgetPassword(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = \DB::table('users')
                        ->where('email', $value)
                        ->where('role', 1)
                        ->where('status', 1)
                        ->first();
        
                    if (!$user) {
                        $fail("The $attribute must belong to an active user with admin role.");
                    }
                },
            ],
            'otp' => 'required|min:6',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
        ], [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $User = User::where('email', $request->email)->first();
            
            if($User->otp == $request->otp){

                $password = $request->input('password');

                $User->password = bcrypt($password);
                $User->otp = '';
                $User->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Password change successfully, Now login with your new password.'
                ], 200);

            }
            

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong...'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    /* ******************** Audio Lectures Page Code Start Here ********************* */
    public function getAudioLecturesPageData(Request $request)
    {
        
        $data['category_list'] = AudioCategory::get();
        $data['lecture_list'] = AudioLecture::with(['category'])->get();
        

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveAudioCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_title' => 'required|max:50',
            'category_description' => 'required|max:250',
            'category_status' => 'required',
            
        ]);


        if($request->category_id != ''){
            $AudioCategory = AudioCategory::find($request->category_id);
        }else{
            $AudioCategory = new AudioCategory;
        }
        
        $AudioCategory->title = $request->category_title;
        $AudioCategory->description = $request->category_description;
        $AudioCategory->date = Carbon::now()->format('Y-m-d');
        $AudioCategory->status = $request->category_status;
        
        $AudioCategory->save();

        if($request->category_id != ''){
            return response()->json(['status' => 200, 'message' => "Audio Category Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Audio Category Saved Successfully."]);
        }
    }
    
    public function getSpecificAudioCategory(Request $request)
    {
        
        $data['category_detail'] = AudioCategory::where('id', $request->category_id)->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteAudioCategory(Request $request)
    {
        
        $AudioCategory = AudioCategory::find($request->category_id);

        if ($AudioCategory) {

            $AudioCategory->audio_lectures()->delete();
            $AudioCategory->delete();
            
            return response()->json(['status' => 200, 'message' => "Audio Category Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Audio Category not found."]);
        }
    }

    public function saveAudioLecture(Request $request)
    {
        $validatedData = $request->validate([
            'audio_category' => 'required',
            'audio_title' => 'required|max:50',
            'audio_description' => 'required|max:250',
            'audio_status' => 'required',
            
        ]);
        if($request->audio_id == ''){
            $validatedData = $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
                'audio_files' => 'required|array', // Ensure it's an array of files
                'audio_files.*' => 'mimes:mp3,MP3|max:5120', // Each file must be an MP3 and max 5MB
                
            ]);
        }


        if($request->audio_id != ''){
            $AudioLecture = AudioLecture::find($request->audio_id);
        }else{
            $AudioLecture = new AudioLecture;
        }
        
        $AudioLecture->category_id = $request->audio_category;
        $AudioLecture->title = $request->audio_title;
        $AudioLecture->description = $request->audio_description;
        $AudioLecture->date = Carbon::now()->format('Y-m-d');
        $AudioLecture->status = $request->audio_status;
        
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/images'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $AudioLecture->thumbnail = $thumbnailPath . '/' . $thumbnailName;
        }

        $AudioLecture->save();

        // Save the audio files
        if ($request->hasFile('audio_files')) {
            foreach ($request->file('audio_files') as $audioFile) {
                $audioName = 'audio_' . time() . '_' . $audioFile->getClientOriginalName(); 
                $audioPath = 'uploads/audio'; 
                $audioFile->move(public_path($audioPath), $audioName); 

                $AudioLectureAttachment = new AudioLectureAttachment();
                $AudioLectureAttachment->audio_id = $AudioLecture->id; 
                $AudioLectureAttachment->name = $audioFile->getClientOriginalName();
                $AudioLectureAttachment->path = $audioPath . '/' . $audioName;
                $AudioLectureAttachment->save(); 
            }
        }


        if($request->audio_id != ''){
            return response()->json(['status' => 200, 'message' => "Audio Lecture Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Audio Lecture Saved Successfully."]);
        }
    }

    public function getSpecificAudioLecture(Request $request)
    {
        
        $data['lecture_detail'] = AudioLecture::where('id', $request->lecture_id)->with(['attachments'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteAudioLectureAtt(Request $request)
    {
        
        AudioLectureAttachment::where('id', $request->attachment_id)->delete();
        
        return response()->json(['status' => 200, 'message' => "Audio Deleted Successfully."]);
    }

    public function deleteAudioLecture(Request $request)
    {
        $AudioLecture = AudioLecture::find($request->lecture_id);

        if ($AudioLecture) {
            // Delete associated attachments
            $AudioLecture->attachments()->delete();

            // Delete the AudioLecture record
            $AudioLecture->delete();
            
            return response()->json(['status' => 200, 'message' => "Audio Lecture Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Audio Lecture not found."]);
        }
        
        
    }
    /* ******************** Audio Lectures Page Code End Here ********************* */

    /* ******************** Campaigns Page Code Start Here ********************* */
    public function getCampaignsPageData(Request $request)
    {
        
        $data['campaign_list'] = Campaign::get();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveCampaign(Request $request)
    {
        $validatedData = $request->validate([
            'campaign_title' => 'required|max:50',
            'campaign_tags' => 'required|max:50',
            'campaign_description' => 'required|max:250',
            'campaign_target_amount' => 'required',
            'campaign_status' => 'required',
            'tasks' => 'nullable|array', // Tasks is optional, but if present, it must be an array
            'tasks.*.title' => 'required_with:tasks|string|max:100', // Validate title only if tasks array is present
            'tasks.*.amount' => 'required_with:tasks|numeric|min:1', // Validate amount only if tasks array is present
        ], [
            'tasks.*.title.required_with' => 'Each task title field is required.', // Custom error message for task titles
            'tasks.*.amount.required_with' => 'Each task amount field is required.', // Custom error message for task titles
        ]);

        if($request->campaign_id == ''){
            $validatedData = $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
            ]);
        }else{
            $validatedData = $request->validate([
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
            ]);
        }


        if($request->campaign_id != ''){
            $Campaign = Campaign::find($request->campaign_id);
        }else{
            $Campaign = new Campaign;
        }
        
        $Campaign->title = $request->campaign_title;
        $Campaign->tags = $request->campaign_tags;
        $Campaign->description = $request->campaign_description;
        $Campaign->date = Carbon::now()->format('Y-m-d');
        $Campaign->target_amount = $request->campaign_target_amount;
        $Campaign->status = $request->campaign_status;
        
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/images'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $Campaign->thumbnail = $thumbnailPath . '/' . $thumbnailName;
        }

        $Campaign->save();

        $tasksArr = isset($request->tasks) ? $request->tasks : [];

        if(count($tasksArr) > 0){
            foreach($tasksArr as $task){
                if(isset($task['id']) && $task['id'] != ''){
                    $CampaignTask = CampaignTask::where('id', $task['id'])->first();
                }else{
                    $CampaignTask = new CampaignTask();
                }

                $CampaignTask->campaign_id = $Campaign->id;
                $CampaignTask->title = $task['title'];
                $CampaignTask->task_amount = $task['amount'];
                $CampaignTask->save();
            }
        }

        if($request->campaign_id != ''){
            return response()->json(['status' => 200, 'message' => "Campaign Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Campaign Saved Successfully."]);
        }
    }

    public function getSpecificCampaign(Request $request)
    {
        
        $data['campaign_detail'] = Campaign::where('id', $request->campaign_id)->with(['tasks'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function deleteCampaignTask(Request $request)
    {
        
        CampaignTask::where('id', $request->task_id)->delete();
        
        return response()->json(['status' => 200, 'message' => "Task Deleted Successfully."]);
    }

    public function deleteCampaign(Request $request)
    {
        $Campaign = Campaign::find($request->campaign_id);

        if ($Campaign) {
            $Campaign->tasks()->delete();
            $Campaign->delete();
            
            return response()->json(['status' => 200, 'message' => "Campaign Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Campaign not found."]);
        }
    }
    /* ******************** Campaigns Page Code End Here ********************* */
    
    /* ******************** Books Library Page Code Start Here ********************* */
    public function getBooksPageData(Request $request)
    {
        
        $data['books_list'] = BookLibrary::get();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveBook(Request $request)
    {
        $validatedData = $request->validate([
            'book_title' => 'required|max:50',
            'book_description' => 'required|max:250',
            'book_price' => 'required',
            'book_status' => 'required',
        ]);
        
        if($request->book_id == ''){
            
            $validatedData = $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
                'book' => 'required|mimes:pdf|max:10240',
            ]);
        }else{
            $validatedData = $request->validate([
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
                'book' => 'nullable|mimes:pdf|max:10240',
            ]);
        }

        if($request->book_id != ''){
            $BookLibrary = BookLibrary::find($request->book_id);
        }else{
            $BookLibrary = new BookLibrary;
        }
        
        $BookLibrary->title = $request->book_title;
        $BookLibrary->description = $request->book_description;
        $BookLibrary->date = Carbon::now()->format('Y-m-d');
        $BookLibrary->price = $request->book_price;
        $BookLibrary->status = $request->book_status;
        
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/images'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $BookLibrary->thumbnail = $thumbnailPath . '/' . $thumbnailName;
        }

        // Save the thumbnail file
        if ($request->hasFile('book')) {
            $file = $request->file('book');
            $fileName = 'book' . time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/books'; 
            $file->move(public_path($filePath), $fileName);
            $BookLibrary->book = $filePath . '/' . $fileName;
        }

        $BookLibrary->save();

        if($request->book_id != ''){
            return response()->json(['status' => 200, 'message' => "Book Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Book Saved Successfully."]);
        }
    }

    public function getSpecificBook(Request $request)
    {
        
        $data['book_detail'] = BookLibrary::where('id', $request->book_id)->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function deleteBook(Request $request)
    {
        $BookLibrary = BookLibrary::find($request->book_id);

        if ($BookLibrary) {

            $BookLibrary->delete();
            
            return response()->json(['status' => 200, 'message' => "Book Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Book not found."]);
        }
    }
    /* ******************** Books Library Page Code End Here ********************* */

    /* ******************** Blogs Page Code Start Here ********************* */
    public function getBlogsPageData(Request $request)
    {
        
        $data['blogs_list'] = Blog::get();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveBlog(Request $request)
    {
        $validatedData = $request->validate([
            'blog_author_name' => 'required|max:50',
            'blog_title' => 'required|max:50',
            'blog_tags' => 'required|max:100',
            'blog_description' => 'required',
            'blog_published_date' => 'required|date',
            'blog_end_date' => 'required|date|after:blog_published_date',
            'blog_status' => 'required',
        ]);
        
        if($request->blog_id == ''){
            
            $validatedData = $request->validate([
                'blog_published_date' => 'required|date|after_or_equal:today',
                'blog_end_date' => 'required|date|after:blog_published_date',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
            ]);
        }else{
            $validatedData = $request->validate([
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
            ]);
        }

        if($request->blog_id != ''){
            $Blog = Blog::find($request->blog_id);
        }else{
            $Blog = new Blog;
            $Blog->date = Carbon::now()->format('Y-m-d');
        }
        
        $Blog->author_name = $request->blog_author_name;
        $Blog->title = $request->blog_title;
        $Blog->tags = $request->blog_tags;
        $Blog->description = $request->blog_description;
        $Blog->published_date = $request->blog_published_date;
        $Blog->end_date = $request->blog_end_date;
        $Blog->status = $request->blog_status;
        
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/images'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $Blog->thumbnail = $thumbnailPath . '/' . $thumbnailName;
        }

        $Blog->save();

        if($request->blog_id != ''){
            return response()->json(['status' => 200, 'message' => "Blog Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Blog Saved Successfully."]);
        }
    }

    public function getSpecificBlog(Request $request)
    {
        
        $data['blog_detail'] = Blog::where('id', $request->blog_id)->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function deleteBlog(Request $request)
    {
        $Blog = Blog::find($request->blog_id);

        if ($Blog) {

            $Blog->delete();
            
            return response()->json(['status' => 200, 'message' => "Blog Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Blog not found."]);
        }
    }
    /* ******************** Blogs Page Code End Here ********************* */

    /* ******************** Photo Gallery Page Code Start Here ********************* */
    public function getGalleryTypesPageData(Request $request)
    {
        
        $data['type_list'] = GalleryType::get();
        $data['gallery_list'] = Gallery::with(['type'])->get();
        

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveGalleryType(Request $request)
    {
        $validatedData = $request->validate([
            'type_title' => 'required|max:50',
            'type_description' => 'required|max:250',
            'type_status' => 'required',
        ]);

        if($request->type_id != ''){
            $GalleryType = GalleryType::find($request->type_id);
        }else{
            $GalleryType = new GalleryType;
            $GalleryType->date = Carbon::now()->format('Y-m-d');
        }
        
        $GalleryType->title = $request->type_title;
        $GalleryType->description = $request->type_description;
        $GalleryType->status = $request->type_status;
        
        $GalleryType->save();

        if($request->type_id != ''){
            return response()->json(['status' => 200, 'message' => "Gallery Type Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Gallery Type Saved Successfully."]);
        }
    }
    
    public function getSpecificGalleryType(Request $request)
    {
        
        $data['type_detail'] = GalleryType::where('id', $request->type_id)->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteGalleryType(Request $request)
    {
        
        $GalleryType = GalleryType::find($request->type_id);

        if ($GalleryType) {

            $GalleryType->galleries()->delete();
            $GalleryType->delete();
            
            return response()->json(['status' => 200, 'message' => "Type Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Type not found."]);
        }
    }

    public function saveGallery(Request $request)
    {
        $validatedData = $request->validate([
            'gallery_type' => 'required',
            'gallery_title' => 'required|max:50',
            'gallery_description' => 'required|max:250',
            'gallery_status' => 'required',
            
        ]);
        if($request->gallery_id == ''){
            $validatedData = $request->validate([
                'images' => 'required|array',
                'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }


        if($request->gallery_id != ''){
            $Gallery = Gallery::find($request->gallery_id);
        }else{
            $Gallery = new Gallery;
            $Gallery->date = Carbon::now()->format('Y-m-d');
        }
        
        $Gallery->type_id = $request->gallery_type;
        $Gallery->title = $request->gallery_title;
        $Gallery->description = $request->gallery_description;
        $Gallery->status = $request->gallery_status;
        
        $Gallery->save();

        // Save the audio files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = 'image_' . time() . '_' . $imageFile->getClientOriginalName(); 
                $filePath = 'uploads/images'; 
                $imageFile->move(public_path($filePath), $fileName); 

                $GalleryAttachment = new GalleryAttachment();
                $GalleryAttachment->gallery_id = $Gallery->id; 
                $GalleryAttachment->name = $imageFile->getClientOriginalName();
                $GalleryAttachment->path = $filePath . '/' . $fileName;
                $GalleryAttachment->save(); 
            }
        }

        if($request->gallery_id != ''){
            return response()->json(['status' => 200, 'message' => "Gallery Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Gallery Saved Successfully."]);
        }
    }

    public function getSpecificGallery(Request $request)
    {
        
        $data['gallery_detail'] = Gallery::where('id', $request->gallery_id)->with(['attachments'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteGalleryAtt(Request $request)
    {
        
        GalleryAttachment::where('id', $request->attachment_id)->delete();
        
        return response()->json(['status' => 200, 'message' => "Gallery Image Deleted Successfully."]);
    }

    public function deleteGallery(Request $request)
    {
        $Gallery = Gallery::find($request->gallery_id);

        if ($Gallery) {

            $Gallery->attachments()->delete();
            $Gallery->delete();
            
            return response()->json(['status' => 200, 'message' => "Gallery Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Gallery not found."]);
        }
        
        
    }
    /* ******************** Photo Gallery Page Code End Here ********************* */


    /* ******************** Course Page Code Start Here ********************* */
    public function getCourseTypesPageData(Request $request)
    {
        
        $data['type_list'] = CourseType::get();
        $data['course_list'] = Course::with(['type'])->get();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function saveCourseType(Request $request)
    {
        $validatedData = $request->validate([
            'type_title' => 'required|max:50',
            'type_description' => 'required|max:250',
            'type_status' => 'required',
        ]);

        if($request->type_id != ''){
            $CourseType = CourseType::find($request->type_id);
        }else{
            $CourseType = new CourseType;
            $CourseType->date = Carbon::now()->format('Y-m-d');
        }
        
        $CourseType->title = $request->type_title;
        $CourseType->description = $request->type_description;
        $CourseType->status = $request->type_status;
        
        $CourseType->save();

        if($request->type_id != ''){
            return response()->json(['status' => 200, 'message' => "Course Type Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Course Type Saved Successfully."]);
        }
    }
    
    public function getSpecificCourseType(Request $request)
    {
        
        $data['type_detail'] = CourseType::where('id', $request->type_id)->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteCourseType(Request $request)
    {
        
        $CourseType = CourseType::find($request->type_id);

        if ($CourseType) {
            
            $CourseType->courses()->delete();
            $CourseType->delete();
            
            return response()->json(['status' => 200, 'message' => "Type Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Type not found."]);
        }
    }

    public function saveCourse(Request $request)
    {
        $validatedData = $request->validate([
            'course_type' => 'required',
            'course_title' => 'required|max:50',
            'course_description' => 'required|string',
            'course_instructor' => 'required|max:50',
            'course_duration' => 'required|numeric|max_digits:5',
            'course_total_lectures' => 'required|numeric|max_digits:3',
            'course_level' => 'required',
            'course_language' => 'required',
            'course_certificate' => 'required',
            'course_status' => 'required',
            
            
        ]);
        if($request->course_id == ''){
            $validatedData = $request->validate([
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
                'videos' => 'required|array', // Videos array is required
                'videos.*.url' => [
                    'required', 
                    'string', 
                    'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'
                ]
            ], [
                'videos.*.url.required' => 'Each video url field is required.', 
                'videos.*.url.regex' => 'Each video url must be youtube video url.',
            ]);
        }else{
            $validatedData = $request->validate([
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // Must be an image file
                'videos' => 'nullable|array', // Videos array is required
                'videos.*.url' => [
                    'required_with:videos', 
                    'string', 
                    'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'
                ]
            ], [
                'videos.*.url.required_with' => 'Each video url field is required.', 
                'videos.*.url.regex' => 'Each video url must be youtube video url.',
            ]);
        }


        if($request->course_id != ''){
            $Course = Course::find($request->course_id);
        }else{
            $Course = new Course;
            $Course->date = Carbon::now()->format('Y-m-d');
        }
        
        $Course->type_id = $request->course_type;
        $Course->title = $request->course_title;
        $Course->description = $request->course_description;
        $Course->instructor_name = $request->course_instructor;
        $Course->duration_minutes = $request->course_duration;
        $Course->total_lectures = $request->course_total_lectures;
        $Course->level = $request->course_level;
        $Course->language = $request->course_language;
        $Course->certificate = $request->course_certificate;
        $Course->status = $request->course_status;
        
        // Save the thumbnail file
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = 'thumbnail_' . time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = 'uploads/images'; 
            $thumbnailFile->move(public_path($thumbnailPath), $thumbnailName);
            $Course->thumbnail = $thumbnailPath . '/' . $thumbnailName;
        }

        $Course->save();

        $videosArr = isset($request->videos) ? $request->videos : [];

        if(count($videosArr) > 0){
            foreach($videosArr as $video){
                if(isset($video['id']) && $video['id'] != ''){
                    $CourseVideo = CourseVideo::where('id', $video['id'])->first();
                }else{
                    $CourseVideo = new CourseVideo();
                }

                $CourseVideo->course_id = $Course->id;
                $CourseVideo->video_url = $video['url'];
                $CourseVideo->save();
            }
        }
        
        if($request->course_id != ''){
            return response()->json(['status' => 200, 'message' => "Course Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Course Saved Successfully."]);
        }
    }

    public function getSpecificCourse(Request $request)
    {
        
        $data['course_detail'] = Course::where('id', $request->course_id)->with(['videos'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteCourseVideo(Request $request)
    {
        $CourseVideo = CourseVideo::find($request->video_id);

        if ($CourseVideo) {

            $CourseVideo->delete();
            
            return response()->json(['status' => 200, 'message' => "Course Video Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Course Video not found."]);
        }
    }

    public function deleteCourse(Request $request)
    {
        $Course = Course::find($request->course_id);

        if ($Course) {

            $Course->delete();
            
            return response()->json(['status' => 200, 'message' => "Course Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Course not found."]);
        }
    }
    /* ******************** Course Page Code End Here ********************* */

    /* ******************** News & Events Page Code Start Here ********************* */
    public function getNewsEventsPageData(Request $request)
    {
        
        $data['events_list'] = NewsEvent::get();
        

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function saveEvent(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            // add validation on event date between start and end date
            'event_date' => 'required|date|after_or_equal:start_date|before_or_equal:end_date',
            'event_time' => 'required',
            'event_type' => 'required',
            'recurring_type' => 'required_if:event_type,Recurring',
            'repeat_on' => 'required_if:recurring_type,Weekly|array',
            'location' => 'required',
            'status' => 'required',
        ]);
        if($request->event_id == ''){
            $validatedData = $request->validate([
                'images' => 'required|array',
                'images.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }

        if($request->event_id != ''){
            $NewsEvent = NewsEvent::find($request->event_id);
        }else{
            $NewsEvent = new NewsEvent;
            $NewsEvent->date = Carbon::now()->format('Y-m-d');
        }
        
        $NewsEvent->title = $request->title;
        $NewsEvent->description = $request->description;
        $NewsEvent->event_date = $request->event_date;
        $NewsEvent->start_date = $request->start_date;
        $NewsEvent->end_date = $request->end_date;
        $NewsEvent->event_time = $request->event_time;
        $NewsEvent->type = $request->event_type;
        $NewsEvent->recurring_type = $request->recurring_type;
        if($request->repeat_on != ''){
            $NewsEvent->repeat_on = json_encode($request->repeat_on, true);
        }else{
            $NewsEvent->repeat_on = '[]';
        }
        
        $NewsEvent->location = $request->location;
        $NewsEvent->status = $request->status;
        $NewsEvent->save();

        // Save the image files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = 'image_' . time() . '_' . $imageFile->getClientOriginalName(); 
                $filePath = 'uploads/images'; 
                $imageFile->move(public_path($filePath), $fileName); 

                $NewsEventAttachment = new NewsEventAttachment();
                $NewsEventAttachment->news_id = $NewsEvent->id; 
                $NewsEventAttachment->name = $imageFile->getClientOriginalName();
                $NewsEventAttachment->path = $filePath . '/' . $fileName;
                $NewsEventAttachment->save(); 
            }
        }

        if($request->event_id != ''){
            return response()->json(['status' => 200, 'message' => "Event Updated Successfully."]);
        }else{
            return response()->json(['status' => 200, 'message' => "Event Saved Successfully."]);
        }
    }

    public function getSpecificEvent(Request $request)
    {
        
        $data['event_detail'] = NewsEvent::where('id', $request->event_id)->with(['attachments'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    public function deleteEventAtt(Request $request)
    {
        
        $NewsEventAttachment = NewsEventAttachment::find($request->attachment_id);

        if ($NewsEventAttachment) {

            $NewsEventAttachment->delete();
            
            return response()->json(['status' => 200, 'message' => "Event image Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Event image not found."]);
        }
    }

    public function deleteEvent(Request $request)
    {
        $NewsEvent = NewsEvent::find($request->event_id);

        if ($NewsEvent) {

            $NewsEvent->attachments()->delete();
            $NewsEvent->delete();
            
            return response()->json(['status' => 200, 'message' => "Event Deleted Successfully."]);
        } else {
            return response()->json(['status' => 400, 'message' => "Event not found."]);
        }
    }
    /* ******************** News & Events Page Code End Here ********************* */
}
