<?php

namespace App\Domain\General\User\Actions;

use App\Http\ViewModels\General\User\ShowOneUserVM;
use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;
use Helper;

class LoginUserAction
{
	public static function execute($userData){
		$token = $userData->createToken('authToken')->plainTextToken;
		$info = (new ShowOneUserVM($userData->id))->toItem()->toArray();
		$info['token'] = $token;
		return $info;
	}
}