<?php

namespace App\Http\ViewModels\General\Role;

use App\Domain\General\Role\Model\Role;
use Illuminate\Contracts\Support\Arrayable;

class ShowRolesIndexVM implements Arrayable
{
	private $roles;

	public function __construct($paginate = true){
		$query = Role::orderBy('id','ASC');
		$this->roles = $paginate ? $query->paginate(10) : $query->get();
	}

	public function toArray()
    {
        return [
          'roles' =>  $this->roles
        ];
    }
}