<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class WeatherController extends Controller
{
    public function currentWeather(Request $request)
    {
        // Récupérer la ville depuis l'input ou utiliser une valeur par défaut
        $city = $request->input('city', 'Paris');

        // Appel à l'API pour obtenir la météo actuelle
        $response = Http::get('http://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang' => 'fr'
        ]);

        // Vérifier si l'appel API a réussi
        if ($response->successful()) {
            $weatherData = $response->json();
            return view('weather', ['weatherData' => $weatherData]);
        }

        // Rediriger avec un message d'erreur en cas d'échec
        return back()->withErrors(['city' => 'Ville introuvable ou problème de récupération des données météo.']);
    }

    public function weatherForecast(Request $request)
    {
        // Récupérer la ville depuis l'input ou utiliser une valeur par défaut
        $city = $request->input('city', 'Paris');

        // Appel à l'API pour obtenir les prévisions météo
        $response = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang' => 'fr'
        ]);

        // Vérifier si l'appel API a réussi
        if ($response->successful()) {
            $forecastData = $response->json();
            return view('weather_forecast', ['forecastData' => $forecastData]);
        }

        return back()->withErrors(['city' => 'Ville introuvable ou problème de récupération des données météo.']);
    }

    public function search(Request $request)
    {
        $request->validate(['city' => 'required|string']);
        $cityName = $request->input('city');
        $apiKey = env('OPENWEATHER_API_KEY');

        // Appel à l'API OpenWeather
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $cityName,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'fr'
        ]);

        // Vérifier si l'appel API a réussi
        if ($response->successful()) {
            $weatherData = $response->json();

            // Récupérer les villes favorites de l'utilisateur connecté
            $cities = auth()->check() ? auth()->user()->cities : collect();

            return view('dashboard', compact('weatherData', 'cities', 'cityName'));
        }

        return back()->withErrors(['city' => 'Ville introuvable ou problème de récupération des données météo.']);
    }

    public function addCity(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $cityName = $request->input('name');

        // Vérifier si la ville existe déjà dans les favoris de l'utilisateur
        $existingCity = City::where('name', $cityName)
            ->where('user_id', auth()->id())
            ->first();

        if (!$existingCity) {
            City::create([
                'name' => $cityName,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('dashboard')->with('success', 'Ville ajoutée en favori avec succès.');
        }

        return redirect()->route('dashboard')->withErrors(['city' => 'Cette ville est déjà dans vos favoris.']);
    }

    public function cityCoordinates(Request $request)
    {
        $city = $request->input('city', 'Paris');

        // Appel à l'API pour obtenir les coordonnées
        $response = Http::get('http://api.openweathermap.org/geo/1.0/direct', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
        ]);

        if ($response->successful()) {
            $coordinates = $response->json();
            return view('city_coordinates', ['coordinates' => $coordinates]);
        }

        return back()->withErrors(['city' => 'Impossible de récupérer les coordonnées de la ville.']);
    }
}