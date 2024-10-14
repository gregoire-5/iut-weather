<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('weather')->group(function () {
    Route::get('/', [WeatherController::class, 'currentWeather'])->name('weather.current');
    Route::get('/forecast', [WeatherController::class, 'weatherForecast'])->name('weather.forecast');
    Route::get('/forecast/export', [WeatherController::class, 'exportForecastCsv'])->name('weather.forecast.export');
    Route::get('/search', [WeatherController::class, 'search'])->name('weather.search');
});

Route::get('/city/coordinates', [WeatherController::class, 'cityCoordinates'])->name('city.coordinates');

require __DIR__ . '/auth.php';
