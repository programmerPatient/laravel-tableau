<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $fillable =['username','password','gender','email','mobile','tableau_id','type','created_at','status','avatar'];
}
