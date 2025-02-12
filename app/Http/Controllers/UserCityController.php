<?php

namespace App\Http\Controllers;

use App\Models\UserCity;
use Illuminate\Http\Request;

class UserCityController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user_cities.index', [
            'favoriteCity' => $user->cities()->where('is_favorite', true)->first(),
            'otherCities' => $user->cities()->where('is_favorite', false)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['city' => 'required|string|max:255']);

        auth()->user()->cities()->create(['city' => $request->city]);

        return redirect()->route('user_cities.index')->with('success', 'City added successfully.');
    }

    public function toggleFavorite(UserCity $city)
    {
        $isFavorite = $city->is_favorite;

        $isFavorite
            ? $city->update(['is_favorite' => false])
            : UserCity::setFavorite($city->id, auth()->id());

        return redirect()->route('user_cities.index')->with('success', $isFavorite
            ? 'City removed from favorites.'
            : 'City set as favorite.');
    }

    public function toggleForecast(UserCity $city)
    {
        $city->update(['send_forecast' => !$city->send_forecast]);

        return back()->with('success', 'Forecast settings updated.');
    }

    public function destroy(UserCity $city)
    {
        $city->delete();

        return redirect()->route('user_cities.index')->with('success', 'City removed successfully.');
    }
}
