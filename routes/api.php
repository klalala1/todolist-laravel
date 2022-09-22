<?php

// use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use App\Http\Controllers\API\ItemController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('items',  API\ItemController::class);
// Route::apiResource('login', Api\AuthController::class);
// Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:api')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
// });
Route::apiResource('users', Api\AuthController::class);
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');
// -----------
Route::apiResource('tags', Api\TagsController::class);

Route::post('login', 'API\LoginController@login')->name('login');

Route::post('register', 'API\RegisterController@register')->name('register');

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('email/verify/{hash}', 'API\VerificationController@verify')->name('verification.verify');

    Route::get('email/resend', 'API\VerificationController@resend')->name('verification.resend');

    Route::get('user', 'API\AuthenticationController@user')->name('user');

    Route::post('logout', 'API\LoginController@logout')->name('logout');
});
