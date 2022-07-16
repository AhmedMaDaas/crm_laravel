<?php

namespace App\Domain\Notifications\FirebaseDeviceToken\Actions;

use App\Domain\Notifications\FirebaseDeviceToken\DTO\FirebaseDeviceTokenDTO;
use App\Domain\Notifications\FirebaseDeviceToken\Model\FirebaseDeviceToken;
use Illuminate\Support\Facades\Auth;

class SendSyncNotificationAction
{
    public static function execute($usersIds, $notificationTitle, $notificationBody){
        $firebaseToken = FirebaseDeviceToken::whereIn('user_id', $usersIds)->pluck('device_token')->all();

        $SERVER_API_KEY = env('FIREBASE_API_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "data" => [
                "title" => $notificationTitle,
                "body" => $notificationBody,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        return $response;
    }
}
