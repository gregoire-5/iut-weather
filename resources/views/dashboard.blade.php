@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <h1>Dashboard</h1>
    
    {{-- Ville favorite --}}
    @if($favoriteCity)
        <div class="favorite-city">
            <h2>Ville favorite : {{ $favoriteCity->name }}</h2>
            <p>Météo actuelle : {{ $favoriteCity->weather->description }}</p>
            <p>Température : {{ $favoriteCity->weather->temperature }}°C</p>
        </div>
    @else
        <p>Vous n'avez pas encore de ville favorite.</p>
    @endif

    {{-- Recherche de ville --}}
    <form action="{{ route('search.city') }}" method="POST">
        @csrf
        <label for="city">Rechercher une ville :</label>
        <input type="text" name="city" id="city" placeholder="Nom de la ville">
        <button type="submit">Rechercher</button>
    </form>

    {{-- Liste des villes enregistrées --}}
    <h2>Vos villes enregistrées :</h2>
    <ul>
        @foreach($savedCities as $city)
            <li>
                {{ $city->name }} 
                @if($city->is_favorite)
                    (Favorite)
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection