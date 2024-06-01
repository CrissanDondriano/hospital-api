<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $user = User::all();
        return response()->json($user);
    }

    public function store(Request $request){
        $validator = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ],
        [
            'email.unique' => 'The email has already been taken.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);
        
        $user = User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password']),
        ]);
        
        return response()->json($user, 201);
    }

    public function show($id){
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function search($name){
        $user = User::with('user')->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($user, 200);        
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        $validator = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ],
        [
            'email.unique' => 'The email has already been taken.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        $user->update([
            'name' => $validator['name'] ?? $user->name,
            'email' => $validator['email'] ?? $user->email,
            'password' => isset($validator['password']) ? Hash::make($validator['password']) : $user->password,
        ]);

        return response()->json($user, 200);
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
