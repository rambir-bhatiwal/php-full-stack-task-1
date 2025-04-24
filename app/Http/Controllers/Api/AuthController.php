<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;


/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel 12 Full Stack API",
 *     description="Documentation for registration, login, logout, and user APIs",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Main API Server"
 * )
 */

class AuthController extends Controller
{
    // register method to handle user registration

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *             ),
     *             @OA\Property(property="token", type="string", example="2|tokenstringexample")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation errors")
     * )
     */


    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'We need your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'You must create a password.',
            'password.confirmed' => 'Passwords do not match.',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with the validation errors
            return response()->json($validator->errors(), 422);
        }
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;
        // Return a JSON response with the user data and token
        return response()->json([
            'message' => 'User registered successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and return token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged in successfully."),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *             ),
     *             @OA\Property(property="token", type="string", example="2|tokenstringexample")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation errors")
     * )
     */


    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Check if validation fails 
        if ($validator->fails()) {
            // Return a JSON response with the validation errors
            return response()->json($validator->errors(), 422);
        }
        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        // Check if the user exists and the password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Return a JSON response with the error message
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;
        // Return a JSON response with the user data and token
        return response()->json([
            'message' => 'User logged in successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Log out the authenticated user (revoke token)",
     *     tags={"Auth"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="User logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged out successfully.")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */


    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();
        // Return a JSON response with a success message
        return response()->json(['message' => 'User logged out successfully.']);
    }
    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get the authenticated user's information",
     *     tags={"Auth"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */


    public function user(Request $request)
    {
        // Return a JSON response with the authenticated user's data
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ]);
    }
}
