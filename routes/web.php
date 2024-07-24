<?php

use App\Http\Controllers\AbstrakController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
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
        Route::resource('settings', SettingController::class);
        Route::get('registration/history', [RegisterController::class, 'registrationHistory'])->name('registration.history');
        Route::get('registration/validation', [RegisterController::class, 'registrationValidation'])->name('registration.validation');
        Route::get('registration/validate/{id}', [RegisterController::class, 'registrationValidate'])->name('registration.validate');
        Route::get('paper/validate-publication', [PaperController::class, 'publishedReview'])->name('paper.published.review');
        Route::get('paper/validate-publication-acc/{paper}', [PaperController::class, 'publishedAcc'])->name('paper.published.acc');
        Route::get('paper/history-publication', [PaperController::class, 'publishedPaper'])->name('paper.published.history');
    });

    Route::group(['middleware' => 'isAdminReviewer'], function () {
        Route::get('registration/acc/{id}', [RegisterController::class, 'registrationAcc'])->name('registration.acc');
        Route::put('registration/revisi/{id}', [RegisterController::class, 'registrationrevisi'])->name('registration.revisi');
    });

    Route::group(['middleware' => 'isAdminEditor'], function () {
        Route::put('abstraks/reviewer/store/{id}', [AbstrakController::class, 'reviewerStore'])->name('abstraks.reviewer.store');
        Route::get('abstraks/reviewer/delete/{id}', [AbstrakController::class, 'reviewerDelete'])->name('abstraks.reviewer.delete');
        Route::put('papers/reviewer/store/{id}', [PaperController::class, 'reviewerStore'])->name('papers.reviewer.store');
        Route::get('papers/reviewer/delete/{id}', [PaperController::class, 'reviewerDelete'])->name('papers.reviewer.delete');
        Route::get('videos/review/{video}', [VideoController::class, 'review'])->name('videos.review');
        Route::put('videos/review/store/{id}', [VideoController::class, 'reviewStore'])->name('videos.review.store');
    });

    Route::group(['middleware' => 'isAdminReviewerEditor'], function () {
        Route::get('registration/reviews', [RegisterController::class, 'registrationReviews'])->name('registration.reviews');
        Route::get('registration/review/{id}', [RegisterController::class, 'registrationreview'])->name('registration.review');
        Route::get('registration/paper-acc/{id}', [RegisterController::class, 'registrationPaperAcc'])->name('registration.paper.acc');
        Route::put('registration/paper-revisi/{id}', [RegisterController::class, 'registrationPaperRevisi'])->name('registration.paper.revisi');
        Route::get('abstraks/review/{abstrak}', [AbstrakController::class, 'review'])->name('abstraks.review');
        Route::put('abstraks/review/store/{id}', [AbstrakController::class, 'reviewStore'])->name('abstraks.review.store');
        Route::get('papers/review/{paper}', [PaperController::class, 'review'])->name('papers.review');
        Route::put('papers/review/store/{id}', [PaperController::class, 'reviewStore'])->name('papers.review.store');
    });

    Route::group(['middleware' => 'isPeserta'], function () {
        Route::get('registrations', [RegisterController::class, 'registrationUser'])->name('registration.user');
        Route::get('upload/payment/{id}', [RegisterController::class, 'uploadPayment'])->name('upload.payment');
        Route::put('upload/payment/{id}', [RegisterController::class, 'uploadPaymentStore'])->name('upload.payment.store');
        Route::get('upload/paper/{id}', [RegisterController::class, 'uploadPaper'])->name('upload.paper');
        Route::put('upload/paper/{id}', [RegisterController::class, 'uploadPaperStore'])->name('upload.paper.store');
        Route::get('paper/published/{paper}', [PaperController::class, 'published'])->name('paper.published');
        Route::get('registrations/list', [RegisterController::class, 'registrationList'])->name('registration.list');
        Route::get('registrations/print-invoice/{registration}', [RegisterController::class, 'printInvoice'])->name('registration.print.invoice');
        Route::get('registrations/create/{id}', [RegisterController::class, 'registrationCreate'])->name('registration.create');
        Route::post('registrations/store', [RegisterController::class, 'registrationstore'])->name('registration.store');
        Route::resource('abstraks', AbstrakController::class);
        Route::resource('papers', PaperController::class);
        Route::resource('videos', VideoController::class);
    });

    Route::get('print/review/{id}', [PDFController::class, 'print_review'])->name('print.review');
});

// Route::get('/storage-link', function () {
//     Artisan::call('storage:link');
// });

// Forgot Password
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
