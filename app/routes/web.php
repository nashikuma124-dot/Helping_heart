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

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 共通（ログイン不要）
|--------------------------------------------------------------------------
*/

// 1. トップページ
Route::get('/', [TopController::class, 'index'])->name('top');

// 2. 物件検索
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');

// 3. 検索結果一覧
Route::get('/result', [PropertyController::class, 'result'])->name('property.result');

// 4. 物件詳細
Route::get('/property/{property}', [PropertyController::class, 'show'])
    ->name('property.detail');

// 5〜7. 問い合わせ
Route::get('/inquiry/{property}', [InquiryController::class, 'form'])->name('inquiry.form');
Route::post('/inquiry/confirm', [InquiryController::class, 'confirm'])->name('inquiry.confirm');
Route::post('/inquiry/complete', [InquiryController::class, 'complete'])->name('inquiry.complete');


/*
|--------------------------------------------------------------------------
| 認証関連
|--------------------------------------------------------------------------
*/

// 8〜10. 会員登録
Route::get('/signup', [RegisterController::class, 'show'])->name('signup');
Route::post('/signup/confirm', [RegisterController::class, 'confirm'])->name('signup.confirm');
Route::post('/signup/complete', [RegisterController::class, 'complete'])->name('signup.complete');

// 11. メールログイン
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 12〜14. LINEログイン
Route::get('/login/line', [LineLoginController::class, 'redirect'])->name('line.login');
Route::get('/login/line/callback', [LineLoginController::class, 'callback']);
Route::get('/line/complete', [LineLoginController::class, 'complete'])->name('line.complete');
Route::get('/line/error', [LineLoginController::class, 'error'])->name('line.error');

// 21〜23. パスワード再設定
Route::get('/password/reset', [LoginController::class, 'reset'])->name('password.request');
Route::post('/password/reset', [LoginController::class, 'send']);
Route::get('/password/reset/form/{token}', [LoginController::class, 'form'])->name('password.form');
Route::post('/password/reset/complete', [LoginController::class, 'complete'])->name('password.complete');


/*
|--------------------------------------------------------------------------
| ログイン後（会員）
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // 15. マイページ
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');

    // 16. お気に入り
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
    Route::post('/favorite/{property}', [FavoriteController::class, 'store']);
    Route::delete('/favorite/{property}', [FavoriteController::class, 'destroy']);

    // 17〜20. 会員情報
    Route::get('/user', [MyPageController::class, 'show'])->name('user.info');
    Route::get('/user/edit', [MyPageController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/confirm', [MyPageController::class, 'confirm']);
    Route::post('/user/delete', [MyPageController::class, 'delete']);

    // 24〜28. チャット相談
    Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation');
    Route::get('/consultation/home', [ConsultationController::class, 'homeLine']);
    Route::get('/consultation/home/chat', [ConsultationController::class, 'homeChat']);
    Route::get('/consultation/welfare', [ConsultationController::class, 'welfareLine']);
    Route::get('/consultation/welfare/chat', [ConsultationController::class, 'welfareChat']);
});


/*
|--------------------------------------------------------------------------
| 管理者
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // 29. 管理者トップ
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 30〜32. 物件管理
    Route::get('/properties', [PropertyManagementController::class, 'index']);
    Route::get('/properties/{property}', [PropertyManagementController::class, 'show']);
    Route::get('/properties/{property}/edit', [PropertyManagementController::class, 'edit']);
    Route::post('/properties/{property}/update', [PropertyManagementController::class, 'update']);

    // 33〜34. 会員管理
    Route::get('/users', [UserManagementController::class, 'index']);
    Route::get('/users/{user}', [UserManagementController::class, 'show']);

    // 35. 問い合わせ管理
    Route::get('/inquiries', [InquiryManagementController::class, 'index']);

    // 36. 相談管理
    Route::get('/consultations', [ConsultationController::class, 'adminIndex']);
});


/*
|--------------------------------------------------------------------------
| 37. エラー
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('error');
});

