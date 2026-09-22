<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  public function login(Request $request)
  {
   $credentials = $request->validate([
    'email' => 'required|email',
    'password' => 'required'
   ]);

   $user = User::where('email',
   $credentials['email'])->first();

   if(!user || !Hash::check($credentials['password'],
   $user->pasword)){
    return response()->json([
        'message' => 'Invalid email or password'
    ],401);
   }

   $token = $user->createToken('mobile-app')->plainTextToken;

   return response()->json([
    'message' => 'Login successful',
    'token' => $token,
    'user' => $user,
   ]);
  }  //
}
