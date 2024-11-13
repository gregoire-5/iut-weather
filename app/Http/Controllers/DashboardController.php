<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  // Importer la classe Request
use App\Models\Place;  // Importer le modèle City
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les villes associées à l'utilisateur
        $cities = Place::where('user_id', $user->id)->get(); 

        // Retourne la vue du dashboard avec les villes
        return view('dashboard', compact('cities'));
    }
}