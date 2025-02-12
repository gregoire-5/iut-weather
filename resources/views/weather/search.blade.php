<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Weather Search') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-3xl w-full sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                
                <!-- Titre principal -->
                <h1 class="text-3xl font-bold text-white mb-8 text-center">Weather Forecast Search</h1>

                <!-- Formulaire de recherche -->
                <form action="{{ route('weather.current') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City</label>
                        <input type="text" name="city" id="city" placeholder="Enter city name" value="{{ old('city') }}" required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 focus:ring-2 focus:ring-blue-500">
                        @error('city')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-200 focus:ring-2 focus:ring-blue-500">
                        @error('date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="w-full bg-blue-600 text-black font-bold px-6 py-3 rounded-md hover:bg-blue-700 transition duration-300">
                            Search Weather
                        </button>
                    </div>
                </form>

                @if(session('error'))
                    <div class="mt-6 bg-red-500 text-white p-4 rounded-lg text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    svg {
        width: 40px;
        height: 40px;
    }

    .icon-box {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        background-color: #1f2937;
    }

    .icon-box h3 {
        margin-top: 15px;
        font-size: 1.2rem;
        color: white;
    }

    .icon-box p {
        color: #9ca3af;
    }
</style>
