<?php

namespace App\Service;

use App\Repository\Role\RoleRepository;
use Illuminate\Support\Facades\Auth;


/**
 * class Role Service
 */
class RoleService
{
    /**
     * @var RoleRepository
     */
    protected $RoleRepository;


    /**
     * UserService constructor.
     *
     * @param RoleRepository $RoleRepository
     */
    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;

    }


    /**
     * Retrieving list of roles
     *
     * @return \Illuminate\Database\Eloquent\Collection|void
     */
    public function index()
    {
        if (Auth::user()->can('manage_role')) {
            return $this->RoleRepository->all();
        }
    }

    /**
     * Storing newly created role
     * @return \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[]|void
     */
    public function create()
    {
        if (Auth::user()->can('manage_role')) {
            return $this->RoleRepository->getPermission();
        }
    }


    /**
     * Stores newly created roles
     *
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Model|void
     */
    public function store($data)
    {
        if (Auth::user()->can('manage_role')) {
            return $this->RoleRepository->store($data);
        }

    }

    /**Edits the user details
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function edit($id)
    {
        $role = $this->RoleRepository->find($id);
        return $role;
    }


    /**
     * Updates user details
     *
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data): bool
    {
        return $this->RoleRepository->update($data, $id);
    }


    /**
     * Deletes role
     *
     * @param $id
     * @return int
     */
    public function destroy($id): int
    {
        return $this->RoleRepository->delete($id);
    }


}
