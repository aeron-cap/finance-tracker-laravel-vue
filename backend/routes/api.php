<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetTypeController;
use App\Http\Controllers\CutoffTypeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(BudgetController::class)->group(function () {
        Route::get('/budget/{id}', 'show');
        Route::post('/budgets', 'index');
        Route::post('/budget', 'store');
        Route::post('/budget/{id}', 'update');
        Route::post('/budget-delete/{id}', 'destroy');
    });

    Route::controller(IncomeController::class)->group(function () {
        Route::get('/income/{id}', 'show');
        Route::post('/incomes', 'index');
        Route::post('/income', 'store');
        Route::post('/income/{id}', 'update');
        // delete income, use Softdeletes
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/account/{id}', 'show');
        Route::post('/accounts', 'index');
        Route::post('/account', 'store');
        Route::post('/account/{id}', 'update');
        Route::post('/account-delete/{id}', 'destroy');
        // delete income, use Softdeletes
    });

    Route::controller(ExpenseController::class)->group(function () {
        Route::get('/expense/{id}', 'show');
        Route::post('/expenses', 'index');
        Route::post('/expense', 'store');
        Route::post('/expense/{id}', 'update');
        // delete expense, use Softdeletes
    });

    Route::controller(StatusController::class)->group(function () {
        Route::get('/statuses', 'index');
    });

    Route::controller(CutoffTypeController::class)->group(function () {
        Route::get('/cutoff_types', 'index');
    });

    Route::controller(BudgetTypeController::class)->group(function () {
        Route::post('/budget_types', 'index');
    });

});

// Route::controller(OrderController::class)->group(function () {
//     Route::get('/orders/{id}', 'show');
//     Route::post('/orders', 'store');
// });


// Route::middleware(['first', 'second'])->group(function () {
//     Route::get('/', function () {
//     });

//     Route::get('/user/profile', function () {
//     });
// });
