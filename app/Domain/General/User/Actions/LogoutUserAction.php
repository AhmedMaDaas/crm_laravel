<?php

namespace App\Domain\General\User\Actions;

use App\Http\ViewModels\General\User\ShowOneUserVM;
use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;
use Helper;

class LogoutUserAction
{
	public static function execute(User $user){
		$user->currentAccessToken()->delete();
        return 'User has been successfully Logged Out';
	}
}