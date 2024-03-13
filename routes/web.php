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

Route::group(['middleware' => ['auth'], 'as' => 'evidences.'], function () {
    Route::prefix('evidences')->group(function () {
        Route::controller(\App\Http\Controllers\EvidenceController::class)->group(function () {
            Route::get('/search', 'search')->name('search');
            Route::get('/', 'index')->name('index');
            Route::post('/create', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit/{evidence}', 'update')->name('update');
            Route::delete('/{evidence}', 'destroy')->name('destroy');
            Route::get('/get-evidences/{id}', 'getAssessmentEvidence')->name('getAssessmentEvidence');
        });
    });
});

Route::group(['middleware' => ['auth', 'can:publish criteria'], 'as' => 'criteria.'], function () {
    Route::prefix('criteria')->group(function () {
        Route::controller(\App\Http\Controllers\CriterionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/create', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{criterion}', 'edit')->name('edit');
            Route::delete('/{criterion}', 'destroy')->name('destroy');
            Route::put('/edit/{criterion}', 'update')->name('update');
        });
    });
});

Route::group(['middleware' => ['auth'], 'as' => 'assessments.'], function () {
    Route::prefix('assessments')->group(function () {
        Route::controller(\App\Http\Controllers\AssessmentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');

            Route::put('/{id}', 'addEvidence')->name('addEvidence');

            Route::get('/{id}/download-file-evidence', 'downloadFileEvidence')
                ->name('downloadFileEvidence');
            Route::get('/{id}/generate-pdf', 'generatePDF')
                ->name('generatePDF');
            Route::get('/{assessment}/clone', 'clone')
                ->name('clone');
            Route::post('/{assessment}/clone', 'cloneFromAssessment')
                ->name('cloneFromAssessment');


            Route::group(['middleware' => ['can:publish assessments']], function () {
                Route::get('/{id}/add-criterion', 'addListCriterion')->name('addListCriterion');
                Route::put('/{id}/add-criterion', 'storeListCriterion')->name('storeListCriterion');
                Route::post('/create', 'store')->name('store');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}/add-standards', 'addStandards')->name('addStandards');
                Route::post('/{id}/add-standards', 'saveNewStandards')->name('saveNewStandards');
                Route::delete('/{assessment}', 'destroy')
                    ->name('destroy');
            });

        });
    });
});

Route::middleware(['auth'])->group(function () {

    Route::get('storage/evidences/{path}', function ($path) {
        $file = storage_path('app/public/evidences/' . $path);

        if (!file_exists($file)) {
            abort(404);
        }

        return response()->file($file);

    });


    Route::controller(\App\Http\Controllers\HomeController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/load-more-activity', 'loadMore');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['can:publish role'], 'as' => 'role.'], function () {
        Route::prefix('roles')->group(function () {
            Route::controller(\App\Http\Controllers\RoleController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/', 'store');
            });
        });
    });


    Route::group(['middleware' => ['can:publish standards'], 'as' => 'standards.'], function () {
        Route::prefix('standards')->group(function () {
            Route::controller(\App\Http\Controllers\StandardController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/add', 'store')->name('store');
                Route::get('/add', 'create')->name('create');
                Route::get('/search', 'search')->name('search');
                Route::get('/edit/{standard}', 'edit')->name('edit');
                Route::put('/edit/{standard}', 'update')->name('update');
                Route::delete('/{standard}', 'destroy')->name('destroy');
            });
        });
    });
    Route::group(['middleware' => ['can:publish user'], 'as' => 'users.'], function () {
        Route::prefix('users')->group(function () {
            Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/create', 'store')->name('store');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });
        });
    });

    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');


});
