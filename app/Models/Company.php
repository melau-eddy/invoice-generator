<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=['name', 'email', 'location', 'company_image', 'number'];

    public function user(){
        return $this->belongsTo(User::class, 'company_id', 'id');
    }
}
