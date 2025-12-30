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
use App\Http\Controllers\Ajax\LocationController;

/*
|--------------------------------------------------------------------------
| 共通（ログイン不要）
|--------------------------------------------------------------------------
*/

// トップページ
Route::get('/', [TopController::class, 'index'])->name('top');

// 物件（一覧・詳細）※ ResourceController
Route::resource('properties', PropertyController::class)
    ->only(['index', 'show']);

// お問い合わせ（確認画面ありのため一部手動）
Route::get('inquiries/{property}', [InquiryController::class, 'create'])
    ->name('inquiries.create');

Route::post('inquiries/confirm', [InquiryController::class, 'confirm'])
    ->name('inquiries.confirm');

Route::post('inquiries', [InquiryController::class, 'store'])
    ->name('inquiries.store');

// エラー画面
Route::view('/error', 'error')->name('error');


/*
|--------------------------------------------------------------------------
| 認証関連
|--------------------------------------------------------------------------
*/

// 会員登録
Route::get('/signup', [RegisterController::class, 'show'])->name('signup');
Route::post('/signup/confirm', [RegisterController::class, 'confirm'])->name('signup.confirm');
Route::post('/signup/complete', [RegisterController::class, 'complete'])->name('signup.complete');

// ログイン（メール）
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// ログアウト
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('top');
})->name('logout');

// LINEログイン
Route::get('/login/line', [LineLoginController::class, 'redirect'])->name('line.login');
Route::get('/login/line/callback', [LineLoginController::class, 'callback']);
Route::get('/line/complete', [LineLoginController::class, 'complete'])->name('line.complete');
Route::get('/line/error', [LineLoginController::class, 'error'])->name('line.error');

// パスワード再設定
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

    // マイページ（ResourceController）
    Route::resource('mypage', MyPageController::class)
        ->only(['index', 'edit', 'update']);

    // 会員情報（追加）
    Route::get('/user', [MyPageController::class, 'show'])->name('user.info');
    Route::post('/user/delete', [MyPageController::class, 'delete'])->name('user.delete');

    // お気に入り
    Route::resource('favorites', FavoriteController::class)
        ->only(['index', 'store', 'destroy']);

    // チャット相談
    Route::prefix('consultation')->name('consultation.')->group(function () {
        Route::get('/', [ConsultationController::class, 'index'])->name('index');
        Route::get('/home', [ConsultationController::class, 'homeLine'])->name('home');
        Route::get('/home/chat', [ConsultationController::class, 'homeChat'])->name('home.chat');
        Route::get('/welfare', [ConsultationController::class, 'welfareLine'])->name('welfare');
        Route::get('/welfare/chat', [ConsultationController::class, 'welfareChat'])->name('welfare.chat');
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

        // 管理者トップ
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // 管理：物件
        Route::resource('properties', PropertyManagementController::class)
            ->only(['index', 'show', 'edit', 'update']);

        // 管理：会員
        Route::resource('users', UserManagementController::class)
            ->only(['index', 'show']);

        // 管理：問い合わせ
        Route::resource('inquiries', InquiryManagementController::class)
            ->only(['index']);

        // 管理：相談
        Route::get('/consultations', [ConsultationController::class, 'adminIndex'])
            ->name('consultations.index');
    });


/*
|--------------------------------------------------------------------------
| フォールバック（404）
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('error');
});

// 物件検索（画面）
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');

// 検索結果（画面）
Route::get('/result', [PropertyController::class, 'result'])->name('property.result');

Route::get('/ajax/cities', [LocationController::class, 'cities'])
    ->name('ajax.cities');