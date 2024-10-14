<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function currentWeather(Request $request)
    {
        // Get the city
        $city = $request->input('city', 'Paris');

        // Make a request to the API 
        $response = Http::get('http://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
        ]);

        // Convert to JSON
        $weatherData = $response->json();

        //Show the API response
        // dd($weatherData);

        // Return the view with the weather datas
        return view('weather', ['weatherData' => $weatherData]);
    }

    public function weatherForecast(Request $request)
    {
        // Get the city
        $city = $request->input('city', 'Paris');

        // Make a request to the forecast API
        $response = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
        ]);

        // Convert to JSON
        $forecastData = $response->json();

        // Return the view with forecast data
        return view('weather_forecast', ['forecastData' => $forecastData]);
    }

    public function cityCoordinates(Request $request)
    {
        // Get the city
        $city = $request->input('city', 'Paris');

        // Make a request to the city coordinates API
        $response = Http::get('http://api.openweathermap.org/geo/1.0/direct', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
        ]);

        // Convert to JSON
        $coordinates = $response->json();

        // Return the coordinates
        return view('city_coordinates', ['coordinates' => $coordinates]);
    }

    public function exportForecastCsv(Request $request)
    {
        // Get the city
        $city = $request->input('city', 'Paris');

        // Make a request to the forecast API
        $response = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
            'q' => $city,
            'appid' => env('OPENWEATHER_API_KEY'),
        ]);

        // Convert to JSON
        $forecastData = $response->json();

        // Create a CSV file
        $csvData = [];
        foreach ($forecastData['list'] as $forecast) {
            $csvData[] = [
                'date' => $forecast['dt_txt'],
                'temperature' => $forecast['main']['temp'],
                'weather' => $forecast['weather'][0]['description'],
            ];
        }

        $filename = "forecast_{$city}.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Date', 'Temperature (K)', 'Weather']);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend();
    }

    public function search(Request $request)
    {
        $city = $request->input('city');
        $apiKey = env('OPENWEATHER_API_KEY');

        // Call the OpenWeather API
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}");

        if ($response->successful()) {
            $weatherData = $response->json();

            return view('weather.result', compact('weatherData', 'city'));
        }

        return back()->withErrors(['city' => 'City not found or unable to fetch weather data.']);
    }
}
