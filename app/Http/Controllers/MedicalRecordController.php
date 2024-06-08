<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', MedicalRecord::class);
        return MedicalRecord::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', MedicalRecord::class);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);
        return MedicalRecord::create($validated);
    }

    public function show(MedicalRecord $record)
    {
        $this->authorize('view', $record);
        return $record;
    }

    public function update(Request $request, MedicalRecord $record)
    {
        $this->authorize('update', $record);
        $validated = $request->validate([
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
        ]);
        $record->update($validated);
        return $record;
    }

    public function destroy(MedicalRecord $record)
    {
        $this->authorize('delete', $record);
        $record->delete();
        return response()->noContent();
    }
}
