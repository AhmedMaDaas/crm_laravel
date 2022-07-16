<?php

namespace App\Http\Controllers\General\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Helper;

use App\Domain\General\User\Actions\UpdateUserAction;
use App\Domain\General\User\Actions\CreateUserAction;
use App\Domain\General\User\Actions\DeleteUserAction;

use App\Http\Requests\General\User\ShowOneUserRequest;
use App\Http\Requests\General\User\CreateUserRequest;
use App\Http\Requests\General\User\UpdateUserRequest;
use App\Http\Requests\General\User\DeleteUserRequest;

use App\Http\ViewModels\General\User\ShowOneUserVM;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class UsersAPIController extends Controller
{
    public function userProfile()
    {
        $userId = Auth::id();

        $userVM = new ShowOneUserVM($userId);
        $data = $userVM->toItem();

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function show(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;

        $userVM = new ShowOneUserVM($userId);
        $data = $userVM->toItem();

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function create(CreateUserRequest $createUserRequest)
    {
        $userDTO = UserDTO::fromRequest($createUserRequest->all());
        $user = CreateUserAction::execute($userDTO);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);
    }

    public function update(UpdateUserRequest $updateUserRequest)
    {
        $userDTO = UserDTO::fromRequest($updateUserRequest->all());
        $user = UpdateUserAction::execute($userDTO);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);

    }

    public function destroy(DeleteUserRequest $deleteUserRequest)
    {
        $userDTO = UserDTO::fromRequest($deleteUserRequest->all());
        $message = DeleteUserAction::execute($userDTO);

        $response = Helper::createSuccessResponse($message);
        return response()->json($response);
    }
}