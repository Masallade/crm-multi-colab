<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PushNotificationToken;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{
    public function sendPush(Request $request, FirebaseService $firebase)
    {
        dd('ok');
        $request->validate([
            'token' => 'required',
            'title' => 'required',
            'body' => 'required',
        ]);

        $response = $firebase->sendNotification(
            $request->token,
            $request->title,
            $request->body
        );

        return response()->json([
            'status' => true,
            'message' => 'Notification sent',
            'response' => $response
        ]);
    }

    public function saveToken(Request $request)
    {

        // dd(auth()->user());

        $request->validate([
            'token' => 'required|string',
        ]);
    
        // Optional: Link token to authenticated user
        $user = auth()->user();
    
        $exists = PushNotificationToken::where('token', $request->token)->exists();
    
        if (!$exists) {
            PushNotificationToken::create([
                'token' => $request->token,
                'user_id' => $user ? $user->id : null, // if using auth
            ]);
        }
    
        return response()->json(['message' => 'Token saved successfully']);
    }
    
}
