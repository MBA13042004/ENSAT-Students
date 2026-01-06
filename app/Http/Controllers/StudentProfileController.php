<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    /**
     * Display the student's profile
     */
    public function show(Request $request)
    {
        $user = auth()->user();

        // Find student by email
        $student = Student::where('email', $user->email)->first();

        return view('student.profile', compact('student'));
    }
}
