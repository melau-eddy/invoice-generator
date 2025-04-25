<?php
namespace App\Service;

class FileService{
    /**
     * Reusable method for file storage
     *
     * @param $company
     * @param $request
     * @param $filename
     */
    public function storeFile($obj, $request, $filename, $stored_path, $column_name)
    {
        $obj_image = $request->file($filename);
        $obj_pic = $obj_image->store($stored_path, 'uploads');
        $obj->$column_name = $obj_pic;
        $obj->save();
    }
}
