<?php

namespace App\Http\ViewModels\General\User;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class ShowOneUserVM implements Arrayable
{
	private $user;

	public function __construct($userId){
		$this->user = User::find($userId);
	}

	public function toArray()
    {
        return [
          'user' =>  $this->user
        ];
    }

    public function toItem()
    {
        return $this->user;
    }
}