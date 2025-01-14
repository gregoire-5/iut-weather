<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté
        $favoriteCity = $user->favoriteCities()->first(); // Récupère la ville favorite
        $savedCities = $user->places; // Récupère toutes les villes enregistrées

        if ($favoriteCity) {
            // Obtenir la météo via un service externe
            $favoriteCity->weather = app('App\Services\WeatherService')->getWeatherForCity($favoriteCity->name);
        }

        return view('dashboard', [
            'favoriteCity' => $favoriteCity,
            'savedCities' => $savedCities,
        ]);
    }
}