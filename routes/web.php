<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DashboardController;

// Route de bienvenue
Route::get('/', function () {
    return view('welcome');
});

// Groupement des routes nécessitant l'authentification et la vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    // Route du tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes de profil utilisateur
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Routes de gestion des villes de l'utilisateur
    Route::prefix('user/cities')->group(function () {
        Route::post('/', [WeatherController::class, 'addCity'])->name('user.cities.add');
        Route::delete('/{city}', [WeatherController::class, 'removeCity'])->name('user.cities.remove');
        Route::patch('/{city}/favorite', [WeatherController::class, 'markFavorite'])->name('user.cities.favorite');
        Route::patch('/{city}/send-forecast', [WeatherController::class, 'sendForecast'])->name('user.cities.send-forecast');
    });
});

// Groupement des routes météo
// Route pour rechercher la météo d'une ville
Route::get('/weather/search', [WeatherController::class, 'search'])->name('weather.search');

// Route pour afficher la météo d'une ville spécifique
Route::post('/weather/result', [WeatherController::class, 'searchResult'])->name('weather.result');


// Route des coordonnées de ville
Route::get('/city/coordinates', [WeatherController::class, 'cityCoordinates'])->name('city.coordinates');

// Inclusion des routes d'authentification générées automatiquement
require __DIR__ . '/auth.php';