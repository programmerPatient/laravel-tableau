<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\System;

//引入Auth门面
use Auth;
use Session;
use Cookie;

class PublicController extends Controller
{
    //登陆界面的展示
    public function login(){

        // 该页面使用H_ui.admin模板自动生成，需要到该网站下下载对应的代码，然后在public目录下引入他的静态资源，然后在视图文件中引入你需要的界面的代码，当前页面引入login.html的代码,并修改页面的资源引入路径为自己刚才引入资源后的资源路径
        $tableau_domain = System::get()->first()->system_domain;
        Session::put(['tableau_domain' => $tableau_domain]);
        return view('admin.public.login');
    }


    // //tableau授权票证的获取
    // public function tableau($url,$methods,$data = null,$header){
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => $url,
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => $methods,
    //     CURLOPT_POSTFIELDS => $data,
    //     CURLOPT_HTTPHEADER => $header
    //     ));
    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
    //     curl_close($curl);
    //     if ($err) {
    //       echo "cURL Error #:" . $err;
    //     } else {
    //         $data = json_decode($response);
    //         return $data;
    //     }
    // }


    //后台登录验证
    public function check(Request $request){
        //开始自动验证
        $this -> validate($request,[
            //验证语法  需要验证的字段名 => "验证规则1|验证规则2...."
            'username' => 'required|min:2|max:20',
            'password' => 'required|min:6',
            // 'captcha' => 'required|size:4|captcha'
        ]);
        $data = $request -> only(['username','password']);
        //继续开始进行身份核实
        $data['status'] = '2';//要求状态为启用的用户登录
        $admin = DB::table('manager') -> get() ->first();
        $type = '1';
        $result = Auth::guard('admin') -> attempt($data,$request -> get('online'));
        if(!$result){
            $result = Auth::guard('member') -> attempt($data,$request -> get('online'));
            $type = '2';
        }
        //判断是否成功
        if($result){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => Session::get('tableau_domain')."/api/3.2/auth/signin",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"credentials\":{\"name\":\"" . $admin['username'] . "\",\"password\":\"admin\",\"site\":{\"contentUrl\":\"\"}}}",
            CURLOPT_HTTPHEADER => array(
                "User-Agent: TabCommunicate",
                "Content-Type: application/json",
                "Accept: application/json",
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
                $res = json_decode($response);
                Session::put('token',$res->credentials->token);
                /*获取用户列表*/

                curl_setopt_array($curl, array(
                CURLOPT_URL => "http://tableau.kalaw.top/api/3.2/sites/fc697b45-5d47-43c0-9e39-5a90812e6273/users",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "X-Tableau-Auth: ".Session::get('token'),
                    "Accept: application/json",
                  ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                  $user = json_decode($response)->users->user;
                  $boole = true;
                  foreach($user as $val){
                    if($data['username'] == $val->name){
                        $boole = false;
                    }
                  }
                  if($boole){
                    return view('admin.error.index');
                  }
                }
            }
            //跳转到后台首页
            return redirect('admin/index/index',compact('type'));
        }else{
            //withErrors表示带上错误信息
            return redirect('/admin/public/login') -> withErrors([
                'loginError' => '用户名或密码错误。'
            ]);
        }
    }


    //用户退出
    public function logout(Request $request){
        //退出,会清除用户信息
        Auth::guard('admin') -> logout();
        Session::flush();


        //跳转到登录界面
        return redirect('/admin/public/login');
    }

}
