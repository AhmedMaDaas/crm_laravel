<?php

namespace App\Domain\General\User\Actions;

use Illuminate\Support\Facades\Hash;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class CheckUserCredentials
{
	public static function execute(UserDTO $userDTO){
		$data = [];
		$status = false;
		$message = 'Incorrect Information';

		$user = User::when($userDTO->email != null, function($query) use ($userDTO){
					return $query->where('email', $userDTO->email);
				})
				->when($userDTO->phone != null, function($query)  use ($userDTO){
					return $query->where('phone', $userDTO->phone);
				})
				->first();

		if($user){
			if(Hash::check($userDTO->password, $user->password)){
				$data = $user;
				$status = true;
				$message = 'Correct Information';
			}
			else $message = 'Wrong Password';
		}

		return ['data' => $data, 'status' => $status, 'message' => $message];
	}
}