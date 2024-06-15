<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * find me.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Login success',
            'data'  => $request->user(),
        ]);
    }
    /**
     * Log out .
     */
    public function logout(Request $request)
    {
        // return $request;
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
    /**
     * Get all resource from storage.
     */
    public function index()
    {
        $data = User::list();
        try {
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Success to get all user'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
    /**
     * Get the specified resource from storage.
     */
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
    /**
     * upate infor of user like name eamil or password.
     */
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
    /**
     * Update profile image of user.
     */
    public function uploadProfile(Request $request, $id)
    {
        $validateUser = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validateUser->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 422);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads/', $imageName);
        try {
            $user = User::find($id);
            $user->update([
                'profile' => $imageName
            ]);
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => 'Profile updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        try {
            return response()->json([
                'success' => true,
                'message' => 'Success to delete user'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
