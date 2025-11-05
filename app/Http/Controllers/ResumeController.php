<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    // Show edit page
    public function edit()
    {
        $resume = Resume::firstOrCreate(
            ['user_id' => Auth::id()],
            ['name' => Auth::user()->name, 'email' => Auth::user()->email]
        );

        // Decode education and personal_data for form fields
        $resume->education = $resume->education ? json_decode($resume->education, true) : [];
        $resume->personal_data = $resume->personal_data ? json_decode($resume->personal_data, true) : [];
        $resume->skills = $resume->skills ? implode(',', json_decode($resume->skills, true)) : '';

        return view('resume.edit', compact('resume'));
    }

    // Update resume
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'education' => 'nullable|array',
            'personal_data' => 'nullable|array',
        ]);

        $resume = Resume::where('user_id', Auth::id())->first();

        if (!$resume) {
            $resume = new Resume();
            $resume->user_id = Auth::id();
        }

        // Basic info
        $resume->name = $request->input('name');
        $resume->email = $request->input('email');
        $resume->contact_number = $request->input('contact_number');
        $resume->address = $request->input('address');

        // Personal data stored as JSON
        $resume->personal_data = $request->has('personal_data') 
            ? json_encode($request->input('personal_data')) 
            : null;

        // Education stored as JSON
        $education = [];
        if ($request->has('education')) {
            foreach ($request->education as $level => $data) {
                $education[$level] = [
                    'school' => $data['school'] ?? '',
                    'awards' => !empty($data['awards']) 
                        ? array_map('trim', explode(',', $data['awards'])) 
                        : []
                ];

                // Primary and Secondary use "year", Tertiary keeps "program"
                if ($level === 'Tertiary') {
                    $education[$level]['program'] = !empty($data['program']) 
                        ? array_map('trim', explode(',', $data['program'])) 
                        : [];
                } else {
                    $education[$level]['year'] = $data['year'] ?? '';
                }
            }
        }
        $resume->education = json_encode($education);

        // Skills stored as JSON array
        $resume->skills = $request->filled('skills') 
            ? json_encode(array_map('trim', explode(',', $request->input('skills')))) 
            : null;

        $resume->save();

        return redirect()->route('resume.edit')->with('success', 'Resume updated successfully!');
    }

    // Public view
    public function show($id)
    {
        $resume = Resume::where('user_id', $id)->firstOrFail();

        // Decode JSON fields before passing to view
        $resume->personal_data = json_decode($resume->personal_data, true) ?? [];
        $resume->education = json_decode($resume->education, true) ?? [];
        $resume->skills = json_decode($resume->skills, true) ?? [];

        return view('resume.public', compact('resume'));
    }
}
