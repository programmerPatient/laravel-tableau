<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = ['role_name'];

    public $timestamps = false;

    //将分派的权限进行处理
    public function assignAuth($data){
        //处理数据
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
        //修改数据
        return self::where('id',$data['id'])->update($post);
    }
}
