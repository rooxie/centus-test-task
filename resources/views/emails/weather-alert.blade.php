    <div style="font-family: Helvetica, sans-serif; font-size: 14px; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 600px; margin: 0 auto; margin-top: 20px">

        <h2 style="color: #555;">Hello {{ $weatherAlert->user->name }},</h2>

        <p>
            You've subscribed to receive a weather alert when the
            <b>{{ $weatherAlert->precipitation > 0 ? 'precipitation' : 'UV index' }}</b>
            in <b>{{ $weatherAlert->location->name }}</b> is more than or equal to
            <b>{{ $weatherAlert->precipitation ?: $weatherAlert->uv }}</b>.
        </p>

        <p style="margin-top: 20px;">
            As of <b>{{ $weatherAlert->executed_at?->format('Y/m/d H:i:s') }}</b>, the current weather conditions are as follows:
        </p>
        <ul style="margin: 0; padding-left: 20px;">
            <li style="margin-bottom: 10px;">Temperature: <b>{{ $weatherReport->getTemperature() }}*C</b></li>
            <li style="margin-bottom: 10px;">Precipitation: <b>{{ $weatherReport->getPrecipitation() }}%</b></li>
            <li>UV Index: <b>{{ $weatherReport->getUv() }}</b></li>
        </ul>

    </div>
