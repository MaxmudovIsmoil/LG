<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ReportController;


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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::middleware(['auth', 'IsActive'])->group(function () {

    // Admin
    Route::group(['middleware' => 'CheckRole:admin'], function() {

        /******************** Users **************************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/user', UsersController::class)->except(['create', 'edit', 'show']);
            Route::get('/user/one-user/{id}', [UsersController::class, 'oneUser'])->name('user.oneUser');
            Route::get('/user-profile-show/', [UsersController::class, 'user_profile_show'])->name('user.user_profile_show');
            Route::put('/user/user-profile-update/{id}', [UsersController::class, 'user_profile_update'])->name('user.user_profile_update');
        });
        /******************** Users **************************/


        /******************** City ***************************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/city', CityController::class)->except(['create', 'edit', 'show']);
            Route::get('/city/one-city/{id}', [CityController::class, 'oneCity'])->name('city.oneCity');
        });
        /******************** ./City *************************/

        /******************** Outlet *************************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/outlet', OutletController::class)->except(['create', 'edit', 'show']);
            Route::get('/outlet/one-outlet/{id}', [OutletController::class, 'oneOutlet'])->name('outlet.oneOutlet');
        });
        /******************** ./Outlet ***********************/


        /******************** Shop ***************************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/shop', ShopController::class)->except(['create', 'edit', 'show']);
        });
        /******************** ./Shop *************************/


        /******************** Template ***********************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/template', TemplateController::class)->except(['create', 'edit', 'show']);
        });
        /******************** ./Template *********************/


        /******************** Report *************************/
        Route::group(['prefix' => '/'], function() {
            Route::resource('/report', ReportController::class)->except(['create', 'edit', 'show']);
        });
        /******************** ./Template *********************/

    });

    // Editor - Nazoratchi
    Route::group(['middleware' => 'CheckRole:editor'], function() {

    });


    // Promoter - Targ'ibotchi
    Route::group(['middleware' => 'CheckRole:promoter'], function() {

    });

    // Supervisor - Nazoratchi
    Route::group(['middleware' => 'CheckRole:supervisor'], function() {

    });



});



