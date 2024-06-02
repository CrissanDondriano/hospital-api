<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    
    public function index() {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function store(Request $request){
        $doctors = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'specialization' => $request->specialization,
        ]);
        return response()->json($doctors, 201);
    }

    public function show($id){
        $doctors = Doctor::find($id);
        return response()->json($doctors, 200);
    }

    // public function search($name){
    //     $doctors = Doctor::with('doctor')->where('name', 'like', '%' . $name . '%')->get();
    //     return response()->json($doctors, 200);        
    // }

    public function update(Request $request, $id){
        $doctors = Doctor::find($id);
        $doctors->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'specialization' => $request->specialization,
        ]);
        return response()->json($doctors, 200);
    }

    public function destroy($id){
        $doctors = Doctor::find($id);
        $doctors->delete();
        return response()->json(null, 204);
    }
}
