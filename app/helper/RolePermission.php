<?php
namespace App\helper;

use Spatie\Permission\Models\Role;


class RolePermission
{
    public static function givePermissionTo($role, $permission)
    {
        try{
            foreach ($permission as $p){
                \App\Models\RolePermission::create([
                    'role_id'=>$role->id,
                    'permission_id'=>$p->id
                ]);
            }
        }
        catch (\Exception $exception){
            echo $exception->getMessage();
        }

    }
}

//$r= new RolePermission();
//$r->givePermissionTo('admin');
