<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Weather Search') }}
        </h2>
    </x-slot>

    <style>
        .container {
            background: linear-gradient(135deg, #1e293b, #334155);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .input-field {
            background-color: #475569;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
        }
        .input-field:focus {
            outline: none;
            box-shadow: 0 0 8px #3b82f6;
        }
        .btn-search {
            background-color: #3b82f6;
            color: white;
            padding: 12px;
            border-radius: 6px;
            width: 100%;
            font-size: 18px;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }
        .btn-search:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }
        .error-message {
            background-color: #dc2626;
            color: white;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
        }
    </style>

    <div class="py-12 flex justify-center">
        <div class="max-w-3xl w-full sm:px-6 lg:px-8">
            <div class="container">
                <h1 class="text-3xl font-bold text-white mb-8 text-center">Weather Forecast Search</h1>

                <form action="{{ route('weather.current') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City</label>
                            <input type="text" name="city" id="city" placeholder="Enter city name" value="{{ old('city') }}" required
                                   class="input-field">
                            @error('city')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" required
                                   class="input-field">
                            @error('date')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn-search">
                                Search Weather
                            </button>
                        </div>
                    </div>
                </form>

                @if(session('error'))
                    <div class="mt-6 error-message">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
