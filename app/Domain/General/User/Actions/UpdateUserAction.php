<?php

namespace App\Domain\General\User\Actions;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;
use Helper;

class UpdateUserAction
{
	public static function execute(UserDTO $userDTO){
		$userDTO->setDefaultValues();
		$user = User::find($userDTO->id);
		$data = Helper::filterArray($userDTO->toArray());
		$user->update($data);
		return $user;
	}
}