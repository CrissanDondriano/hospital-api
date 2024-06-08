<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Appointment::class);
        return Appointment::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Appointment::class);
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
        ]);
        return Appointment::create($validated);
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        return $appointment;
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        $validated = $request->validate([
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'patient_id' => 'sometimes|required|exists:patients,id',
            'date' => 'sometimes|required|date',
        ]);
        $appointment->update($validated);
        return $appointment;
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return response()->noContent();
    }
}

