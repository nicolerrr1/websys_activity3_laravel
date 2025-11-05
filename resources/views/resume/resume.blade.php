<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

<div class="paper">
    <img src="{{ asset('ID.jpg') }}" alt="Profile Picture" class="profile-pic">

    @php
        $name = "NICOLE A. RAFOLS"; 
        $address = "0324 Centro-Uno, Brgy. Calitcalit, San Juan, Batangas";
        $mobile = "+639627224651";
        $email = "21-08560@g.batstate-u.edu.ph";

        $personal_data = [
            "Date of Birth" => "May 08, 2002",
            "Place of Birth"=> "San Juan, Batangas",
            "Civil Status"=> "Single",
            "Citizenship"=> "Filipino",
            "Religion"=> "Protestant",
            "Height"=> "5'4 feet",
            "Weight"=> "143 lbs",
        ];

        $education_data = [
            "Primary" => [
                "school"=> "San Juan West Central School (Class 2015)",
                "awards"=> ["Musician of the Year"]
            ],
            "Secondary"=> [
                "school"=> "Joseph Marello Institute, Inc. (Class 2021)",
                "awards"=> [
                    "Aerospace Cadets of the Philippines Awardee",
                    "Academic Achiever (With Honors)"
                ]
            ],
            "Tertiary"=> [
                "school"=> "Batangas State University - TNEU",
                "program"=> ["Bachelor of Science in Computer Science"]
            ],
        ];

        $skills = [
            "Python for Data Analysis",
            "SQL for Databases",
            "Data Visualization (Matplotlib, Seaborn, Excel)"
        ];
    @endphp

    <h1>{{ $name }}</h1>
    <p>{{ $address }}<br>Mobile: {{ $mobile }}<br>Email: <a href="mailto:{{ $email }}">{{ $email }}</a></p>

    <h2>Personal Data</h2>
    <ul>
        @foreach($personal_data as $label => $value)
            <li><strong>{{ $label }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>

    <h2>Educational Background</h2>
    <ul>
        @foreach($education_data as $level => $info)
            <li>
                <strong>{{ $level }}:</strong> {{ $info["school"] }}
                @if(!empty($info["awards"]))
                    <ul>
                        @foreach($info["awards"] as $award)
                            <li><em>{{ $award }}</em></li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty($info["program"]))
                    <ul>
                        @foreach($info["program"] as $program)
                            <li><em>{{ $program }}</em></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <h2>Skills</h2>
    <ul class="skills-list">
        @foreach($skills as $skill)
            <li>{{ $skill }}</li>
        @endforeach
    </ul>
</div>

</body>
</html>
