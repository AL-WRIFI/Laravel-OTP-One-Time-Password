<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
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

Route::get('otp/request', [OtpController::class, 'create'])->name('otp.create');
Route::post('otp/request', [OtpController::class, 'store']);
Route::get('otp/verify', [OtpController::class, 'verifyForm'])->name('otp.verify');
Route::post('otp/verify', [OtpController::class, 'verify']);
