<?php

namespace App\Services;

use App\Models\Claim;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PushNotification
{

    public $firebaseURL = 'https://fcm.googleapis.com/v1/projects/pensioncmp/messages:send';


    public function getFcmToken()
    {

        $client = new \Google_Client();
        $client->setAuthConfig('../public/dist/pensioncmp-firebase-adminsdk-wacqb-a08d349ea4.json');
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();
        return $token['access_token'];
    }


    public function sendPushNotification(string $title, string $message, $claimid)
    {

        try {
            $oAuthToken = $this->getFcmToken();

            $users = User::all();
            foreach ($users as $user) {
                if ($user->fcm_token == null) {
                    Log::info("Not FCM Toekn gound");
                    continue;
                }
                $claim = Claim::find($claimid);
                $data = [
                    'message' => [
                        "token" => $user->fcm_token,
                        "notification" => [
                            "title" => $title,
                            "body" => $message,
                        ],
                        "data" => [ //some extra data to add
                            // "url" =>  url('/claim?claimid='.$claimid)
                            "url" => url('claim-details?claimid='.$claim?->claimid)
                        ]
                    ]
                ];

                $headers = [
                    'Authorization' => 'Bearer ' . $oAuthToken,
                    'Content-Type' => 'application/json',
                ];

                $response = Http::withHeaders($headers)->post($this->firebaseURL, $data);
                // Log::info($title);
                // Log::info($message);
                Log::info($response);
            }
        } catch (Exception $e) {
            Log::error('PUSH NOTIFICATION ERROR : UNABLE TO SEND NOTIFICATION => '.$e->getMessage());
        }
    }
}
