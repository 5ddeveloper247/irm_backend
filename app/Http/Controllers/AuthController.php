<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
// CustomerRequest
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
// EnrollCourse
use App\Models\EnrollCourse;
// use App\Models\UserDetail;
class AuthController extends Controller
{
    public function customerregister(Request $request)
    {
        // c_password confrimed
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
            // phoneNumber, birthdate, gender
            'phoneNumber' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
        ]);
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);
        // Create a new user
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'=> 2
        ]);
        $user->userDetail()->create([
            'user_id' => $user->id,
            'phoneNumber' => (string) $request->phoneNumber,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
        ]);
        // Generate a JWT token for the new user
        // $token = JWTAuth::fromUser($user);
        // Generate token using the `register` guard
        $token = Auth::guard('register')->login($user);

        // Return the token and user info
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // verify token
    public function verifyToken(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user = JWTAuth::authenticate($request->token);
        return response()->json([
            'user' => $user,
        ], 200);
    }
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Credentials for authentication
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
        $token = Auth::guard('register')->login(auth()->user());
        // Return the token and user information
        // add enrole course
       
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     try {
    //         if (!$token = JWTAuth::attempt($credentials)) {
    //             return response()->json(['error' => 'Invalid credentials'], 401);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'Could not create token'], 500);
    //     }

    //     return response()->json(compact('token'));
    // }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}

