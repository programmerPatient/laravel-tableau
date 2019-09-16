<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    //
    protected $table = 'system';

    protected $fillable = ['system_domain','logo_url','web_title'];

    public $timestamps = false;
}
