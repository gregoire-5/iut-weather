<form method="GET" action="/weather">
    <label for="city">Select City:</label>
    <input type="text" id="city" name="city" placeholder="Enter city name">
    <button type="submit">Get Current Weather</button>
</form>

<h1>Weather in {{ $weatherData['name'] }}</h1>
<p>Temperature: {{ $weatherData['main']['temp'] }}°K</p>
<p>Weather: {{ $weatherData['weather'][0]['description'] }}</p>

<form method="GET" action="/weather/forecast">
    <input type="hidden" name="city" value="{{ $weatherData['name'] }}">
    <button type="submit">Get 5-Day Forecast</button>
</form>