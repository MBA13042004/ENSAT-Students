<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search and pagination
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('apogee', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apogee' => 'required|string|unique:students,apogee',
            'cin' => 'required|string|unique:students,cin',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'filiere' => 'nullable|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'telephone' => 'nullable|string|max:20',
        ]);

        Student::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant créé avec succès');
    }

    /**
     * Display the specified student
     */
    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in database
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'apogee' => 'required|string|unique:students,apogee,' . $student->id,
            'cin' => 'required|string|unique:students,cin,' . $student->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'filiere' => 'nullable|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'telephone' => 'nullable|string|max:20',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant modifié avec succès');
    }

    /**
     * Remove the specified student from database
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Étudiant supprimé avec succès');
    }
}
