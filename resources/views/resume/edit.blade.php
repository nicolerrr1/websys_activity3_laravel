@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #FFFDE7, #FFF8E1, #FFF9C4);
        background-size: 400% 400%;
        animation: sunlightMove 15s ease-in-out infinite;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 50px;
    }

    @keyframes sunlightMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .paper {
        background: rgba(255, 255, 255, 0.9);
        width: 850px;
        padding: 40px;
        box-shadow: 0 0 25px rgba(170, 130, 30, 0.3);
        border-radius: 14px;
        border: 2px solid #F6D060;
        backdrop-filter: blur(6px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .paper:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(170, 130, 30, 0.4);
    }

    h1 {
        text-align: center;
        text-transform: uppercase;
        font-size: 34px;
        font-weight: 700;
        color: #5C4B1A;
        letter-spacing: 1px;
        margin-bottom: 25px;
        position: relative;
    }

    h1::after {
        content: "";
        width: 80px;
        height: 4px;
        background-color: #EAC54F;
        display: block;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    h2 {
        border-bottom: 2px solid #D4A017;
        margin-top: 30px;
        font-size: 22px;
        font-weight: bold;
        padding-bottom: 6px;
        color: #6B5200;
    }

    h3 {
        font-size: 18px;
        font-weight: bold;
        margin-top: 15px;
        color: #7B6A1B;
    }

    label {
        font-weight: bold;
        color: #4E3C10;
    }

    input[type="text"], input[type="email"], textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0 15px 0;
        border: 1px solid #D6B85A;
        border-radius: 6px;
        box-sizing: border-box;
        background-color: #FFFAE3;
        transition: all 0.3s ease;
    }

    input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
        border-color: #E1B000;
        background-color: #FFFDE7;
        outline: none;
        box-shadow: 0 0 8px rgba(230, 180, 50, 0.3);
    }

    button {
        background-color: #E1B000;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        display: block;
        margin: 25px auto 0;
        transition: all 0.3s ease;
        font-size: 16px;
        box-shadow: 0 4px 10px rgba(200, 150, 20, 0.3);
    }

    button:hover {
        background-color: #D39E00;
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(200, 150, 20, 0.4);
    }

    .success-message {
        background-color: #FFF3CD;
        color: #856404;
        border: 1px solid #FFEEBA;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(255, 200, 60, 0.2);
    }

    .section {
        background-color: rgba(255, 250, 230, 0.6);
        border-radius: 10px;
        padding: 15px 20px;
        margin-top: 20px;
        box-shadow: 0 2px 5px rgba(240, 190, 60, 0.2);
        transition: transform 0.3s ease;
    }

    .section:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 8px rgba(230, 180, 50, 0.3);
    }

    .view-resume-btn:hover {
    background-color: #7B6A1B;
    transform: scale(1.05);
    }

</style>

<div class="paper">
    <h1>Edit Resume</h1>

    <!-- View Resume Button -->
    <div class="top-buttons">
        <a href="{{ route('resume.public', Auth::id()) }}" class="view-resume-btn"></a>

    </div>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form action="{{ route('resume.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Basic Info -->
        <div class="section">
            <h2>Basic Info</h2>
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $resume->name) }}" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $resume->email) }}" required>

            <label for="contact_number">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $resume->contact_number) }}">

            <label for="address">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address', $resume->address) }}">
        </div>

        <!-- Personal Data -->
        <div class="section">
            <h2>Personal Data</h2>
            @php
                $personal_data = is_string($resume->personal_data) ? json_decode($resume->personal_data, true) : ($resume->personal_data ?? []);
                $personal_fields = ['Date of Birth', 'Place of Birth', 'Civil Status', 'Citizenship', 'Religion', 'Height (in cm.)', 'Weight (in kg.)'];
            @endphp

            @foreach($personal_fields as $field)
                <label for="{{ Str::slug($field) }}">{{ $field }}</label>
                <input type="text" name="personal_data[{{ $field }}]" id="{{ Str::slug($field) }}"
                       value="{{ old('personal_data.' . $field, $personal_data[$field] ?? '') }}">
            @endforeach
        </div>

        <!-- Education -->
        <div class="section">
            <h2>Educational Background</h2>
            @php
                $education_data = is_string($resume->education) ? json_decode($resume->education, true) : ($resume->education ?? []);
                $levels = ['Primary', 'Secondary', 'Tertiary'];
            @endphp

            @foreach($levels as $level)
                <h3>{{ $level }}</h3>
                <label for="{{ Str::slug($level) }}_school">School</label>
                <input type="text" name="education[{{ $level }}][school]" id="{{ Str::slug($level) }}_school"
                       value="{{ old('education.' . $level . '.school', $education_data[$level]['school'] ?? '') }}">

                @if($level === 'Primary' || $level === 'Secondary')
                    <label for="{{ Str::slug($level) }}_year">Year Graduated</label>
                    <input type="text" name="education[{{ $level }}][year]" id="{{ Str::slug($level) }}_year"
                           value="{{ old('education.' . $level . '.year', $education_data[$level]['year'] ?? '') }}">
                @else
                    <label for="{{ Str::slug($level) }}_program">Program(s) (comma separated)</label>
                    <input type="text" name="education[{{ $level }}][program]" id="{{ Str::slug($level) }}_program"
                           value="{{ old('education.' . $level . '.program', is_array($education_data[$level]['program'] ?? null) ? implode(',', $education_data[$level]['program']) : ($education_data[$level]['program'] ?? '')) }}">
                @endif

                <label for="{{ Str::slug($level) }}_awards">Awards (comma separated)</label>
                <input type="text" name="education[{{ $level }}][awards]" id="{{ Str::slug($level) }}_awards"
                       value="{{ old('education.' . $level . '.awards', is_array($education_data[$level]['awards'] ?? null) ? implode(',', $education_data[$level]['awards']) : ($education_data[$level]['awards'] ?? '')) }}">
            @endforeach
        </div>

        <!-- Skills -->
        <div class="section">
            <h2>Skills</h2>
            <input type="text" name="skills"
                   value="{{ old('skills', is_array($resume->skills) ? implode(',', $resume->skills) : ($resume->skills ?? '')) }}">
            <small>Separate skills with commas.</small>
        </div>

        <button type="submit">Save Resume</button>

        <!-- View Resume Button (opens in new tab) -->
        <a href="{{ route('resume.public', Auth::id()) }}" target="_blank" 
        class="view-resume-btn" 
        style="display:block; text-align:center; margin:15px auto 0; padding:12px 25px; 
                background-color:#5C4B1A; color:white; border-radius:8px; font-weight:bold; 
                text-decoration:none; transition:all 0.3s ease;">
            View Resume
        </a>
    </form>
</div>
@endsection
