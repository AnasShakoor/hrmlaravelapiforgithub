<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\GuardController;
use App\Http\Controllers\API\PolicyController;
use App\Http\Controllers\API\GuardDutyController;
use App\Http\Controllers\API\ResignationController;

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', ProductController::class);
    // Route::middleware(['checkRole:company'])->group(function () {
    // Route::middleware(['checkPermission:ok'])->group(function () {

    Route::get('/give_role', [UserController::class, 'getrole']);
    // });
    // });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('Permission', PermissionController::class);
Route::post('/give_role', [UserController::class, 'assignrole']);
Route::resource('role', RoleController::class);
Route::middleware(\App\Http\Middleware\CorsMiddleware::class)->group(function () {

    Route::resource('company', CompanyController::class);
    Route::resource('guard', GuardController::class);
});

Route::resource('policy', PolicyController::class);
Route::resource('guardduty', GuardDutyController::class);
Route::resource('resignation', ResignationController::class);
