<?php

use App\Http\Controllers\PhaseController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::get('/users', [TaskController::class, 'users']);
    Route::get('/phases/{phase}', [PhaseController::class, 'show']);
    Route::delete('/phases/{phase}', [PhaseController::class, 'destroy']);

    //statistics
    Route::get('/users-statistics', [StatisticsController::class, 'usersCardStatistics']);
    Route::get('/completed-card-statistics', [StatisticsController::class, 'completedCardStatistics']);
});
