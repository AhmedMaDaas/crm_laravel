<?php

namespace  App\Domain\General\Role\Actions;

use  App\Domain\General\Role\DTO\RoleDTO;
use  App\Domain\General\Role\Model\Role;
use Helper;

class UpdateRoleAction
{
	public static function execute(RoleDTO $roleDTO){
		$role = Role::find($roleDTO->id);
		$data = Helper::filterArray($roleDTO->toArray());
		$role->update($data);
		return $role;
	}
}