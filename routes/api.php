<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\API\CampaignController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CountryController;
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


// Blogs
// getBlogs
Route::get('/getBlogs', [BlogController::class, 'getBlogs'])->name('getBlogs');
// with id params
Route::get('/getSpecificBlog/{id}', [BlogController::class, 'getSpecificBlog'])->name('getSpecificBlog');

// Countries
Route::get('/getCountries', [CountryController::class, 'getCountries'])->name('getCountries');
