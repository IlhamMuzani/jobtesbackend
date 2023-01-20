<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('member/login', [\App\Http\Controllers\Api\MemberController::class, 'login']);
Route::post('member-detail/{id}', [\App\Http\Controllers\Api\MemberController::class, 'detail']);
Route::post('member-password/{id}', [\App\Http\Controllers\Api\MemberController::class, 'password']);
Route::post('member-update/{id}', [\App\Http\Controllers\Api\MemberController::class, 'update_profil']);
Route::post('member-delete/{id}', [\App\Http\Controllers\Api\MemberController::class, 'destroy']);
Route::post('tambah-member', [\App\Http\Controllers\Api\MemberController::class, 'store']);

Route::post('member-list', [\App\Http\Controllers\Api\AdminController::class, 'list']);
Route::post('admin/login', [\App\Http\Controllers\Api\AdminController::class, 'login_admin']);
Route::post('admin-detail/{id}', [\App\Http\Controllers\Api\AdminController::class, 'detail']);
Route::post('admin-update/{id}', [\App\Http\Controllers\Api\AdminController::class, 'update']);
Route::post('admin-password/{id}', [\App\Http\Controllers\Api\AdminController::class, 'password']);


