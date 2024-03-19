<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{

    /**
     * Register The User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            event(new Registered($user));

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'User Regustered Successfully',
                'token_type' => 'Bearer',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], ResponseAlias::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], ResponseAlias::HTTP_UNAUTHORIZED);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token_type' => 'Bearer',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], ResponseAlias::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}