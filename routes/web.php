<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('public.index');
Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('profile', [UserController::class, 'updateProfile'])->name('user.update.profile');
    Route::post('update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
    Route::get('registration/detail/{id}', [RegisterController::class, 'registrationDetail'])->name('registration.detail');

    Route::group(['middleware' => 'isAdmin'], function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('pages', PageController::class);
        Route::get('pages/change/{page}', [PageController::class, 'change'])->name('pages.change');
        Route::resource('timelines', TimelineController::class);
        Route::resource('contacts', ContactController::class);
        Route::resource('speakers', SpeakerController::class);
        Route::resource('articles', ArticleController::class);
        Route::get('registration/history', [RegisterController::class, 'registrationHistory'])->name('registration.history');
    });

    Route::group(['middleware' => 'isAdminReviewer'], function () {
        Route::get('registration/validation', [RegisterController::class, 'registrationValidation'])->name('registration.validation');
        Route::get('registration/validate/{id}', [RegisterController::class, 'registrationValidate'])->name('registration.validate');
        Route::get('registration/acc/{id}', [RegisterController::class, 'registrationAcc'])->name('registration.acc');
        Route::put('registration/revisi/{id}', [RegisterController::class, 'registrationrevisi'])->name('registration.revisi');
    });

    Route::group(['middleware' => 'isAdminReviewerEditor'], function () {
        Route::get('registration/reviews', [RegisterController::class, 'registrationReviews'])->name('registration.reviews');
        Route::get('registration/review/{id}', [RegisterController::class, 'registrationreview'])->name('registration.review');
        Route::get('registration/paper-acc/{id}', [RegisterController::class, 'registrationPaperAcc'])->name('registration.paper.acc');
        Route::put('registration/paper-revisi/{id}', [RegisterController::class, 'registrationPaperRevisi'])->name('registration.paper.revisi');
    });

    Route::group(['middleware' => 'isPeserta'], function () {
        Route::get('registrations', [RegisterController::class, 'registrationUser'])->name('registration.user');
        Route::get('upload/payment/{id}', [RegisterController::class, 'uploadPayment'])->name('upload.payment');
        Route::put('upload/payment/{id}', [RegisterController::class, 'uploadPaymentStore'])->name('upload.payment.store');
        Route::get('upload/paper/{id}', [RegisterController::class, 'uploadPaper'])->name('upload.paper');
        Route::put('upload/paper/{id}', [RegisterController::class, 'uploadPaperStore'])->name('upload.paper.store');
        Route::get('registrations/list', [RegisterController::class, 'registrationList'])->name('registration.list');
        Route::get('registrations/create/{id}', [RegisterController::class, 'registrationCreate'])->name('registration.create');
        Route::post('registrations/store', [RegisterController::class, 'registrationstore'])->name('registration.store');
    });
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});
