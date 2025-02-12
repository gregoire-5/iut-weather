<?php

namespace App\Http\Controllers;

use App\Services\OpenWeatherService;
use App\Http\Requests\WeatherFormRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WeatherController extends Controller
{
    protected OpenWeatherService $weatherService;

    public function __construct(OpenWeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $date = Carbon::today();
        return view('weather.search', [
            'dates' => $this->getDateRange($date),
            'date' => $date,
        ]);
    }

    public function getCurrentWeather(WeatherFormRequest $request)
    {
        $city = $request->validated()['city'];
        $date = Carbon::parse($request->input('date', now()));
        $isForecast = $date->isFuture() && $date->diffInDays(now()) <= 5;

        try {
            $weatherData = $this->weatherService->getWeatherForDate($city, $date);
            return view('weather.current', [
                'weather' => $weatherData,
                'city' => $city,
                'date' => $date,
                'dates' => $this->getDateRange($date),
                'isForecast' => $isForecast,
                'coordinates' => $weatherData['coordinates'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching weather data: " . $e->getMessage());
            return back()->withError("Unable to fetch weather data. Please try again. Error: " . $e->getMessage());
        }
    }

    private function getDateRange(Carbon $centerDate)
    {
        return collect(range(-3, 3))->map(fn($offset) => [
            'date' => $centerDate->copy()->addDays($offset),
            'formatted' => $centerDate->copy()->addDays($offset)->format('Y-m-d'),
            'label' => $this->getDateLabel($centerDate->copy()->addDays($offset)),
        ]);
    }

    private function getDateLabel(Carbon $date): string
    {
        return match (true) {
            $date->isToday() => 'Today',
            $date->isYesterday() => 'Yesterday',
            $date->isTomorrow() => 'Tomorrow',
            default => $date->format('D, M j'),
        };
    }

    public function export(string $city)
    {
        $forecasts = $this->weatherService->getWeatherForDate($city, now());

        return response()->stream(function () use ($forecasts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Temperature']);
            fputcsv($handle, [Carbon::createFromTimestamp($forecasts['dt'])->format('Y-m-d'), $forecasts['main']['temp'] . '°C']);
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$city}_forecast.csv",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }
}
