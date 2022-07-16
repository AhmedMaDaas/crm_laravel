<?php

namespace  App\Domain\General\Role\Actions;

use  App\Domain\General\Role\DTO\RoleDTO;
use  App\Domain\General\Role\Model\Role;

class CreateRoleAction
{
	public static function execute(RoleDTO $roleDTO){
		$role = Role::create($roleDTO->toArray());
		return $role;
	}
}