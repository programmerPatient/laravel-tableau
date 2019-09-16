<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class Member extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    protected $table = 'member';

    protected $fillable =['username','password','gender','email','mobile','tableau_id','created_at','status'];
}
