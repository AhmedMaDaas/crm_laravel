<?php

namespace App\Http\ViewModels\General\User;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class ShowUsersIndexVM implements Arrayable
{
	private $users;

	public function __construct($paginate = true){
		$query = User::orderBy('id','ASC');
		$this->users = $paginate ? $query->paginate(10) : $query->get();
	}

	public function toArray()
    {
        return [
          'users' =>  $this->users
        ];
    }
}