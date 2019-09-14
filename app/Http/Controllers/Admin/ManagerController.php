<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Manager;

class ManagerController extends Controller
{
    //管理员列表操作
    public function index(){
        //查询数据
        $data = Manager::get();
        return view('admin.manager.index',compact('data'));
    }
}
