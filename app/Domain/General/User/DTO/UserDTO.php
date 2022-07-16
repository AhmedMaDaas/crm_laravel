<?php

namespace App\Domain\General\User\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Helper;

class UserDTO extends DataTransferObject
{

    /* @var integer */
    public $id;
    /* @var string */
    public $first_name;
    /* @var string */
    public $last_name;
    /* @var string|null */
    public $email;
    /* @var string */
    public $password;
    /* @var string|null */
    public $phone;
    /* @var string */
    public $role_id;
    /* @var string|null */
    public $avatar;

    public static function fromRequest($request, $encryptPass = true){
        $password = isset($request['password']) && $encryptPass === true ? Hash::make($request['password']) : (isset($request['password']) && $encryptPass === false ? $request['password'] : null);
        
        return new self([
            'id' => $request['id'] ?? null,
            'first_name' => $request['first_name'] ?? null,
            'last_name' => $request['last_name'] ?? null,
            'email' => $request['email'] ?? null,
            'password' => $password,
            'phone' => $request['phone'] ?? null,
            'role_id' => $request['role_id'] ?? null,
            'avatar' => $request['avatar'] ?? null,
        ]);
    }

    public function setDefaultValues(){
        $this->id = $this->id ?? null;
        $this->first_name = $this->first_name ?? null;
        $this->last_name = $this->last_name ?? null;
        $this->email = $this->email ?? null;
        $this->phone = $this->phone ?? null;
        $this->role_id = $this->role_id ?? null;
        $this->avatar = $this->getAvatar();
    }

    private function getAvatar(){
        $path = 'users/avatar/';
        if($this->avatar == null) return null;
        if($this->avatar instanceof UploadedFile)
            return $path . Helper::saveFileGetLinkWithName($this->avatar, $path)['fileName'];
        return $this->avatar;
    }
}
