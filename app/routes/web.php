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
use App\Http\Controllers\PropertyImageController;

// ✅ 追加：パスワード再設定コントローラ
use App\Http\Controllers\Auth\PwdResetController;

/*
|--------------------------------------------------------------------------
| 共通（ログイン不要）
|--------------------------------------------------------------------------
*/

// トップページ
Route::get('/', [TopController::class, 'index'])->name('top');

// 物件（一覧・詳細）
Route::resource('properties', PropertyController::class)->only(['index', 'show']);

// 物件検索（画面）
Route::get('/search', [PropertyController::class, 'search'])->name('property.search');

// 検索結果（画面）
Route::get('/result', [PropertyController::class, 'result'])->name('property.result');

// Ajax：都道府県→市区町村
Route::get('/ajax/cities', [LocationController::class, 'cities'])->name('ajax.cities');

// お問い合わせ
Route::get('inquiries/{property}', [InquiryController::class, 'create'])->name('inquiries.create');
Route::post('inquiries/confirm', [InquiryController::class, 'confirm'])->name('inquiries.confirm');
Route::post('inquiries', [InquiryController::class, 'store'])->name('inquiries.store');


/*
|--------------------------------------------------------------------------
| ✅ パスワード再設定（ログイン不要）
|--------------------------------------------------------------------------
| ②メール送信 → メールリンク → pwd_form.blade.php → パスワード更新 → 完了画面
|
| ※ 既存の /auth/pwd_reset を残す場合は name('password.request') が被るので
|    そのルートは削除/コメントアウトしてください。
*/

// ②メール送信画面
Route::get('/password/forgot', [PwdResetController::class, 'showRequestForm'])
    ->name('password.request');

// ②メール送信（リンク送信）
Route::post('/password/email', [PwdResetController::class, 'sendResetLink'])
    ->name('password.email');

// メールのリンクから再設定フォーム表示（resources/views/auth/pwd_form.blade.php）
Route::get('/password/reset/{token}', [PwdResetController::class, 'showResetForm'])
    ->name('password.reset');

// 新パスワード登録（更新）
Route::post('/password/reset', [PwdResetController::class, 'resetPassword'])
    ->name('password.update');

// ✅ 追加：パスワード再設定 完了画面（ログイン不要）
Route::get('/password/complete', function () {
    return view('auth.pwd_comp');
})->name('password.complete');


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
Route::post('/signup/back', [RegisterController::class, 'back'])->name('signup.back');
Route::post('/signup/complete', [RegisterController::class, 'complete'])->name('signup.complete');

// ログイン（メール）
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// ログアウト
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('top');
})->name('logout');

// LINEログイン
Route::get('/login/line', [LineLoginController::class, 'redirect'])->name('line.login');
Route::get('/login/line/callback', [LineLoginController::class, 'callback'])->name('line.callback');
Route::get('/line/complete', [LineLoginController::class, 'complete'])->name('line.complete');
Route::get('/line/error', [LineLoginController::class, 'error'])->name('line.error');

/**
 * ❌ ここは削除（LoginController::reset が存在しないため）
 * Route::get('/password/reset', [LoginController::class, 'reset'])->name('password.request');
 * Route::post('/password/reset', [LoginController::class, 'send'])->name('password.send');
 * Route::get('/password/reset/form/{token}', [LoginController::class, 'form'])->name('password.form');
 * Route::post('/password/reset/complete', [LoginController::class, 'complete'])->name('password.complete');
 */


/*
|--------------------------------------------------------------------------
| ログイン後（会員）
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // 会員情報ページ
    Route::get('/user', [MyPageController::class, 'show'])->name('user.info');

    // ✅ 退会確認画面（GET）
    Route::get('/user/delete/confirm', [MyPageController::class, 'deleteConfirm'])
        ->name('user.delete.confirm');

    // ✅ 退会実行（POST）
    Route::post('/user/delete', [MyPageController::class, 'delete'])
        ->name('user.delete');

    // マイページ（index / edit）
    Route::resource('mypage', MyPageController::class)->only(['index', 'edit']);

    // 編集→確認（POST）
    Route::post('/mypage/edit/confirm', [MyPageController::class, 'confirm'])
        ->name('mypage.edit.confirm');

    // 確認→登録（更新）
    Route::match(['post', 'put', 'patch'], '/mypage/update', [MyPageController::class, 'update'])
        ->name('mypage.update');

    // 物件画像追加（会員のみ）
    Route::post('properties/{property}/images', [PropertyImageController::class, 'store'])
        ->name('properties.images.store');

    // お気に入り（会員のみ）
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{property}', [FavoriteController::class, 'store'])->name('favorites.store');

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

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('properties', PropertyManagementController::class)
        ->only(['index', 'show', 'edit', 'update']);

    Route::resource('users', UserManagementController::class)
        ->only(['index', 'show']);

    Route::resource('inquiries', InquiryManagementController::class)
        ->only(['index']);

    Route::get('/consultations', [ConsultationController::class, 'adminIndex'])
        ->name('consultations.index');
});


/*
|--------------------------------------------------------------------------
| フォールバック（404）※必ず一番最後
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('error');
});
