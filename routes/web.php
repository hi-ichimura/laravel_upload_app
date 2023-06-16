<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ログイン中のみアクセスできるルーティングのサンプル */
Route::get('/upload_form', function(){
    return view('upload_form');
})->middleware('auth'); /* auth ミドルウェアが認証状態を判定してくれる */

/* POST 送信された画像を受け取って保存するルーティング */
Route::post('upload_form', [UploadImageController::class, 'upload'])->middleware('auth');

/* アップロードされた画像の一覧を表示するルーティング */
Route::get('upload_images', [UploadImageController::class, 'index'])->middleware('auth');

/*ユーザだけがアップロードしたとき*/
Route::get('my_upload', [UploadImageController::class, 'index_my'])->middleware('auth');

Route::post('delete/{id}',[UploadImageController::class, 'delete']);

Route::get('edit/{id}',[UploadImageController::class, 'edit']);

Route::post('edit/{id}', [UploadImageController::class, 'update']);

require __DIR__.'/auth.php';
