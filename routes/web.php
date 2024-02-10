<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Home;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|skills
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
    [
        'namespace' => 'App\Http\Controllers\Dashboard',
        'prefix' => 'admin',
        'middleware' => 'admin'
    ], function () {
        Route::get('home',[Home::class,'index']);
        Route::resource('users','Users')->except('show','delete');
        Route::resource('categories', 'Categories')->except(['show']);
        Route::resource('skills', 'Skills')->except(['show']);
        Route::resource('tags', 'Tags')->except(['show']);
        Route::resource('pages', 'Pages')->except(['show']);
        Route::resource('videos', 'Videos')->except(['show']);
        Route::resource('messages', 'Messages')->only(['index' , 'destroy' , 'edit']);
        Route::post('messages/replay/{id}', 'Messages@replay')->name('message.replay');
        Route::post('comments', 'Videos@commentStore')->name('comment.store');
        Route::get('comments/{id}', 'Videos@commentDelete')->name('comment.delete');
        Route::post('comments/{id}', 'Videos@commentUpdate')->name('comment.update');
});
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/', 'App\Http\Controllers\HomeController@welcome')->name('frontend.landing');
Route::get('page/{id}/{slug?}', 'App\Http\Controllers\HomeController@page')->name('front.page');
Route::get('category/{id}', 'App\Http\Controllers\HomeController@category')->name('front.category');
Route::get('skill/{id}', 'App\Http\Controllers\HomeController@skills')->name('front.skill');
Route::get('tag/{id}', 'App\Http\Controllers\HomeController@tags')->name('front.tags');
Route::get('video/{id}', 'App\Http\Controllers\HomeController@video')->name('front.video');
Route::get('contact-us', 'App\Http\Controllers\HomeController@messageStore')->name('contact.store');
Route::get('Notification/Read', 'App\Http\Controllers\HomeController@markAsRead')->name('Notification.Read');
Route::get('profile/{id}/{slug?}', 'App\Http\Controllers\HomeController@profile')->name('front.profile');
Route::middleware('auth')->group(function () {
    Route::post('comments/{id}', 'App\Http\Controllers\HomeController@commentUpdate')->name('front.commentUpdate');
    Route::post('comments/{id}/create', 'App\Http\Controllers\HomeController@commentStore')->name('front.commentStore');
    Route::post('profile', 'App\Http\Controllers\HomeController@profileUpdate')->name('profile.update');
});

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
