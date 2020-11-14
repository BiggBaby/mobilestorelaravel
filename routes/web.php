<?php

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

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\PageController;

Route::get('index',[ PageController::class, 'getIndex'])->name('trang-chu');

Route::get('loai-san-pham/{type}',
	[PageController::class, 'getLoaiSanPham'])->name('loai-san-pham');
Route::get('chi-tiet-san-pham/{id}',
	[PageController::class, 'getChiTietSP'])->name('chi-tiet-san-pham');
Route::get('lien-he',
	[PageController::class, 'getLienHe'])->name('lien-he');
Route::get('gioi-thieu',[PageController::class, 'getGioiThieu'])->name('gioi-thieu');

Route::get('them-vao-gio-hang/{id}',[PageController::class, 'getAddToCart'])->name('them-vao-gio-hang');
Route::get('xoa-gio-hang/{id}',[PageController::class, 'deleteCart'])->name('xoa-gio-hang');

Route::get('dat-hang',[PageController::class,'getCheckout'])->name('dat-hang');
Route::post('dat-hang',[PageController::class, 'postCheckout'])->name('dat-hang');

Route::get('dang-nhap', [PageController::class, 'getLogin'])->name('dang-nhap');
Route::get('dang-ky', [PageController::class, 'getSignup'])->name('dang-ky');
Route::post('dang-ky', [PageController::class, 'postSignup'])->name('dang-ky');

Route::post('dang-nhap', [PageController::class, 'postLogin'])->name('dang-nhap');

