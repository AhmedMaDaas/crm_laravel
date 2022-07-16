<?php

namespace App\Http\Controllers\General\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Helper;

use App\Domain\General\User\Actions\UpdateUserAction;
use App\Domain\General\User\Actions\CreateUserAction;
use App\Domain\General\User\Actions\DeleteUserAction;
use App\Domain\General\User\Actions\LoginUserAction;
use App\Domain\General\User\Actions\CheckUserCredentials;
use App\Domain\General\User\Actions\AddUserRelationsAction;
use App\Domain\General\User\Actions\LogoutUserAction;

use App\Http\Requests\General\User\LoginUserRequest;
use App\Http\Requests\General\User\RegisterUserRequest;
use App\Http\Requests\General\User\ChangePasswordRequest;

use App\Http\ViewModels\General\User\ShowOneUserVM;
use App\Http\ViewModels\General\User\ShowUsersIndexVM;
use App\Http\ViewModels\General\User\ShowUserByNumberVM;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class UsersAPIAuthController extends Controller
{
    public function login(LoginUserRequest $loginUserRequest)
    {
        $userDTO = UserDTO::fromRequest($loginUserRequest->all(), $encryptPass = false);
        $result = CheckUserCredentials::execute($userDTO);

        if($result['status'] == false){
            $response = Helper::createErrorResponse($result['message'], null, 422);
            return response()->json($response);
        }

        $relations = AddUserRelationsAction::execute($loginUserRequest, $result['data']->id);

        $data = LoginUserAction::execute($result['data']);

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function register(RegisterUserRequest $registerUserRequest)
    {
        $userDTO = UserDTO::fromRequest($registerUserRequest->all());
        $user = CreateUserAction::execute($userDTO);

        $relations = AddUserRelationsAction::execute($registerUserRequest, $user->id);

        $data = LoginUserAction::execute($user);

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function changPassword(ChangePasswordRequest $changePasswordRequest){
        $userId = Auth::id();
        $userDTO = UserDTO::fromRequest(['id' => $userId, 'password' => $changePasswordRequest->new_password]);
        $user = UpdateUserAction::execute($userDTO);
        $response = Helper::createSuccessResponse($user);
        return response()->json($response);
    }

    public function logout(){
        $user = Auth::user();
        $message = LogoutUserAction::execute($user);
        $response = Helper::createSuccessResponse($message);
        return response()->json($response);
    }
}