<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['can:publish role'], 'as' => 'role.'], function () {
        Route::prefix('roles')->group(function () {
            Route::controller(\App\Http\Controllers\RoleController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
            });
        });
    });

    Route::group(['middleware' => ['can:publish assessment'], 'as' => 'assessments.'], function () {
        Route::prefix('assessments')->group(function () {
            Route::controller(\App\Http\Controllers\AssessmentController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/create', 'store')->name('store');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}', 'show')->name('show');
            });
        });
    });

    Route::group(['middleware' => ['can:publish assessment'], 'as' => 'standards.'], function () {
        Route::prefix('standards')->group(function () {
            Route::controller(\App\Http\Controllers\StandardController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/add', 'store')->name('store');
                Route::get('/add', 'create')->name('create');
            });
        });
    });
});
