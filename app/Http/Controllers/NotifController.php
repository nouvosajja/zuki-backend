<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifController extends Controller
{
    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification($userToken, $judul, $pesan)
    {

        $SERVER_API_KEY = env('FCM_SERVER_KEY', 'IssUb7pRvHfgY1q7hNfB0M3ZtSRTfmSc0'); // ini dari file .env (Server key
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        $data = [
            "registration_ids" => $userToken,
            "notification" => [
                "title" => $judul,
                "body" => $pesan,
                "content_available" => true,
                "priority" => "high",
            ],
            "data" => [
                "icon" => ''
            ]
        ];
        
        $dataString = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // Log response for debugging purposes
        Log::info($response);

        // You can also add error handling here if needed
        if ($response === false) {
            Log::error(curl_error($ch));
        }

        curl_close($ch);

        return response()->json(['response' => 'success']);
    }

}
