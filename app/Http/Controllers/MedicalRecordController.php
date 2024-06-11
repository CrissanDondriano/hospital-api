<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::all();
        $patients = Patient::all();

        return response()->json([
            'records' => $records,
            'patients' => $patients
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $patient = Patient::whereRaw('LOWER(name) = ?', [strtolower($validated['patient_name'])])->firstOrFail();

        $record = MedicalRecord::create([
            'patient_id' => $patient->user_id,
            'patient_name' => $patient->name,
            'description' => $validated['description'],
            'date' => $validated['date'],
        ]);

        return $record;
    }

    public function show($id)
    {
        return MedicalRecord::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::findOrFail($id);

        $validated = $request->validate([
            'patient_name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
        ]);

        if (isset($validated['patient_name'])) {
            $patient = Patient::whereRaw('LOWER(name) = ?', [strtolower($validated['patient_name'])])->firstOrFail();
            $record->patient_id = $patient->user_id;
            $record->patient_name = $patient->name;
        }

        if (isset($validated['description'])) {
            $record->description = $validated['description'];
        }

        if (isset($validated['date'])) {
            $record->date = $validated['date'];
        }

        $record->save();

        return $record;
    }

    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $record->delete();

        return response()->noContent();
    }
}
