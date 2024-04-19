<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthTokensController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->tokens;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
            'device_name' => ['required'],
        ]);

        Auth::validate($request->only('email', 'password'));
        $user = User::where('email', $request->only('email'))->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // To create user token with all permissions
            //$token = $user->createToken($request->device_name, ['*']);

            // To create user token but with specific permissions
            $token = $user->createToken($request->device_name, ['projects.create', 'projects.update']);
            return response()->json([
             'token' => $token->plainTextToken,
             'user' => $user
            ], 201);
        }

        return response()->json([
            'message' => 'Invalid credentials...!'
        ], 401);
    }

    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();

        // To Logout from the current device
        //$user->currentAccessToken()->delete();

        // To Logout from a specific device
        $user->tokens()->findOrFail($id)->delete();

        // To Logout from all devices
        //$user->tokens()->delete();

        return [
            'message' => 'Token deleted.'
        ];
    }

}
