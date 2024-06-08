<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Get all patients
    public function index()
    {
        return Patient::all();
    }

    // Create a new patient
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
        ]);

        return Patient::create($validated);
    }

    // Get a single patient
    public function show($id)
    {
        return Patient::findOrFail($id);
    }

    // Update a patient
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:patients,email,' . $patient->id,
        ]);

        $patient->update($validated);

        return $patient;
    }

    // Delete a patient
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->noContent();
    }
}
