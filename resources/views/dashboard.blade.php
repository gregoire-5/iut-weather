<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <main
        class="relative -mt-16 min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 pt-32 bg-gray-900">
        <div class="text-center max-w-3xl mx-auto">
            <a href="{{ route('weather.search') }}"
                class="inline-flex items-center px-8 py-4 text-lg font-medium text-black bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-transform duration-300 transform hover:scale-105">
                Search Weather
            </a>
        </div>
    </main>
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