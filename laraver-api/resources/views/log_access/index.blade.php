<!-- resources/views/log_access/index.blade.php -->

<h1>MQTT Logs</h1>

@foreach($logs as $log)
    <p>Timestamp: {{ $log->created_at }}</p>
    <pre>{{ json_encode($log->mqtt_data, JSON_PRETTY_PRINT) }}</pre>
    <hr>
@endforeach
