<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Get all doctors
    public function index()
    {
        return Doctor::all();
    }

    // Create a new doctor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
        ]);

        return Doctor::create($validated);
    }

    // Get a single doctor
    public function show($id)
    {
        return Doctor::findOrFail($id);
    }

    // Update a doctor
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:doctors,email,' . $doctor->id,
        ]);

        $doctor->update($validated);

        return $doctor;
    }

    // Delete a doctor
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->noContent();
    }
}
