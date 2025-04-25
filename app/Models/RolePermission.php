<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    public function roles(){
        return $this->belongsTo(Role::class, 'id', 'role_id');
    }
}
