<?php

namespace App\Repository\User;

use App\Models\Gender;
use App\Models\Profile;
use App\Models\Status;
use App\Models\User;
use App\Repository\Repository;

/**
 * Class User Repository
 */
class UserRepo extends Repository
{

    /**
     * Retrieves the model name
     *
     * abstract method
     *
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }


    /**
     *
     * Retrieves the user details on the basis of different filters
     *
     * @param string $select_attr
     * @param array $where_attr
     * @param array $orWhere_attr
     * @param string $orderBy
     * @param string $skip
     * @param string $take
     *
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUsers($select_attr = '*', $where_attr = [], $orWhere_attr = [], $orderBy = '', $skip = '', $take = '')
    {
        $data = $this->model;
        $data = $data->select($select_attr);

        if ($where_attr) {
            $data = $data->where(...(array_shift($where_attr)));
        }

        if ($orWhere_attr) {
            $data = $data->orWhere(...(array_shift($orWhere_attr)));
        }

        if ($orderBy) {
            $data = $data->orderBy(...$orderBy);
        }

        if ($skip) {
            $data = $data->skip($skip);
        }

        if ($take) {
            $data = $data->take($take);
        }
        return $data->get();
    }

    public function getGender()
    {
        return Gender::all();
    }

    public function getStatus()
    {
        return Status::all();
    }

    public function findWithRelation($id){
        return User::with('gender', 'status')->find($id);
    }
}
