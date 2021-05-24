<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    return Redirect::route('login');
});

Route::group(['prefix' => 'auth'], function () {
    Auth::routes(['verify' => true]);

    Route::get('redirect/{driver}', [LoginController::class, 'redirectToProvider'])
        ->name('login.provider')
        ->where('driver', implode('|', config('auth.socialite.drivers')));

    Route::get('{driver}/callback', [LoginController::class, 'handleProviderCallback'])
        ->name('login.callback')
        ->where('driver', implode('|', config('auth.socialite.drivers')));
});

Route::group(['middleware' => ['verified', 'auth']], function () {
    Route::resource('wallets', WalletController::class);
    Route::resource('wallets.transactions', TransactionController::class)->only(['create', 'store']);
});
