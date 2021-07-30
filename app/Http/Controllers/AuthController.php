<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $employee = Employee::where('cpf', $fields['cpf'])->first();

        // Check password
        if(!$employee || !Hash::check($fields['password'], $employee->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $employee->createToken('myapptoken')->plainTextToken;

        $response = [
            'employee' => $employee,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->employee()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
