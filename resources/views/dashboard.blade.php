<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <main class="relative -mt-[64px]">
        <div class="absolute inset-0 bg-gray-900"></div>

        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 pt-[128px]">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-5xl sm:text-6xl font-bold text-white mb-8">
                    Explore Weather 
                    <span class="block mt-2 text-blue-400">Around the World</span>
                </h1>
                
                <p class="text-xl text-gray-300 mb-12 leading-relaxed">
                    Whether you're planning your next adventure or just curious about the weather, 
                    we've got you covered with real-time updates and accurate forecasts.
                </p>

                <a href="{{ route('weather.search') }}" 
                    class="inline-flex items-center px-8 py-4 text-lg font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-300 transform hover:scale-105">
                    Discover Weather
                    <svg class="ml-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>

                <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-8">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h3>Real-Time Updates</h3>
                        <p>Get instant access to current weather conditions</p>
                    </div>
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        <h3>Global Coverage</h3>
                        <p>Weather data from every corner of the world</p>
                    </div>
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3>5-Day Forecast</h3>
                        <p>Plan ahead with detailed weather forecasts</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
