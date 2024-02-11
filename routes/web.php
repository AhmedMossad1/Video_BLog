<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HomeController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(
    [
        'namespace' => 'App\Http\Controllers\Dashboard',
        'prefix' => 'admin',
        'middleware' => 'admin'
    ], function () {
        Route::get('home',[HomeController::class,'index']);
        Route::resource('users','UsersController')->except('show','delete');
        Route::resource('categories', 'CategoriesController')->except(['show']);
        Route::resource('skills', 'SkillsController')->except(['show']);
        Route::resource('tags', 'TagsController')->except(['show']);
        Route::resource('pages', 'PagesController')->except(['show']);
        Route::resource('videos', 'VideosController')->except(['show']);
        Route::resource('messages', 'MessagesController')->only(['index' , 'destroy' , 'edit']);
        Route::post('messages/replay/{id}', 'MessagesController@replay')->name('message.replay');
        Route::post('comments', 'VideosController@commentStore')->name('comment.store');
        Route::get('comments/{id}', 'VideosController@commentDelete')->name('comment.delete');
        Route::post('comments/{id}', 'VideosController@commentUpdate')->name('comment.update');
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
