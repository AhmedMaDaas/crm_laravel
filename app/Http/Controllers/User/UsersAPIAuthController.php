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

class UsersAPIAuthController extends Controller
{
    private $path = 'users/avatar/';

    public function login(LoginUserRequest $loginUserRequest)
    {
        $request = $loginUserRequest->validated();
        $message = 'Incorrect Information';
        $status = false;

        $user = User::when(isset($request['email']), function($query) use ($request){
                    return $query->where('email', $request['email']);
                })
                ->when(isset($request['phone']), function($query)  use ($request){
                    return $query->where('phone', $request['phone']);
                })
                ->first();

        if($user){
            if(Hash::check($request['password'], $user->password)){
                $data = $user;
                $status = true;
                $message = 'Correct Information';
            }
            else $message = 'Wrong Password';
        }

        if($status === false){
            $response = Helper::createErrorResponse($message, null, 400);
            return response()->json($response);
        }

        $user['token'] = $this->generateToken($user);
        $data = $user;

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function register(RegisterUserRequest $registerUserRequest)
    {
        $requestData = $registerUserRequest->validated();
        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['role_id'] = 2; // user role

        if(isset($requestData['avatar']) && $requestData['avatar'] instanceof UploadedFile){
            $requestData['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::create($requestData);

        $user['token'] = $this->generateToken($user);
        $data = $user;

        $response = Helper::createSuccessResponse($data);
        return response()->json($response);
    }

    public function changPassword(ChangePasswordRequest $changePasswordRequest){
        $userId = Auth::id();
        $data = $changePasswordRequest->validated();

        $data['password'] = Hash::make($data['new_password']);

        $user = User::find($userId);
        $result = $user->update($data);

        $response = Helper::createSuccessResponse($result);
        return response()->json($response);
    }

    public function logout(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        $response = Helper::createSuccessResponse('User has been successfully Logged Out');
        return response()->json($response);
    }

    private function generateToken($user){
        $token = $user->createToken('authToken')->plainTextToken;
        return $token;
    }
}