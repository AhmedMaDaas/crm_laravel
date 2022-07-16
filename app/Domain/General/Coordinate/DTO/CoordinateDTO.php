<?php

namespace App\Domain\General\Coordinate\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CoordinateDTO extends DataTransferObject
{

    /* @var integer */
    public $id;
    /* @var string */
    public $longitude;
    /* @var string */
    public $latitude;
    /* @var integer */
    public $user_id;

    public static function fromRequest($request){
        return new self([
            'id' => $request['id'] ?? null,
            'longitude' => $request['longitude'] ?? null,
            'latitude' => $request['latitude'] ?? null,
            'user_id' => $request['user_id'] ?? null,
        ]);
    }
}
