<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\ShowOneUserRequest;

use Helper;
use App\Models\User;

class UsersAPIController extends Controller
{
    private $path = 'users/avatar/';
    
    public function userProfile()
    {
        $userId = Auth::id();

        $user = User::find($userId);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);
    }

    public function show(ShowOneUserRequest $showOneUserRequest)
    {
        $userId = $showOneUserRequest->id;

        $user = User::find($userId);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);
    }

    public function create(CreateUserRequest $createUserRequest)
    {
        $data = $createUserRequest->validated();
        $data['password'] = Hash::make($data['password']);

        if(isset($data['avatar']) && $data['avatar'] instanceof UploadedFile){
            $data['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::create($data);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);
    }

    public function update(UpdateUserRequest $updateUserRequest)
    {
        $data = $updateUserRequest->validated();

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        if(isset($data['avatar']) && $data['avatar'] instanceof UploadedFile){
            $data['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::find($data['id']);
        $result = $user->update($data);

        $response = Helper::createSuccessResponse($user);
        return response()->json($response);

    }

    public function destroy(DeleteUserRequest $deleteUserRequest)
    {
        $user = User::find($deleteUserRequest->id);
        $user->delete();

        $response = Helper::createSuccessResponse('User Successfully deleted');
        return response()->json($response);
    }
}