<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => Hash::make($req['password'])
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
}
