<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Helper;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\ChangePasswordRequest;

use App\Models\User;

class UsersAuthController extends Controller
{
    private $path = 'users/avatar/';
    
    public function login(){
        return view('frontend.auth.login');
    }

    public function register(){
        return view('frontend.auth.register');
    }

    public function loginSubmit(LoginUserRequest $loginUserRequest){
        $data = $loginUserRequest->validated();

        if($this->checkUserCredentials($data)){
            request()->session()->flash('success', 'Successfully login');
            return redirect()->route('product.index');
        }

        request()->session()->flash('error', 'Invalid Credentials pleas try again!');
        return redirect()->back();    
    }

    public function registerSubmit(RegisterUserRequest $registerUserRequest){
        $data = $registerUserRequest->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = 2; // user role

        if(isset($data['avatar']) && $data['avatar'] instanceof UploadedFile){
            $data['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::create($data);

        if($user){
            Auth::loginUsingId($user->id);
            request()->session()->flash('success','Successfully registered');
            return redirect()->route('product.index');
        }
        else{
            request()->session()->flash('error','Please try again!');
            return back();
        }
    }

    public function logout(){
        Auth::logout();
        session()->flush();
        request()->session()->flash('success','Logout successfully');
        return redirect()->route('login.form');
    }

    public function showResetForm(){
        return view('frontend.auth.passwords.old-reset');
    }

    public function changePassword(){
        return view('frontend.auth.passwords.change-password');
    }

    public function changPasswordStore(ChangePasswordRequest $changePasswordRequest)
    {
        $userId = Auth::id();
        $data = $changePasswordRequest->validated();

        $data['password'] = Hash::make($data['new_password']);

        $user = User::find($userId);
        $result = $user->update($data);
        
        return redirect()->route('users.profile')->with('success','Password successfully changed');
    }

    private function checkUserCredentials($data){
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]) || Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])){
            return true;
        }
        return false;
    }
}
