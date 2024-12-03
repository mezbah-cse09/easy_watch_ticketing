<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadImage(Request $request)
    {

        $path = $request->file('profileImg')->store('profiles', 'public');

        $profile = Profile::create([
            'user_id' => $request->input('user_id'),
            'profile_pic' => $path,
        ]);

        return response()->json([
            'message' => 'Profile picture uploaded successfully',
            'status' => 'success',
            'data' => $profile,
        ], 201);

    }

    public function profileShow(Request $request)
    {

        $profile = Profile::with('user')->where('user_id', $request->input('user_id'))->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error',
            ], 404);
        }

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'status' => 'success',
            'data' => $profile,
        ], 201);
    }

    public function updateProfile(Request $request)
    {

        $profile = Profile::with('user')->where('user_id', $request->input('user_id'))->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error',
            ], 404);
        }

        if ($request->hasFile('profilePic')) {

            if ($profile->profile_pic && Storage::exists('public/' . $profile->profile_pic)) {
                Storage::delete('public/' . $profile->profile_pic);
            }

            $path = $request->file('profilePic')->store('profiles', 'public');
            $profile->update([
                'profile_pic' => $path,
            ]);
        }

        $user = $profile->user;

        $user->fast_name = $request->filled('fast_name') ? $request->input('fast_name') : $user->fast_name;
        $user->last_name = $request->filled('last_name') ? $request->input('last_name') : $user->last_name;
        $user->phone = $request->filled('phone') ? $request->input('phone') : $user->phone;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'status' => 'success',
            'data' => $profile,
        ]);


    }

    public function deleteProfile(Request $request)
    {

        $profilePic = Profile::where('user_id', $request->input('user_id'))->first();

        if (!$profilePic) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error',
            ], 404);
        }

        $profilePic->delete();

        return response()->json([
            'message' => 'Profile picture deleted successfully',
            'status' => 'success',
        ]);
    }
}
