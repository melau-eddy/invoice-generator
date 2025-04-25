<?php

namespace App\Repository\Profile;

use App\Models\Gender;
use App\Models\Profile;
use App\Models\Status;
use App\Repository\Repository;


/**
 * Class Audit Repository
 */
class ProfileRepository extends Repository
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
        return Gender::class;
    }

    public function getStatus()
    {
        return Status::all();
    }

    public function findWithRelation($id){
        return Profile::with('user', 'gender', 'status')->find($id);
    }



}
