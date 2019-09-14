<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入input
use Input;
use DB;
//引入auth
use App\Models\Admin\Auth;

class AuthController extends Controller
{
    //权限列表
    public function index(){
        //查询数据
        $data = DB::table('auth as t1')->select('t1.*','t2.auth_name as parent_name')->leftJoin('auth as t2','t1.pid','=','t2.id')->get();
        return view('admin.auth.index',compact('data'));
    }

    //
    public function add(){
        //判断请求类型
        if(Input::method() == 'POST'){
            //接收并处理数据
            $data = Input::except('_token');
            $result = Auth::insert($data);
            //由于框架自身不支持bool值，所以转化一种形式
            return $result ? '1':'0';
        }else{
            //查询父级权限
            $parents = Auth::where('pid' ,'=' ,'0')->get();
            return view('admin.auth.add',compact('parents'));
        }
    }
}
