<?php

namespace App\Domain\Notifications\FirebaseDeviceToken\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FirebaseDeviceTokenDTO extends DataTransferObject
{
    /** @var integer */
    public $id;
    /** @var integer */
    public $user_id;
    /** @var string */
    public $device_token;

    public static function fromRequest($request)
    {
        return new self([
            'id'=> $request['id'] ?? null,
            'user_id'=> $request['user_id'] ?? null,
            'device_token'=> $request['fcm_token'] ?? null,
        ]);

    }
}
