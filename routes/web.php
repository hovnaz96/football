<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


Route::namespace('Home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/image-view','HomeController@imageView')->name('image.view');
    Route::post('/video-view','HomeController@videoView')->name('video.view');
    Route::get('/videos','HomeController@videos')->name('videos');
    Route::get('/photos','HomeController@photos')->name('photos');
    Route::get('/users','HomeController@users')->name('users');
    Route::namespace('User')->group(function () {
        Route::get('/account-settings','UserController@edit')->name('user.edit');
        Route::get('/user-profile/{slug}','UserController@userProfile')->name('user.profile');
        Route::get('/activity','UserController@activity')->name('user.activity');
        Route::post('/basic-info-update','UserController@basicInfoUpdate')->name('user.update.basic_info');
        Route::post('/password-update','UserController@updatePassword')->name('user.update.password');
        Route::post('/social-links-update','UserController@updateSocialLinks')->name('user.update.social_links');
        Route::post('/description-update','UserController@updateDescription')->name('user.update.description');
        Route::post('/upload-image-profile','FileController@uploadProfileImage')->name('upload.image.profile');
        Route::post('/upload-images','FileController@uploadImages')->name('upload.images');
        Route::post('/upload-videos','FileController@uploadVideos')->name('upload.videos');
        Route::post('/upload-thumbnail/{id}','FileController@uploadVideoThumbnail')->name('upload.thumbnail');
        Route::post('/user-follow','UserController@userFollow')->name('user.follow');
        Route::post('/user-like-image','UserController@userLikeImage')->name('user.like.image');
        Route::post('/user-like-video','UserController@userLikeVideo')->name('user.like.video');
        Route::post('/user-delete-image','UserController@userDeleteImage')->name('user.image.delete');
        Route::post('/user-delete-video','UserController@userDeleteVideo')->name('user.video.delete');
//        Route::get('messages', 'ChatsController@fetchMessages');
        Route::get('messagesUsers', 'ChatsController@fetchUsers');
        Route::get('messagesUsersHeader', 'ChatsController@fetchUsersHeader');
        Route::post('messages', 'ChatsController@sendMessage');
        Route::post('messages_ajax', 'ChatsController@sendMessageAjax');
        Route::post('messages/{id}', 'ChatsController@getMessagesByID');
        Route::get('/messages/{id?}/{name?}', 'ChatsController@index')->name('messages');
    });
});

