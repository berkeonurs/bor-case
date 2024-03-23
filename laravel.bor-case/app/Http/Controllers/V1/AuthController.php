<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'string|required',
            'password' => 'string|required'
        ]);
        if (!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid login details'
            ],401);
        }
        $user = User::where('email',$request['email'])->firstOrFail();
        $token = $user->createToken($request['email'])->plainTextToken;

        return response()->json([
           'status' => 'success',
           'message' => 'User login successfully',
           'access_token' => $token,
           'user_name' => $user->name
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'string|required',
            'password' => 'string|required',
            'name' => 'string|required'
        ]);
        try{
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password'])
            ]);
        }catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
               return response()->json([
                  'status' => 'error',
                  'message' => 'duplicate'
               ],500);
            }
        }
        $token = $user->createToken($request['email'])->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'access_token' => $token,
            'user_name' => $user->name
        ]);
    }
}
