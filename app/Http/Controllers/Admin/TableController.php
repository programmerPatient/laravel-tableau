<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Auth;
use Input;
use App\Models\Admin\Member;


class TableController extends Controller
{
    public function index(Request $request){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => Session::get('tableau_domain')."/trusted?username=".Auth::guard('admin')->user()->username,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"username\":\"admin\"}",
        CURLOPT_HTTPHEADER => array(
            "User-Agent: TabCommunicate",
            "Content-Type: application/json",
            "Accept: application/json",
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            Session::put("ticket",$response);
        }

        $contentUrl = $request->all()['contentUrl'];
        $array = explode("/", $contentUrl);
        array_splice($array,1,1);
        $contentUrl = implode("/", $array);
        $ticket = Session::get('ticket');
        return view('admin.table.index',compact('contentUrl','ticket'));
    }

    public function status(){
        $data = Input::all();
        // dd($data);
        if($data['type'] == '1'){
            //创建table用户
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => Session::get('tableau_domain')."/api/3.2/sites/fc697b45-5d47-43c0-9e39-5a90812e6273/users",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "<tsRequest><user name=\"" . $data['username'] ."\" siteRole=\"Interactor\" authSetting=\"ServerDefault\" /></tsRequest>",
            CURLOPT_HTTPHEADER => array(
                "X-Tableau-Auth: ". Session::get('token'),
                "Accept: application/json",
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              return '0';
            } else {
                $res = json_decode($response);
                $result = Member::where('id',$data['id'])->get()->first();
                $result['tableau_id'] = $res->user->id;
                $result->status = 1;
                $result->save();

                return '1';
            }
        }else{
            // // dd($data);
            // //删除用户
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => Session::get('tableau_domain')."/api/3.2/sites/fc697b45-5d47-43c0-9e39-5a90812e6273/users/".$data['tableau_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "X-Tableau-Auth: ".Session::get('token'),
                "Accept: application/json",
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $result = Member::where('tableau_id',$data['tableau_id'])->get()->first();
            $result['tableau_id'] = null;
            $result->status = 2;
            $result->save();
            return '1';
        }
    }
}
