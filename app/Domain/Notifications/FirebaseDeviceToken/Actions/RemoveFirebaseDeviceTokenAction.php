<?php

namespace App\Domain\Notifications\FirebaseDeviceToken\Actions;

use App\Domain\Notifications\FirebaseDeviceToken\DTO\FirebaseDeviceTokenDTO;
use App\Domain\Notifications\FirebaseDeviceToken\Model\FirebaseDeviceToken;
use Illuminate\Support\Facades\Auth;

class RemoveFirebaseDeviceTokenAction
{
    public static function execute(FirebaseDeviceTokenDTO $firebaseDeviceTokenDTO){
    	$firebaseDeviceToken = FirebaseDeviceToken::find($firebaseDeviceTokenDTO->id);
        $firebaseDeviceToken->delete();
        return "deleted successfully.";
    }
}
