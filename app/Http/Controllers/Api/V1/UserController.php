<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get current user profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return $this->response([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], 'User profile retrieved successfully');
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'current_password' => 'sometimes|required|string',
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        try {
            $user = $request->user();

            if ($request->has('password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return $this->errorResponse('Current password is incorrect', 400);
                }
                $user->password = Hash::make($request->password);
            }

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
                $user->email_verified_at = null;
            }

            $user->save();

            return $this->response([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ], 'Profile updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update profile', 500);
        }
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Password is incorrect', 400);
        }

        // Delete user tokens first
        $user->tokens()->delete();

        // Delete user
        $user->delete();

        return $this->response(null, 'Account deleted successfully');
    }
}
