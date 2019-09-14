<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\Admin\Auth;
use Input;


class RoleController extends Controller
{
    //展示列表
    public function index(){
        //查询
        $data = Role::get();
        //展示视图
        return view('admin.role.index',compact('data'));
    }

    //添加角色
    public function add(){
        if(Input::method() == 'POST'){
            $data = Input::only(['roleName','auth_id']);
            $post['role_name'] = $data['roleName'];
            //获取auth_ids字段的值
            $post['auth_ids'] = implode(',',$data['auth_id']);
            //获取auth_ac
            $tmp = \App\Models\Admin\Auth::where('pid','!=','0') -> whereIn('id',$data['auth_id']) ->get();
            //循环拼凑controller和action
            $ac = '';
            foreach($tmp as $key=>$value){
                $ac = $ac . $value -> controller . '@' . $value -> action . ',';
            }
            //除去末尾的逗号
            $post['auth_ac'] = rtrim($ac,',');
            $result = Role::insert($post);
            return $result ? '1':'0';
        }else{
            $data = Auth::all();
            return view('admin.role.add',compact('data'));
        }
    }

    //
    public function assign(){
        //判断请求类型
        if(Input::method() == 'POST'){
            $data = Input::only(['id','auth_id']);
            //交给模型处理数据
            $role = new Role();
            $result = $role -> assignAuth($data);
            //输出返回的结果
            return $result;
        }else{
            //查询一级权限
            $top = Auth::where('pid','0') ->get();
            //查询二级权限
            $cat = Auth::where('pid','!=','0')->get();
            $ids = Role::where('id',Input::get('id'))->value('auth_ids');
            return view('admin.role.assign',compact('top','cat','ids'));
        }
    }
}
