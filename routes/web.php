<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/aboutMe', [HomeController::class, 'aboutMe'])->name('about');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/cve', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post:slug}/download', [PostController::class, 'download'])->name('posts.download');
// Route::post('/posts/{post:slug}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('posts.bookmarks');

// Custom Authentication Routes (Replace Auth::routes())
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Forgot Password Routes (optional)
    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
// Route::prefix('admin')->name('admin.')->middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

//     // Category routes
//     Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
//     // Route::put('/edit-categ/{category}', [App\Http\Controllers\Admin\CategoryController::class,"update"])->name('categories.test');
//     // Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

//     // Post routes
//     Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
// });


// Route::prefix('admin')
//     ->name('admin.')
//     ->middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])
//     ->group(function () {
//         Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
//         Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
//         Route::post('/edit-category', [App\Http\Controllers\Admin\CategoryController::class,"update"])->name('categories.edit.post');
//         Route::post('/ckeditor/upload', [App\Http\Controllers\Admin\CategoryController::class, 'ckeditorUpload'])->name('ckeditor.upload');
//         Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
//         Route::post('/edit-post', [App\Http\Controllers\Admin\PostController::class,"update"])->name('posts.edit.post');
//         Route::get('/posts/{post}/download', [App\Http\Controllers\Admin\PostController::class, 'download'])->name('posts.download');

//     });

// // Route::get('/set-locale/{locale}', function ($locale) {
// //     if (in_array($locale, ['en', 'fr', 'ar'])) {
// //         session()->put('locale', $locale);
// //         app()->setLocale($locale);
// //     }
// //     return redirect()->back();
// // })->name('locale.setting');

// // routes/web.php
// Route::post('/locale', function (Request $request) {
//     $request->validate([
//         'locale' => 'required|in:en,fr,ar'
//     ]);

//     session()->put('locale', $request->locale);

//     app()->setLocale($request->locale);

//     return redirect()->back();
// })->name('locale.setting');


// // routes/web.php (add this temporarily)
// Route::get('/test-session', function() {
//     $data = [
//         'session_id' => session()->getId(),
//         'session_locale' => session('locale', 'NOT SET'),
//         'app_locale' => app()->getLocale(),
//         'all_session_data' => session()->all(),
//         'cookies' => request()->cookie(),
//         'session_driver' => config('session.driver'),
//         'session_lifetime' => config('session.lifetime'),
//     ];

//     // Also try to set locale manually
//     session()->put('test_key', 'test_value_' . time());

//     return response()->json($data);
// });
