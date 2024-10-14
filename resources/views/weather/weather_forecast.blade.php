<body>
    <h1>Weather Forecast for {{ $forecastData['city']['name'] }}</h1>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Temperature</th>
                <th>Weather</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forecastData['list'] as $forecast)
                <tr>
                    <td>{{ $forecast['dt_txt'] }}</td>
                    <td>{{ $forecast['main']['temp'] }}°K</td>
                    <td>{{ $forecast['weather'][0]['description'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>