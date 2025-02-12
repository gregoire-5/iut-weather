<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeatherForecastNotification;
use App\Services\OpenWeatherService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class WeatherForecast extends Command
{
    protected $signature = 'weather:send-forecasts';
    protected $description = 'Send weather forecasts to users';

    public function handle(OpenWeatherService $weatherService)
    {
        $users = $this->getUsersWithForecastsEnabled();

        foreach ($users as $user) {
            $this->sendForecastToUser($user, $weatherService);
        }

        $this->info('Weather forecasts sending process completed.');
    }

    private function getUsersWithForecastsEnabled()
    {

        return User::whereHas('cities', function ($query) {
            $query->where('send_forecast', true);
        })->get();
    }

    private function sendForecastToUser(User $user, OpenWeatherService $weatherService)
    {
        try {

            $forecasts = $this->getForecastsForUserCities($user, $weatherService);


            $csvPath = $this->generateCsv($forecasts);


            $user->notify(new WeatherForecastNotification($csvPath));
        } catch (\Exception $e) {
            $this->logForecastError($user, $e);
        }
    }

    private function getForecastsForUserCities(User $user, OpenWeatherService $weatherService)
    {
        $forecasts = [];

        foreach ($user->cities()->where('send_forecast', true)->get() as $city) {
            $weatherData = $weatherService->getWeatherForDate($city->city, Carbon::now());
            $forecasts[$city->city] = $this->formatForecast($weatherData);
        }

        return $forecasts;
    }

    private function formatForecast($weatherData)
    {
        return [
            'date' => Carbon::createFromTimestamp($weatherData['dt'])->format('Y-m-d'),
            'temp' => $weatherData['main']['temp'],
            'description' => $weatherData['weather'][0]['description'],
        ];
    }

    private function generateCsv(array $forecasts)
    {
        $csvContent = "City,Date,Temperature,Description\n";

        foreach ($forecasts as $city => $forecast) {
            $csvContent .= "{$city},{$forecast['date']},{$forecast['temp']},{$forecast['description']}\n";
        }

        $path = 'forecasts/' . uniqid() . '.csv';
        Storage::put($path, $csvContent);

        return $path;
    }

    private function logForecastError(User $user, \Exception $exception)
    {
        $this->error("Failed to send forecast to user {$user->id}: " . $exception->getMessage());
        \Log::error("Failed to send forecast to user {$user->id}: " . $exception->getMessage());
    }
}
