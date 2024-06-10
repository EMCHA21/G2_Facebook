<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Login success',
            'data'  => $request->user(),
        ]);
    }

    public function reset_Password(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:6|max:100'
            ]
        );
        $user = $request->user();
        return $user;
        if ($validateUser->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 422);
        };

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Old password is not correct'
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        // return $request;
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
    public function index()
    {
        return User::list();
    }

    public function show($id)
    {
        $data = User::find($id);
        try {
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => "success to find user"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        try {
            $data->update(
                [
                    "name" => $request->name,
                    "email" => $request->email,
                    "email_verified_at" => $request->email_verified_at,
                    "password" => Hash::make($request->password)
                ]
            );
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'success to updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
