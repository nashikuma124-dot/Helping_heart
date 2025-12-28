<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\TopController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\InquiryManagementController;

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
Route::get('/inquiry/{property}', [InquiryController::class, 'form'])
    ->name('inquiry.form');

Route::post('/inquiry/confirm', [InquiryController::class, 'confirm'])
    ->name('inquiry.confirm');

Route::post('/inquiry/complete', [InquiryController::class, 'complete'])
    ->name('inquiry.complete');

// ★ エラー画面（route('error') を通す）
Route::view('/error', 'error')->name('error');


/*
|--------------------------------------------------------------------------
| 認証関連
|--------------------------------------------------------------------------
*/

// 8〜10. 会員登録
Route::get('/signup', [RegisterController::class, 'show'])
    ->name('signup');

Route::post('/signup/confirm', [RegisterController::class, 'confirm'])
    ->name('signup.confirm');

Route::post('/signup/complete', [RegisterController::class, 'complete'])
    ->name('signup.complete');

// 11. メールログイン
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

// ★ ログアウト（header.blade.php の route('logout') を通す）
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('top');
})->name('logout');


// 12〜14. LINEログイン
Route::get('/login/line', [LineLoginController::class, 'redirect'])
    ->name('line.login');

Route::get('/login/line/callback', [LineLoginController::class, 'callback']);

Route::get('/line/complete', [LineLoginController::class, 'complete'])
    ->name('line.complete');

Route::get('/line/error', [LineLoginController::class, 'error'])
    ->name('line.error');

// 21〜23. パスワード再設定
Route::get('/password/reset', [LoginController::class, 'reset'])
    ->name('password.request');

Route::post('/password/reset', [LoginController::class, 'send']);

Route::get('/password/reset/form/{token}', [LoginController::class, 'form'])
    ->name('password.form');

Route::post('/password/reset/complete', [LoginController::class, 'complete'])
    ->name('password.complete');


/*
|--------------------------------------------------------------------------
| ログイン後（会員）
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // 15. マイページ
    Route::get('/mypage', [MyPageController::class, 'index'])
        ->name('mypage.index');

    // 16. お気に入り
    Route::get('/favorite', [FavoriteController::class, 'index'])
        ->name('favorite.index');

    Route::post('/favorite/{property}', [FavoriteController::class, 'store'])
        ->name('favorite.store');

    Route::delete('/favorite/{property}', [FavoriteController::class, 'destroy'])
        ->name('favorite.destroy');

    // 17〜20. 会員情報
    Route::get('/user', [MyPageController::class, 'show'])
        ->name('user.info');

    Route::get('/user/edit', [MyPageController::class, 'edit'])
        ->name('user.edit');

    Route::post('/user/edit/confirm', [MyPageController::class, 'confirm'])
        ->name('user.confirm');

    Route::post('/user/delete', [MyPageController::class, 'delete'])
        ->name('user.delete');

    // 24〜28. チャット相談
    Route::prefix('consultation')->name('consultation.')->group(function () {

        Route::get('/', [ConsultationController::class, 'index'])
            ->name('index');

        Route::get('/home', [ConsultationController::class, 'homeLine'])
            ->name('home');

        Route::get('/home/chat', [ConsultationController::class, 'homeChat'])
            ->name('home.chat');

        Route::get('/welfare', [ConsultationController::class, 'welfareLine'])
            ->name('welfare');

        Route::get('/welfare/chat', [ConsultationController::class, 'welfareChat'])
            ->name('welfare.chat');
    });
});


/*
|--------------------------------------------------------------------------
| 管理者
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/properties', [PropertyManagementController::class, 'index'])
            ->name('properties.index');

        Route::get('/properties/{property}', [PropertyManagementController::class, 'show'])
            ->name('properties.show');

        Route::get('/properties/{property}/edit', [PropertyManagementController::class, 'edit'])
            ->name('properties.edit');

        Route::post('/properties/{property}/update', [PropertyManagementController::class, 'update'])
            ->name('properties.update');

        Route::get('/users', [UserManagementController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{user}', [UserManagementController::class, 'show'])
            ->name('users.show');

        Route::get('/inquiries', [InquiryManagementController::class, 'index'])
            ->name('inquiries.index');

        Route::get('/consultations', [ConsultationController::class, 'adminIndex'])
            ->name('consultations.index');
    });


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('error');
});
