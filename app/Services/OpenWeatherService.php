<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OpenWeatherService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5';
    protected string $geoUrl = 'https://api.openweathermap.org/geo/1.0';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function getWeatherForDate(string $city, Carbon $date): array
    {
        $coordinates = $this->getCoordinates($city);
        if (!$coordinates) {
            throw new \Exception("Unable to find coordinates for the city.");
        }

        $cacheKey = "weather_{$city}_{$date->format('Y-m-d')}";

        return Cache::remember($cacheKey, 1800, function () use ($coordinates, $date) {
            $endpoint = $date->isFuture() ? 'forecast' : 'weather';

            $response = Http::get("{$this->baseUrl}/{$endpoint}", [
                'lat' => $coordinates['lat'],
                'lon' => $coordinates['lon'],
                'appid' => $this->apiKey,
                'units' => 'metric',
                'dt' => $date->timestamp,
            ])->throw()->json();

            if ($endpoint === 'forecast') {
                return $this->extractClosestForecast($response['list'], $date, $coordinates);
            }

            return array_merge($response, ['coordinates' => $coordinates]);
        });
    }

    protected function getCoordinates(string $city): ?array
    {
        return Cache::remember("coordinates_{$city}", 86400, function () use ($city) {
            Log::info("Fetching coordinates for {$city}");

            $response = Http::get("{$this->geoUrl}/direct", [
                'q' => $city,
                'limit' => 1,
                'appid' => $this->apiKey,
            ]);

            if ($response->failed() || empty($response->json())) {
                Log::error("Failed to fetch coordinates for {$city}");
                return null;
            }

            $data = $response->json()[0];

            return ['lat' => $data['lat'], 'lon' => $data['lon']];
        });
    }

    private function extractClosestForecast(array $forecastList, Carbon $date, array $coordinates): array
    {
        $closest = collect($forecastList)->sortBy(fn($item) => abs(Carbon::createFromTimestamp($item['dt'])->diffInSeconds($date)))->first();
        return array_merge($closest, ['coordinates' => $coordinates]);
    }
}
