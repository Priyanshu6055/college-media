<?php

namespace App\Http\Controllers;

use App\Models\User; // Assuming the User model contains the students
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        // Fetch all students
        $students = User::where('role', 'student')->get();

        // Pass students to the teacher dashboard view
        return view('teacher.dashboard', compact('students'));
    }
}
