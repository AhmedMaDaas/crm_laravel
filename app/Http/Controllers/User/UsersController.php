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
use App\Models\Role;

class UsersController extends Controller
{
    private $path = 'users/avatar/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','ASC')->paginate(10);
        $data = ['users' => $users];
        return view('frontend.users.index', $data);
    }

    public function userProfile()
    {
        $id = Auth::id();
        $user = User::find($id);
        $roles = Role::orderBy('id','ASC')->get();
        $data = [
            'roles' => $roles,
            'profile' => $user,
        ];
        return view('frontend.users.profile', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id','ASC')->get();
        $data = ['roles' => $roles];
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
        $data = $createUserRequest->validated();
        $data['password'] = Hash::make($data['password']);

        if(isset($data['avatar']) && $data['avatar'] instanceof UploadedFile){
            $data['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::create($data);

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
        $user = User::find($id);
        $roles = Role::orderBy('id','ASC')->get();
        $data = [
            'roles' => $roles,
            'profile' => $user,
        ];
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
        $user = User::find($id);
        $roles = Role::orderBy('id','ASC')->get();
        $data = [
            'roles' => $roles,
            'user' => $user,
        ];
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
        $data = $updateUserRequest->validated();

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        if(isset($data['avatar']) && $data['avatar'] instanceof UploadedFile){
            $data['avatar'] = $this->path . Helper::saveFileGetLinkWithName($data['avatar'], $this->path)['fileName'];
        }

        $user = User::find($data['id']);
        $result = $user->update($data);

        if($result){
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
        $user = User::find($deleteUserRequest->id);
        $user->delete();

        request()->session()->flash('success','User Successfully deleted');
        return redirect()->route('users.index');
    }
}
