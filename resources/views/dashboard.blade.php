@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom, #FFF9C4, #FFE082, #FDD835);
        font-family: 'Poppins', sans-serif;
        padding: 40px 0;
    }

    .dashboard-container {
        background: #fffef7;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        max-width: 900px;
        margin: auto;
        padding: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-container:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        color: #4E342E;
        text-shadow: 1px 1px #FFF176;
        margin-bottom: 1rem;
    }

    h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #5D4037;
        border-bottom: 3px solid #FFD54F;
        padding-bottom: 5px;
        margin-bottom: 20px;
    }

    .info-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .info-card {
        background: linear-gradient(to bottom right, #FFF8E1, #FFECB3);
        border-radius: 15px;
        padding: 20px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-6px);
        background: linear-gradient(to bottom right, #FFF3E0, #FFE082);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .info-card p:first-child {
        font-weight: 700;
        color: #4E342E;
    }

    .info-card p:last-child {
        color: #3E2723;
        margin-top: 5px;
    }

    .skills span {
        background: #fff;
        color: #2E7D32;
        padding: 5px 12px;
        border-radius: 15px;
        margin: 4px;
        display: inline-block;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .skills span:hover {
        background: #C8E6C9;
        transform: scale(1.05);
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .action-buttons a {
        padding: 12px 25px;
        font-weight: 600;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .action-buttons a:hover {
        transform: scale(1.05);
    }

    .edit-btn {
        background-color: #42A5F5;
    }

    .edit-btn:hover {
        background-color: #1E88E5;
    }

    .view-btn {
        background-color: #66BB6A;
    }

    .view-btn:hover {
        background-color: #43A047;
    }

    /* Fade-in animation for sections */
    .fade-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-section.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="dashboard-container fade-section">
    <!-- Welcome Header -->
    <h1>🌻 Welcome, {{ Auth::user()->name }}!</h1>
    <p class="text-center text-gray-700 mb-6">Here’s your personal dashboard. Manage your resume and profile details easily!</p>

    <!-- Resume Summary -->
    <h2>✨ Your Resume Summary</h2>

    <div class="info-section">
        <div class="info-card">
            <p>Email</p>
            <p>{{ Auth::user()->email }}</p>
        </div>

        <div class="info-card">
            <p>Contact Number</p>
            <p>{{ Auth::user()->resume->contact_number ?? 'Not Provided' }}</p>
        </div>

        <div class="info-card">
            <p>Skills</p>
            <div class="skills">
                @if(Auth::user()->resume && Auth::user()->resume->skills)
                    @foreach(explode(',', Auth::user()->resume->skills) as $skill)
                        <span>{{ trim($skill) }}</span>
                    @endforeach
                @else
                    <p>Not Provided</p>
                @endif
            </div>
        </div>

        <div class="info-card">
            <p>Education</p>
            <p>{{ Auth::user()->resume->education ?? 'Not Provided' }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('resume.edit') }}" class="edit-btn">✏️ Edit Resume</a>
        <a href="{{ route('resume.public', Auth::id()) }}" target="_blank" class="view-btn">🌿 View Public Resume</a>
    </div>
</div>

<script>
    // Fade-in animation when scrolled into view
    const sections = document.querySelectorAll('.fade-section');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.2 });

    sections.forEach(section => observer.observe(section));
</script>
@endsection
