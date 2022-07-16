<?php

namespace App\Domain\Notifications\FirebaseDeviceToken\Actions;

use App\Domain\Notifications\FirebaseDeviceToken\DTO\FirebaseDeviceTokenDTO;
use App\Domain\Notifications\FirebaseDeviceToken\Model\FirebaseDeviceToken;
use Illuminate\Support\Facades\Auth;

class AddFirebaseDeviceTokenAction
{
    public static function execute(FirebaseDeviceTokenDTO $firebaseDeviceTokenDTO){
        $badToken = FirebaseDeviceToken::where('device_token',$firebaseDeviceTokenDTO->device_token)->whereNotIn('user_id', [$firebaseDeviceTokenDTO->user_id])->delete();

        $firebaseDeviceToken = FirebaseDeviceToken::where('device_token',$firebaseDeviceTokenDTO->device_token)->where('user_id', $firebaseDeviceTokenDTO->user_id)->first();

        if($firebaseDeviceToken != null) return $firebaseDeviceToken;
        
        $firebaseDeviceToken = new FirebaseDeviceToken($firebaseDeviceTokenDTO->toArray());
        $firebaseDeviceToken->save();
        return $firebaseDeviceToken;
    }
}
