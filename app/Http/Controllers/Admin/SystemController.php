<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use DB;
use Session;
use App\Models\Admin\System;

class SystemController extends Controller
{
    public function update(){
        if(Input::method() == 'POST'){
            //系统设置的修改
            $post = Input::only(['web_name','describe','copyright_information','filing_no']);
            $tableau_domain = Input::only("tableau_domain")["tableau_domain"];
            $file = $request->file('logo_img');
            $allowed_extensions = ["png", "jpg", "gif","PNG",'jpeg'];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'You may only upload png, jpg , PNG , jpeg or gif.'];
            }
            $destinationPath = 'images/'; //public 文件夹下面建 imges 文件夹
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(10).'.'.$extension;
            $file->move($destinationPath, $fileName);
            $filePath = asset($destinationPath.$fileName);
            $post['logo_url'] = $filePath;
            $post['system_domain'] = $tableau_domain;
            $post['type'] = '1';
            $default = Systemset::where('type','1')->get()->first();
            $default -> type = '0';
            $default->save();
            $result = Systemset::insert($post);
            return $result ? '1':'0';
            // //修改config配置
            // $data =  System::get()->first();
            // $data->system_domain = $tableau_domain;
            // $data -> save();
            // return 1;
        }else{
            $tableau_domain = Session::get('tableau_domain');
                        // dd($tableau_domain);
            return view('admin.system.index',compact('tableau_domain'));
        }
    }
}
