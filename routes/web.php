<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;

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

// Auth
Auth::routes();
Auth::routes(['verify' => true]);

// Social Auth
Route::get('login/{provider}', [SocialController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialController::class, 'Callback']);

// Home
Route::get('/', 'HomeController@index')->name('home');

// User
Route::group(['prefix' => '@{username}', 'as' => 'user.'], function () {
    Route::get('', [UserController::class, 'profile'])->name('done');
    Route::get('pending', [UserController::class, 'profile'])->name('pending');
    Route::get('products', [UserController::class, 'profile'])->name('products');
    Route::get('questions', [UserController::class, 'profile'])->name('questions');
    Route::get('answers', [UserController::class, 'profile'])->name('answers');
    Route::get('following', [UserController::class, 'profile'])->name('following');
    Route::get('followers', [UserController::class, 'profile'])->name('followers');
});

// Settings
Route::group(['prefix' => 'settings', 'as' => 'user.settings.', 'middleware' => ['auth']], function () {
    Route::get('', 'UserController@profileSettings')->name('profile');
    Route::get('account', 'UserController@accountSettings')->name('account');
    Route::get('patron', 'UserController@patronSettings')->name('patron');
    Route::get('password', 'UserController@passwordSettings')->name('password');
    Route::get('notifications', 'UserController@notificationsSettings')->name('notifications');
    Route::get('integrations', 'UserController@integrationsSettings')->name('integrations');
    Route::get('export', 'UserController@exportAccount')->name('export');
    Route::get('delete', 'UserController@deleteSettings')->name('delete');
});

// Notifications
Route::group(['prefix' => 'notifications', 'as' => 'notifications.', 'middleware' => ['auth']], function () {
    Route::view('', 'notifications.unread')->name('unread');
    Route::view('all', 'notifications.all')->name('all');
});

// Suspended
Route::get('suspended', 'UserController@suspended')->name('suspended');

// Avatar
Route::get('avatar/{username}.png', 'UserController@avatar')->name('avatar');

// Webhooks
Route::group(['prefix' => 'webhook'], function () {
    Route::post('web/{token}', 'WebhookController@web');
});

// Product
Route::group(['prefix' => 'product/{slug}', 'as' => 'product.'], function () {
    Route::get('', 'ProductController@profile')->name('done');
    Route::get('pending', 'ProductController@profile')->name('pending');
    Route::get('updates', 'ProductController@profile')->name('updates');
});

// Products
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('', 'ProductController@newest')->name('newest');
    Route::get('launched', 'ProductController@launched')->name('launched');
});

// Question
Route::group(['prefix' => 'question', 'as' => 'question.'], function () {
    Route::get('{id}', 'QuestionController@question')->name('question');
});

// Questions
Route::group(['prefix' => 'questions', 'as' => 'questions.'], function () {
    Route::get('', 'QuestionController@newest')->name('newest');
    Route::get('unanswered', 'QuestionController@unanswered')->name('unanswered');
    Route::get('popular', 'QuestionController@popular')->name('popular');
});

// Search
Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
    Route::get('', 'SearchController@search')->name('home');
    Route::get('tasks', 'SearchController@tasks')->name('tasks');
    Route::get('comments', 'SearchController@comments')->name('comments');
    Route::get('questions', 'SearchController@questions')->name('questions');
    Route::get('answers', 'SearchController@answers')->name('answers');
    Route::get('products', 'SearchController@products')->name('products');
    Route::get('users', 'SearchController@users')->name('users');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['staff']], function () {
    Route::get('users', 'AdminController@users')->name('users');
    Route::get('adminbar', 'AdminController@toggle')->name('adminbar');
});

// Patron
Route::group(['prefix' => 'patron', 'as' => 'patron.'], function () {
    Route::get('', 'PatronController@patron')->name('home');
});

// Paddle Integration
Route::post('paddle/webhook', 'PatronController@handleWebhook')->name('paddle.webhook');

// Dark mode
Route::get('darkmode', 'UserController@darkMode')->name('darkmode')->middleware('patron');

// Single Task
Route::get('task/{id}', 'TaskController@task')->name('task');

// Zen mode tasks
Route::get('tasks', 'TaskController@tasks')->name('tasks')->middleware('auth');

// Pages
Route::view('about', 'pages.about')->name('about');
Route::view('reputation', 'pages.reputation')->name('reputation');
Route::view('terms', 'pages.terms')->name('terms');
Route::view('privacy', 'pages.privacy')->name('privacy');
Route::view('security', 'pages.security')->name('security');
Route::get('open', 'PagesController@open')->name('open');
Route::get('deals', 'PagesController@deals')->name('deals');

// https://web.dev/change-password-url
Route::get('.well-known/change-password', function () {
    return redirect()->route('user.settings.password');
});

// Sitemaps
Route::get('sitemap_users.txt', 'SitemapController@users');
Route::get('sitemap_products.txt', 'SitemapController@products');
Route::get('sitemap_questions.txt', 'SitemapController@questions');
