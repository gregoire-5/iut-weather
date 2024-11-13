<x-app-layout>
    <div class="container">
        <h2>Votre Tableau de Bord</h2>

        <!-- Formulaire de recherche de ville -->
        <form method="GET" action="{{ route('weather.search') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="city" class="form-control" placeholder="Rechercher une ville" required>
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <!-- Affichage de la météo recherchée -->
        @isset($weatherData)
            <div class="card my-4">
                <div class="card-header">
                    Météo à {{ $cityName }}
                </div>
                <div class="card-body">
                    <p>Température : {{ $weatherData['main']['temp'] }}°C</p>
                    <p>Conditions : {{ $weatherData['weather'][0]['description'] }}</p>
                </div>
                <form action="{{ route('user.cities.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ $cityName }}">
                    <button type="submit" class="btn btn-success">Ajouter aux favoris</button>
                </form>
            </div>
        @endisset

        <!-- Liste des villes favorites -->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Vos Villes Favoris</h4>
            </div>
            <div class="card-body">
                @if ($cities->isEmpty())
                    <p>Vous n'avez aucune ville en favori pour le moment.</p>
                @else
                    <ul class="list-group">
                        @foreach ($cities as $city)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $city->name }}
                                <form action="{{ route('user.cities.remove', $city->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>