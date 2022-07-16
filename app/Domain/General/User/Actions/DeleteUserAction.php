<?php

namespace App\Domain\General\User\Actions;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class DeleteUserAction
{
	public static function execute(UserDTO $userDTO){
		$user = User::find($userDTO->id);
		$user->delete();
		return "Deleted Successfully!";
	}
}