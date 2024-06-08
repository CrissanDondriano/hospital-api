<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Doctor::class);
        return Doctor::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Doctor::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
        ]);
        return Doctor::create($validated);
    }

    public function show(Doctor $doctor)
    {
        $this->authorize('view', $doctor);
        return $doctor;
    }

    public function update(Request $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:doctors,email,' . $doctor->id,
        ]);
        $doctor->update($validated);
        return $doctor;
    }

    public function destroy(Doctor $doctor)
    {
        $this->authorize('delete', $doctor);
        $doctor->delete();
        return response()->noContent();
    }
}
