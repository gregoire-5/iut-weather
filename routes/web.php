<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route pour rechercher une ville
Route::post('/search-city', [CityController::class, 'search'])->name('search.city');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/home', [WeatherController::class, 'home'])->name('home');
Route::post('/weather/search', [WeatherController::class, 'searchWeather'])->name('weather.search');
Route::get('/weather/forecast', [WeatherController::class, 'showForecast'])->name('weather.forecast');
Route::get('/weather/forecast/day-details', [WeatherController::class, 'showDayDetails'])->name('forecast.day-details');

Route::get('/saved-cities', [CityController::class, 'index'])->name('saved-cities');

require __DIR__ . '/auth.php';
