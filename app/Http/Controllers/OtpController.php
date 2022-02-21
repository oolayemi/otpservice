<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function generateOtp(Request $request)
    {
        $user = $request->user();
        $otp = rand(1000, 9999);
        $userOtp = $user->otp;

        if ($userOtp) {
            $userOtp->update([
                'user_id' => $user->id,
                'is_used' => false,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]);
        } else {
            Otp::create([
                'user_id' => $user->id,
                'is_used' => false,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => "Otp code created"
        ], 201);
    }


    public function verifyOtp(Request $request, $otp)
    {
        $user = $request->user();

        $userOtp = $user->otp;

        if (!$userOtp || $userOtp->is_used || $userOtp->expires_at < now()) {
            return response()->json([
                'status' => false,
                'message' => "An error occurred",
                'error' => "Invalid OTP, kindly request for another one"
            ], 400);
        }

        if ($userOtp->otp == $otp) {

            // perform whatever operation you want to do when otp is verified

            $userOtp->update([
                'is_used' => true
            ]);

            return response()->json([
                'status' => true,
                'message' => "Otp verified"
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => "An error occurred",
            'error' => "Otp is incorrect, please try again"
        ], 400);
    }
}
