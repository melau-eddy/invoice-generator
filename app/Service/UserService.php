<?php

namespace App\Service;

use App\Repository\User\UserRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class UserService
{

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepo $userRepository
     */
    public function __construct(UserRepo $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     *  Displays the list of users
     *
     * @return array
     */

    /**
     * Stores the user details
     *
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($data)
    {
        $user = $this->userRepository->store($data);
        return $user;
    }

    /**Edits the user details
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return $user;
    }

    /**Updates user details
     *
     * @param $id
     *
     * @param $data
     *
     * @return bool
     */
    public function update($id, $data)
    {
        $roles = $data['roles'];
        $user = $this->userRepository->update($id, $data);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        foreach ($roles as $role) {
            DB::table('model_has_roles')->insert([
                'role_id' => $role,
                'model_type' => 'App\Models\User',
                'model_id' => $id
            ]);

        }
        return $user;

    }

    /**Deletes user details
     *
     * @param $id
     *
     * @return int
     */
    public function destroy($id)
    {
        return $this->userRepository->delete($id);

    }

    public function getUsers($params)
    {
        $where = [];
        $orWhere = [];
        if (isset($params['search'])) {
            $search = $params['search'];
            $where = [['name', 'like', "%{$search}%"]];
            $orWhere = [['email', 'like', "%{$search}%"]];
        }
        $select = ['*'];
        $orderBy = '';
        $order = 1 ? isset($params['order']) and isset($params['sort']) : 0;
        if ($order) {
            $orderBy = [$params['order'], $params['sort']];
        }
        $skip = '';
        $take = '10';

        if (isset($params['page'])) {
            $skip = ($params['page'] - 1) * $take;
        }

        return $this->userRepository->getUsers($select, $where, $orWhere, $orderBy, $skip, $take);
    }

    /**
     * Edits profile page
     *
     * @param $id
     * @return array
     */
    public function editProfile($id){
        $gender = $this->userRepository->getGender();
        $status = $this->userRepository->getStatus();
        $profile = $this->userRepository->findWithRelation($id);
        $arr=[];
        array_push($arr, $gender, $status, $profile);
        return $arr;
    }

    /**
     * Updates profile page
     *
     * @param $data
     * @param $id
     */
    public function updateProfile($data, $id){
        $gender = $this->userRepository->all();
        $status = $this->userRepository->getStatus();
        $profile = $this->userRepository->findWithRelation($id);
        if ($data->hasFile('file_image')) {
            Storage::disk('uploads')->delete($profile->profile_pic);
            $profile_image = $data->file('file_image');
            $profile_pic = $profile_image->store('pp_image', 'uploads');
            $profile->filename = $profile_pic;
        } else {
            $profile->filename = $profile->filename;
        }
        $profile->phone_number = $data->number;
        $profile->gender_id = $data->gender;
        $profile->status_id = $data->status;
        $profile->save();
        $arr=[];
        array_push($arr, $gender, $status, $profile);
        return $arr;
    }
}
