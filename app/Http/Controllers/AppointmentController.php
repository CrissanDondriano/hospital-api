<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        $doctors = Doctor::all();
        $patients = Patient::all();

        return response()->json([
            'appointments' => $appointments,
            'doctors' => $doctors,
            'patients' => $patients,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
        ]);
    
        // Retrieve the doctor and patient from the database
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $patient = Patient::findOrFail($validated['patient_id']);
    
        // Create the appointment with the user_ids of doctor and patient
        $appointment = Appointment::create([
            'doctor_id' => $doctor->user_id,
            'patient_id' => $patient->user_id,
            'doctor_name' => $doctor->name,
            'patient_name' => $patient->name,
            'date' => $validated['date'],
        ]);
    
        return response()->json($appointment, 201);
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
            $doctor = Doctor::whereRaw('LOWER(name) = ?', [strtolower($validated['doctor_name'])])->firstOrFail();
            $appointment->doctor_id = $doctor->user_id;
            $appointment->doctor_name = $doctor->name;
        }

        if (isset($validated['patient_name'])) {
            $patient = Patient::whereRaw('LOWER(name) = ?', [strtolower($validated['patient_name'])])->firstOrFail();
            $appointment->patient_id = $patient->user_id;
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
