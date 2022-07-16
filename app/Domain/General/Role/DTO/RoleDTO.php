<?php

namespace App\Domain\General\Role\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class RoleDTO extends DataTransferObject
{

    /* @var integer */
    public $id;
    /* @var string */
    public $name;

    public static function fromRequest($request){
        return new self([
            'id' => $request['id'] ?? null,
            'name' => $request['name'] ?? null,
        ]);
    }
}
