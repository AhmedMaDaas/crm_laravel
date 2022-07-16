<?php

namespace  App\Domain\General\Role\Actions;

use  App\Domain\General\Role\DTO\RoleDTO;
use  App\Domain\General\Role\Model\Role;

class DeleteRoleAction
{
	public static function execute(RoleDTO $roleDTO){
		$role = Role::find($roleDTO->id);
		$role->delete();
		return "Deleted Successfully!";
	}
}