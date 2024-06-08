<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Patient::class);
        return Patient::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Patient::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
        ]);
        return Patient::create($validated);
    }

    public function show(Patient $patient)
    {
        $this->authorize('view', $patient);
        return $patient;
    }

    public function update(Request $request, Patient $patient)
    {
        $this->authorize('update', $patient);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:patients,email,' . $patient->id,
        ]);
        $patient->update($validated);
        return $patient;
    }

    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);
        $patient->delete();
        return response()->noContent();
    }
}
