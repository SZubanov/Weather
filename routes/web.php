<?php

declare(strict_types=1);

use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Settings\WeatherSettingController;
use App\Http\Controllers\Cities\CityController;
use App\Http\Controllers\Weather\WeatherController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function() {
        return view('home');
    })->name('home');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('cities', CityController::class)->except(['show']);
    Route::get('index', [WeatherSettingController::class, 'index'])->name('settings.weather.index');
    Route::put('index/{settings}', [WeatherSettingController::class, 'update'])->name('settings.weather.update');
    Route::post('weather/get/{city}', [WeatherController::class, 'getWeatherCity'])->name('weathers.get');
});
