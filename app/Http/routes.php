<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::resource('/','ArticleController');
Route::resource('/report','ReportController');
Route::resource('articles','ArticleController');
Route::resource('works','ArticleController@works');
Route::resource('artist','ArticleController@artist');
Route::resource('subscription','ArticleController@subscription');
Route::resource('search','ArticleController@search');
Route::resource('articles/{article_id}/like','ArticleController@like');

Route::resource('articles/{article_id}/comments','CommentController');

Route::resource('articles/usercheck','ArticleController@usercheck');
Route::resource('articles/emailcheck','ArticleController@emailcheck');
Route::get('auth/logout','Auth\AuthController@logout');

Route::resource('mypage/{user_id}/update','MemberController@update');
Route::resource('mypage/{user_id}/edit','MemberController@edit');
Route::resource('mypage','MemberController@mypage');

Route::resource('userpage','MemberController@userpage');
Route::resource('follow','MemberController@follow');
Route::resource('followcancel','MemberController@followcancel');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

// social facebook
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

// social naver
Route::get('/auth/naver', 'NaverAuthController@redirectToProvider');
Route::get('/auth/naver/callback', 'NaverAuthController@handleProviderCallback');

// social kakao
// Route::get('/auth/kakao', 'KakaoAuthController@redirectToProvider');
// Route::get('/auth/kakao/callback', 'KakaoAuthController@handleProviderCallback');

