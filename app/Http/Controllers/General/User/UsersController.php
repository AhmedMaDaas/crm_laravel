<?php

namespace App\Http\Controllers\General\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Domain\General\User\Actions\UpdateUserAction;
use App\Domain\General\User\Actions\CreateUserAction;
use App\Domain\General\User\Actions\DeleteUserAction;

use App\Http\Requests\General\User\UpdateUserRequest;
use App\Http\Requests\General\User\CreateUserRequest;
use App\Http\Requests\General\User\DeleteUserRequest;
use App\Http\Requests\General\User\ShowOneUserRequest;

use App\Http\ViewModels\General\User\ShowOneUserVM;
use App\Http\ViewModels\General\User\ShowUsersIndexVM;
use App\Http\ViewModels\General\Role\ShowRolesIndexVM;

use App\Domain\General\User\DTO\UserDTO;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = new ShowUsersIndexVM();
        $data = $users->toArray();
        return view('frontend.users.index', $data);
    }

    public function userProfile()
    {
        $id = Auth::id();
        $user = new ShowOneUserVM($id);
        $roles = new ShowRolesIndexVM(false);
        $data = array_merge(['profile' => $user->toItem()], $roles->toArray());
        return view('frontend.users.profile', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = new ShowRolesIndexVM(false);
        $data = $roles->toArray();
        return view('frontend.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        $userDTO = UserDTO::fromRequest($createUserRequest->all());
        $user = CreateUserAction::execute($userDTO);

        if($user){
            request()->session()->flash('success','Successfully added user');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowOneUserRequest $showOneUserRequest)
    {
        $id = $showOneUserRequest->id;
        $user = new ShowOneUserVM($id);
        $roles = new ShowRolesIndexVM(false);
        $data = array_merge(['profile' => $user->toItem()], $roles->toArray());
        return view('frontend.users.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShowOneUserRequest $showOneUserRequest)
    {
        $id = $showOneUserRequest->id;
        $user = new ShowOneUserVM($id);
        $roles = new ShowRolesIndexVM(false);
        $data = array_merge($user->toArray(), $roles->toArray());
        return view('frontend.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $updateUserRequest)
    {
        $userDTO = UserDTO::fromRequest($updateUserRequest->all());
        $user = UpdateUserAction::execute($userDTO);

        if($user){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $deleteUserRequest)
    {
        $userDTO = UserDTO::fromRequest($deleteUserRequest->all());
        $message = DeleteUserAction::execute($userDTO);

        if($message){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
