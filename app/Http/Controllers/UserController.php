<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {
        try {

            request()->validate([
                'fast_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required|string',
                'password' => 'required|string|min:8',
                'role' => 'nullable|string',
            ]);
            
            $user = User::create([
                'fast_name' => $request->input('fast_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
                'role' => $request->input('role') ?? 'customer',
            ]);

            return response()->json([
                'message' => 'User created successfully',
                'status' => 'success',
                'data' => $user,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'status' => 'error',
            ], 500);
        }

    }

    function UserLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 'error',
            ], 401);
        }

        $token = JWTToken::CreateToken($request->input('email'), $user->id, $user->role);

        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard')->withCookie(cookie('token', $token, 60 * 24));

            case 'customer':
                return redirect('/customer/home')->withCookie(cookie('token', $token, 60 * 24));

            case 'employee':
                return redirect('/employee/home')->withCookie(cookie('token', $token, 60 * 24));

            default:
                return response()->json([
                    'message' => 'Invalid role.',
                    'status' => 'error',
                ], 403);
        }
    }

    function SentOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->input('email');
        $otp = rand(1000, 9999);

        try {

            Mail::to($email)->send(new OTPMail($otp));

            User::where('email', $email)->update([
                'otp' => $otp,
                'created_at' => now()
            ]);
            return response()->json([
                'message' => 'OTP sent successfully',
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send OTP',
                'status' => 'error',
            ], 500);
        }
    }

    function VerifyOTP(Request $request)
    {


        $email = $request->input('email');
        $otp = $request->input('otp');
        $otpValidityMinutes = 5;

        $user = User::where('email', $email)->first();


        if ($user && $user->otp === $otp) {

            $otpTime = now()->diffInMinutes($user->created_at);

            if ($otpTime > $otpValidityMinutes) {
                return response()->json([
                    'status' => 'error',
                    'message' => ' your OTP is expired😢. Please try again from the beginning'
                ], 401);
            }

            $user->update([
                'otp' => 0,
                'created_at' => null
            ]);


            $token = JWTToken::CreateTokenForPassword($email, $user->id, $user->role);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successful',
            ], 200)->cookie('token', $token, 60 * 60);
        } else {

            $otpTime = now()->diffInMinutes($user->created_at);
            $remainingTime = max(0, $otpValidityMinutes - $otpTime);

            if ($remainingTime == 0) {

                return response()->json([
                    'status' => 'error',
                    'message' => ' your valid OTP time is finished😢. and this is invalid OTP '
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid your OTP. Please enter valid OTP Within ' . $remainingTime . ' minutes '
            ], 401);
        }
    }

    function ResetPassword(Request $request)
    {
        try {

            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', $email)->update([
                'password' => bcrypt($password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }

    }

    function Logout(Request $request)
    {


        if ($request->cookie('token')) {
            return response()->json([
                'status' => 'success',
                'message' => 'You are logged out successfully'
            ], 200)->cookie('token', '', -1);
        }
        return redirect('/userLogin');


    }

}
