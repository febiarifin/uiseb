<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/register', [RegisterController::class, 'index'])->name('register.index')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login.index')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->name('login.store')->middleware('guest');

Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);

Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');
Route::get('upload/payment/{id}', [RegisterController::class, 'uploadPayment'])->name('upload.payment');
Route::put('upload/payment/{id}', [RegisterController::class, 'uploadPaymentStore'])->name('upload.payment.store');
Route::get('upload/paper/{id}', [RegisterController::class, 'uploadPaper'])->name('upload.paper');
Route::put('upload/paper/{id}', [RegisterController::class, 'uploadPaperStore'])->name('upload.paper.store');

Route::get('registrations', [RegisterController::class, 'registrationUser'])->name('registration.user');
Route::get('registration/validation', [RegisterController::class, 'registrationValidation'])->name('registration.validation');
Route::get('registration/reviews', [RegisterController::class, 'registrationReviews'])->name('registration.reviews');
Route::get('registration/history', [RegisterController::class, 'registrationHistory'])->name('registration.history');
Route::get('registration/detail/{id}', [RegisterController::class, 'registrationDetail'])->name('registration.detail');
Route::get('registration/validate/{id}', [RegisterController::class, 'registrationValidate'])->name('registration.validate');
Route::get('registration/acc/{id}', [RegisterController::class, 'registrationAcc'])->name('registration.acc');
Route::put('registration/revisi/{id}', [RegisterController::class, 'registrationrevisi'])->name('registration.revisi');
Route::get('registration/review/{id}', [RegisterController::class, 'registrationreview'])->name('registration.review');
Route::get('registration/paper-acc/{id}', [RegisterController::class, 'registrationPaperAcc'])->name('registration.paper.acc');
Route::put('registration/paper-revisi/{id}', [RegisterController::class, 'registrationPaperRevisi'])->name('registration.paper.revisi');
Route::get('registrations/list', [RegisterController::class, 'registrationList'])->name('registration.list');
Route::get('registrations/create/{id}', [RegisterController::class, 'registrationCreate'])->name('registration.create');
Route::post('registrations/store', [RegisterController::class, 'registrationstore'])->name('registration.store');

Route::get('profile',[UserController::class, 'profile'])->name('user.profile');
Route::post('profile',[UserController::class, 'updateProfile'])->name('user.update.profile');
Route::post('update-password',[UserController::class, 'updatePassword'])->name('user.update.password');
