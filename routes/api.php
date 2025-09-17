<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\TablecategoryController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\WaiterAuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AI Services API Routes
Route::get('/', [IndexController::class, 'index']);

// Waiter Authentication Routes (Public)
Route::post('/waiter/login', [WaiterAuthController::class, 'login']);
Route::post('/waiter/logout', [WaiterAuthController::class, 'logout'])->middleware('auth:sanctum');

// Branch Selection (requires auth but not waiter.auth middleware)
Route::middleware('api.auth')->group(function () {
    Route::post('/waiter/select-branch', [WaiterAuthController::class, 'selectBranch']);
});

// Waiter Protected Routes
Route::middleware(['api.auth', 'waiter.auth'])->group(function () {
    Route::get('waiter/me', [WaiterAuthController::class, 'me']);
    Route::get('waiter/profile', [WaiterAuthController::class, 'profile']);
    Route::post('waiter/profile/update', [WaiterAuthController::class, 'updateProfile']);
    // Table API Routes with Status
    Route::get('/tables', [TableController::class, 'getTablesWithStatus']);
    Route::get('/tables/{id}', [TableController::class, 'getTableWithStatus']);
    // Category API Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::get('/categories/{categoryId}/items', [CategoryController::class, 'getItems']);
    // Item API Routes
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{id}', [ItemController::class, 'show']);
    Route::get('/items/category/{categoryId}', [ItemController::class, 'getByCategory']);
    Route::get('/items/available', [ItemController::class, 'getAvailable']);
    Route::get('/items/type/{type}', [ItemController::class, 'getByType']);
});


