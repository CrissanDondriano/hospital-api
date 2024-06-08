<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        return MedicalRecord::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        return MedicalRecord::create($validated);
    }

    public function show($id)
    {
        return MedicalRecord::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::findOrFail($id);
        $validated = $request->validate([
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
        ]);

        $record->update($validated);

        return $record;
    }

    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $record->delete();

        return response()->noContent();
    }
}
