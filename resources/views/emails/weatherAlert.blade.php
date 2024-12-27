<p>Hello,</p>

<p>You've subscriber for the following weather alerts in <b>{{ $weatherAlert->location }}</b>:</p>

<ul>
    @if($weatherAlert->pecepitation > 0) <li>Pecepitation >={{ $weatherAlert->pecepitation }}.</li> @endif
    @if($weatherAlert->pecepitation > 0) <li>UV index >={{ $weatherAlert->uv }}.</li> @endif
</ul>

<p>Current weather conditions are:</p>
<ul>
    <li>Temperature: {{ $weatherReport->getTemperature() }}°C</li>
    <li>Perciptation: {{ $weatherReport->getPerciptation() }}%</li>
    <li>UV Index: {{ $weatherReport->getUV() }}</li>
</ul>
