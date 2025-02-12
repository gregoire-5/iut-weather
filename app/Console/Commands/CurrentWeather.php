<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OpenWeatherService;

class CurrentWeather extends Command
{
    protected $signature = 'weather:show {city : The city name to get weather for}';
    protected $description = 'Show current weather for a specified city';

    protected $weatherService;

    public function __construct(OpenWeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        $city = $this->argument('city');

        try {
            $weather = $this->getWeatherForCity($city);
            $this->displayWeather($city, $weather);
        } catch (\Exception $e) {
            $this->handleError($e, $city);
            return 1;
        }

        return 0;
    }

    private function getWeatherForCity($city)
    {

        return $this->weatherService->getWeatherForDate($city, now());
    }

    private function displayWeather($city, $weather)
    {

        $this->info("Current weather in {$city}:");
        $this->newLine();
        $this->table(
            ['Metric', 'Value'],
            $this->formatWeatherData($weather)
        );
    }

    private function formatWeatherData($weather)
    {

        return [
            ['Temperature', $weather['main']['temp'] . '°C'],
            ['Feels Like', $weather['main']['feels_like'] . '°C'],
            ['Humidity', $weather['main']['humidity'] . '%'],
            ['Pressure', $weather['main']['pressure'] . ' hPa'],
            ['Weather', $weather['weather'][0]['description']],
            ['Wind Speed', $weather['wind']['speed'] . ' m/s'],
            ['Cloudiness', $weather['clouds']['all'] . '%'],
        ];
    }

    private function handleError(\Exception $e, $city)
    {

        $this->error("Failed to fetch weather data for {$city}");
        $this->error($e->getMessage());
    }
}
