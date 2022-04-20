<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::group(['middleware'=>['auth:sanctum','verified','roles']],function () {

    /*
     * ------------------------------------------------------
     * Shows the Dashboard Page
     * ------------------------------------------------------
     * URL: /
     * Method: GET
    */
    Route::get('/', [
        "uses" => "App\Http\Controllers\UserController@redirect",
        'roles' =>['admin']
    ])->name('dashboard');

    Route::get('/notifications', [
        "uses" => "App\Http\Controllers\NotificationController@index",
        'roles' =>['admin']
    ])->name('notifications');

    Route::group(['prefix'=>'employers'],function (){

        Route::get('/', [
            "uses" => "App\Http\Controllers\EmployerController@index",
            'roles' =>['admin']
        ])->name('employer.index');

        Route::post('/', [
            "uses" => "App\Http\Controllers\EmployerController@store",
            'roles' =>['admin']
        ])->name('employer.store');

        Route::post('/edit/{id}', [
            "uses" => "App\Http\Controllers\EmployerController@update",
            'roles' =>['admin']
        ])->name('employer.update');

        Route::get('/edit/{id}', [
            "uses" => "App\Http\Controllers\EmployerController@edit",
            'roles' =>['admin']
        ])->name('employer.edit');

        Route::get('/new', [
            "uses" => "App\Http\Controllers\EmployerController@create",
            'roles' =>['admin']
        ])->name('employer.new');

        Route::get('/view/{id}', [
            "uses" => "App\Http\Controllers\EmployerController@show",
            'roles' =>['admin']
        ])->name('employer.show');

        Route::get('/new/{id}', [
            "uses" => "App\Http\Controllers\EmployeeController@create",
            'roles' =>['admin']
        ])->name('employee.new');

    });

    Route::group(['prefix'=>'employees'],function (){


        Route::post('/', [
            "uses" => "App\Http\Controllers\EmployeeController@store",
            'roles' =>['admin']
        ])->name('employee.store');

        Route::post('/{id}', [
            "uses" => "App\Http\Controllers\EmployeeController@update",
            'roles' =>['admin']
        ])->name('employee.update');

        Route::get('/{id}', [
            "uses" => "App\Http\Controllers\EmployeeController@edit",
            'roles' =>['admin']
        ])->name('employee.edit');

    });

    Route::group(['prefix'=>'users'],function (){

        Route::get('/', [
            "uses" => "App\Http\Controllers\UserController@index",
            'roles' =>['admin']
        ])->name('users.index');

        Route::get('/{id}', [
            "uses" => "App\Http\Controllers\UserController@show",
            'roles' =>['admin']
        ])->name('users.show');

    });

    Route::group(['prefix'=>'loan'],function (){

        Route::get('/{code}', [
            "uses" => "App\Http\Controllers\LoanController@show",
            'roles' =>['admin']
        ])->name('loan.show');

        Route::post('/approve/{code}', [
            "uses" => "App\Http\Controllers\LoanController@approve",
            'roles' =>['admin']
        ])->name('loan.approve');

        Route::post('/reject/{code}', [
            "uses" => "App\Http\Controllers\LoanController@reject",
            'roles' =>['admin']
        ])->name('loan.reject');

        Route::post('/close/{code}', [
            "uses" => "App\Http\Controllers\LoanController@close",
            'roles' =>['admin']
        ])->name('loan.close');

        Route::post('/default/{code}', [
            "uses" => "App\Http\Controllers\LoanController@default",
            'roles' =>['admin']
        ])->name('loan.default');


        Route::get('/export/{datestamp}', [
            "uses" => "App\Http\Controllers\LoanController@exportDatasheet",
            'roles' =>['admin']
        ])->name('loan.export');


    });
});
