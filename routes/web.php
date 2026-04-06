<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/aboutMe', [HomeController::class, 'aboutMe'])->name('about');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// ===== POSTS =====
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}/download', [PostController::class, 'download'])->name('posts.download');
Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('posts.bookmarks');

// ===== 0-DAYS ARTICLES =====
Route::get('/posts/cve', [PostController::class, 'cve'])->name('posts.cve');

// ===== PHP SECURITY ARTICLES =====
Route::get('/posts/php-introduction',       [PostController::class, 'phpIntroduction'])->name('posts.php-introduction');
Route::get('/posts/php-vulnerabilities-list',[PostController::class, 'phpVulnerabilitiesList'])->name('posts.php-vulnerabilities-list');
Route::get('/posts/php-sqli',               [PostController::class, 'phpSqli'])->name('posts.php-sqli');
Route::get('/posts/php-lfi-rfi',            [PostController::class, 'phpLfiRfi'])->name('posts.php-lfi-rfi');
Route::get('/posts/php-deserialization',    [PostController::class, 'phpDeserialization'])->name('posts.php-deserialization');
Route::get('/posts/php-type-juggling',      [PostController::class, 'phpTypeJuggling'])->name('posts.php-type-juggling');
Route::get('/posts/php-rce',                [PostController::class, 'phpRce'])->name('posts.php-rce');
Route::get('/posts/php-xss',                [PostController::class, 'phpXss'])->name('posts.php-xss');
Route::get('/posts/php-ssrf',               [PostController::class, 'phpSsrf'])->name('posts.php-ssrf');

// ===== GENERIC SHOW (keep last — catches /{slug} that don't match above) =====
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// ===== AUTH =====
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/password/reset',         [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email',        [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset',        [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
