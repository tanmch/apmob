<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function updateFCMToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();

        if ($user) {
            $user->fcm_token = $request->token;
            $user->save();

            return response()->json(['message' => 'FCM token updated successfully']);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
