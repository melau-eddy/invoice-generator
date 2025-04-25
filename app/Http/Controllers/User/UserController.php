<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Company;
use App\Models\Profile;
use App\Models\User;
use App\Repository\User\UserRepo;
use App\Service\FileService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected UserService $userService, protected UserRepo $userRepository, protected FileService $fileService)
    {
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Request $req)
    {
        try {
            $total = intval(ceil(count(User::all()) / 10));
            $result = $this->userService->getUsers($req->all());
            return view('User.UserRetrieve')->with('result', $result)->with('total', $total)->with('status', 'Search Results');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = Role::all();
            $companies = Company::all();
            return view('User.UserForm', compact('roles', 'companies'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }

    /**
     * Store a newly created role in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $req)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->store([
                "name" => $req->name,
                "email" => $req->email,
                "password" => bcrypt($req->password),
                "company_id" => $req->company
            ]);
            $roles = $req->roles;

            foreach ($roles as $role) {
                $user->assignRole($role);
            }
            DB::commit();
            return redirect()->route('Users')->with('status', 'New User Created');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try {
            DB::beginTransaction();
            $user_id = $this->userService->edit($id);
            $model_roles = DB::table('model_has_roles')->where('model_id', $id)->get();
            $selected_roles = [];
            $roles = Role::all();
            foreach ($model_roles as $role) {
                $selected_roles[] = $role->role_id;
            }
            return view('User.UserForm', compact('user_id', 'selected_roles', 'roles'));
            DB::commit();
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }

    }

    /**
     * Update the specified user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $req, $id)
    {

        try {
            DB::beginTransaction();
            $this->userService->update($id, $req->all());
            DB::commit();
            return redirect()->route('Users')->with('status', 'User Details Updated');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->userService->destroy($id);
            DB::commit();
            return redirect()->route('Users');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }

    public function editProfile($id)
    {
        try {
            $all = $this->userService->editProfile($id);
            $gender = $all[0];
            $status = $all[1];
            $profile = $all[2];
            return view('Profile.ProfileForm', compact('profile', 'gender', 'status'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }

    public function updateProfile(ProfileRequest $request, $id)
    {
        try {
            $gender = $this->userRepository->all();
            $status = $this->userRepository->getStatus();
            $profile = $this->userRepository->findWithRelation($id);
            if ($request->hasFile('file_image')) {
                Storage::disk('uploads')->delete($profile->profile_pic);
                $this->fileService->storeFile($profile, $request, 'file_image', 'pp_image', 'profile_pic');
            } else {
                $profile->profile_pic = $profile->profile_pic;
            }
            $profile->phone_number = $request->number;
            $profile->gender_id = $request->gender;
            $profile->status_id = $request->status;
            $profile->save();
            return redirect()->route('editProfile', $id)->with('gender', $gender)->with('status', $status)->with('profile', $profile)->with('status', 'Updated Successfully');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }
}
