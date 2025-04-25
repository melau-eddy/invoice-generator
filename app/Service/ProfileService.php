<?php

namespace App\Service;

use App\Models\Profile;
use App\Repository\Profile\ProfileRepository;
use Illuminate\Support\Facades\Storage;


/**
 * class Audit Service
 */
class ProfileService
{
    /**
     * @var profileRepository
     */
    protected $profileRepository;

    /**
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository){
        $this->profileRepository=$profileRepository;
    }

    /**
     * Edits profile page
     *
     * @param $id
     * @return array
     */
    public function edit($id){
        $gender = $this->profileRepository->all();
        $status = $this->profileRepository->getStatus();
        $profile = $this->profileRepository->findWithRelation($id);
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
    public function update($data, $id){
        $gender = $this->profileRepository->all();
        $status = $this->profileRepository->getStatus();
        $profile = $this->profileRepository->findWithRelation($id);
        if ($data->hasFile('file_image')) {
            Storage::disk('uploads')->delete($profile->filename);
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
