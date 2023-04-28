@foreach($settings as $setting)
    {{ $setting->relativeTo(base_path()) }} <br/>

    @foreach($setting->variables as $key => $variable)
        <pre>{{ $key }} => {{ print_r($variable, true) }}</pre>
    @endforeach
@endforeach
