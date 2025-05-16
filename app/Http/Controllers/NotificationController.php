<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'body' => 'required|string'
            ]);

            // Get the stored FCM token from your database
            $fcmToken = auth()->user()->fcm_token; // Adjust this based on your user model

            if (!$fcmToken) {
                return response()->json(['error' => 'No FCM token found'], 400);
            }

            // Initialize Firebase
            $factory = (new Factory)
                ->withServiceAccount(storage_path('app/firebase-credentials.json'))
                ->withDatabaseUri('https://pemweb-f3303-default-rtdb.asia-southeast1.firebasedatabase.app');

            $messaging = $factory->createMessaging();

            // Create the message
            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(Notification::create($request->title, $request->body));

            // Send the message
            $messaging->send($message);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
