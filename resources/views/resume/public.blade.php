@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to bottom, #FFF8E1, #F5DEB3);
        margin: 0;
        padding: 40px 0;
        display: flex;
        justify-content: center;
    }
    .paper {
        background: white;
        width: 800px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
    }
    h1 {
        text-align: left;
        text-transform: uppercase;
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    p {
        margin-bottom: 15px;
    }
    h2 {
        border-bottom: 2px solid black;
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: bold;
    }
    ul {
        margin-bottom: 15px;
        padding-left: 20px;
    }
    li {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 3px;
    }
</style>

<div class="paper">
    <h1>{{ $resume->name }}</h1>
    <p>
        {{ $resume->address ?? 'No address provided' }}<br>
        Mobile: {{ $resume->contact_number ?? 'Not provided' }}<br>
        Email: <a href="mailto:{{ $resume->email ?? '' }}">{{ $resume->email ?? '' }}</a>
    </p>

    <h2>Personal Data</h2>
    <ul>
        @foreach($resume->personal_data as $label => $value)
            <li><strong>{{ $label }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>

    <h2>Educational Background</h2>
    <ul style="padding-left:0;">
        @foreach($resume->education as $level => $info)
            <li>
                <strong>{{ $level }}:</strong> 
                {{ $info['school'] ?? '' }}
                @if(!empty($info['year']))
                    (<em>{{ $info['year'] }}</em>)
                @endif
            </li>
            @if(!empty($info['awards']))
                <ul>
                    @foreach((array) $info['awards'] as $award)
                        <li>{{ $award }}</li>
                    @endforeach
                </ul>
            @endif
            @if($level === 'Tertiary' && !empty($info['program']))
                <ul>
                    @foreach((array) $info['program'] as $program)
                        <li>{{ $program }}</li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </ul>



    <h2>Skills</h2>
    <ul>
        @foreach((array) $resume->skills as $skill)
            <li>{{ $skill }}</li>
        @endforeach
    </ul>
</div>
@endsection
