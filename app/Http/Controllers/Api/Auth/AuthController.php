<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $userValidator = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'device_name' => 'required|min:3'
    ];
    public function auth(Request $request)
    {
        $user =  User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            throw  ValidationException::withMessages(
                [
                    'email' => ['the provided credentials are incorrect']
                ]
            );
        }
        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {


        $validator =  Validator::make($request->all(), $this->userValidator);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        if(!$user->save()){
            return response()->json([
                'errors' => "Error as ocurred in user register"
            ], 422);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json([
            'token' => $token,
        ]);


    }
}
