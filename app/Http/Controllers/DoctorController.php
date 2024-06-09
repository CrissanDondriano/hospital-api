<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index()
    {
        return Doctor::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors',
        ]);

        $randomPassword = Str::random(8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($randomPassword), 
            'role' => 'doctor',
        ]);

        $validated['user_id'] = $user->id;

        $doctor = Doctor::create($validated);

        return response()->json([
            'doctor' => $doctor,
            'user' => $user,
            'password' => $randomPassword, 
        ]);
    }

    public function show($id)
    {
        return Doctor::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email,' . $doctor->id,
        ]);

        $doctor->update($validated);

        return $doctor;
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->noContent();
    }
}
