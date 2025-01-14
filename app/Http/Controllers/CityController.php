<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $cityName = $request->input('city');

        // Appelle un service ou API pour obtenir les informations météo
        $weather = app('App\Services\WeatherService')->getWeatherForCity($cityName);

        return view('search-result', [
            'cityName' => $cityName,
            'weather' => $weather,
        ]);
    }
}