<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用faker方法模拟多条数据,实例化时，create里面的参数表示本地化
        $faker = \Faker\Factory::create('zh_CN');
        //循环生成数据
        $data = [];
        for($i=0;$i<100;$i++){
            //访问具体的属性
            $data[] = [
                'username' =>$faker -> username,
                'password' => bcrypt('123456'),//使用框架内置的bcrypt方法加密密码
                'gender' => rand(1,3),
                'mobile' => $faker -> phoneNumber,//生成手机号
                'email' =>  $faker -> email,//邮箱
                'role_id' => rand(1,6),//角色id
                'created_at' => date('Y-m-d H:i:s',time()),
                'status' => rand(1,2)//帐号状态
            ];
        }

        //写入数据
        DB::table('manager') -> insert($data);
    }
}
