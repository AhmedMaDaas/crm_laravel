<?php

namespace App\Domain\General\User\Actions;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;
use Helper;

class CreateUserAction
{
	public static function execute(UserDTO $userDTO){
		$userDTO->role_id = $userDTO->role_id ?? 2;
		$userDTO->setDefaultValues();
		$data = Helper::filterArray($userDTO->toArray());
		$user = User::create($data);
		return $user;
	}
}