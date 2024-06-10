<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string',
            'patient_name' => 'required|string',
            'date' => 'required|date',
        ]);

        $doctor = User::whereRaw('LOWER(name) = ?', [strtolower($validated['doctor_name'])])->firstOrFail();
        $patient = User::whereRaw('LOWER(name) = ?', [strtolower($validated['patient_name'])])->firstOrFail();

        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'doctor_name' => $doctor->name,
            'patient_name' => $patient->name,
            'date' => $validated['date'],
        ]);

        return $appointment;
    }

    public function show($id)
    {
        return Appointment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'doctor_name' => 'sometimes|required|string',
            'patient_name' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
        ]);

        if (isset($validated['doctor_name'])) {
            $doctor = User::whereRaw('LOWER(name) = ?', [strtolower($validated['doctor_name'])])->firstOrFail();
            $appointment->doctor_id = $doctor->id;
            $appointment->doctor_name = $doctor->name;
        }

        if (isset($validated['patient_name'])) {
            $patient = User::whereRaw('LOWER(name) = ?', [strtolower($validated['patient_name'])])->firstOrFail();
            $appointment->patient_id = $patient->id;
            $appointment->patient_name = $patient->name;
        }

        if (isset($validated['date'])) {
            $appointment->date = $validated['date'];
        }

        $appointment->save();

        return $appointment;
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->noContent();
    }
}
