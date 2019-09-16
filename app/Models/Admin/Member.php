<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class Member extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    protected $table = 'member';
        //使用trait，就相当于将trait代码段复制到这个位置
    use Authenticatable;

    protected $fillable =['username','password','gender','email','mobile','tableau_id','created_at','status'];
}
