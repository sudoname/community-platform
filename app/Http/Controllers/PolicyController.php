<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display Terms of Service page
     */
    public function terms()
    {
        return view('policy.terms');
    }

    /**
     * Display Facebook Data Deletion Instructions
     * Required by Facebook Platform Policy
     */
    public function facebookDeletion()
    {
        return view('policy.facebook-deletion');
    }

    /**
     * Handle Facebook Data Deletion Request
     */
    public function handleFacebookDeletion(Request $request)
    {
        // Log the deletion request
        \Log::info('Facebook data deletion request received', [
            'signed_request' => $request->input('signed_request'),
            'timestamp' => now(),
        ]);

        // Return confirmation URL and confirmation code
        $confirmationCode = 'DEL_' . uniqid();

        return response()->json([
            'url' => url('/auth/facebook/deletion?confirmation=' . $confirmationCode),
            'confirmation_code' => $confirmationCode,
        ]);
    }
}
