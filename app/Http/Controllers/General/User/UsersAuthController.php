<?php

namespace App\Http\Controllers\General\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Helper;

use App\Domain\General\User\Actions\UpdateUserAction;
use App\Domain\General\User\Actions\CreateUserAction;
use App\Domain\General\User\Actions\DeleteUserAction;
use App\Domain\General\User\Actions\LoginUserAction;
use App\Domain\General\User\Actions\CheckUserCredentials;

use App\Http\Requests\General\User\LoginUserRequest;
use App\Http\Requests\General\User\RegisterUserRequest;
use App\Http\Requests\General\User\ChangePasswordRequest;

use App\Http\ViewModels\General\User\ShowOneUserVM;
use App\Http\ViewModels\General\User\ShowUsersIndexVM;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class UsersAuthController extends Controller
{
    public function login(){
        return view('frontend.auth.login');
    }

    public function register(){
        return view('frontend.auth.register');
    }

    public function loginSubmit(LoginUserRequest $loginUserRequest){
        $userDTO = UserDTO::fromRequest($loginUserRequest->all(), $encryptPass = false);
        $result = CheckUserCredentials::execute($userDTO);

        if($result['status'] == false){
            request()->session()->flash('error', 'Invalid Credentials pleas try again!');
            return redirect()->back();
        }

        Auth::loginUsingId($result['data']->id);
        request()->session()->flash('success', 'Successfully login');
        return redirect()->route('product.index');
    }

    public function registerSubmit(RegisterUserRequest $registerUserRequest){
        $userDTO = UserDTO::fromRequest($registerUserRequest->all());
        $user = CreateUserAction::execute($userDTO);

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
        $userDTO = UserDTO::fromRequest(['id' => $userId, 'password' => $changePasswordRequest->new_password]);
        $user = UpdateUserAction::execute($userDTO);
        
        return redirect()->route('users.profile')->with('success','Password successfully changed');
    }

}
