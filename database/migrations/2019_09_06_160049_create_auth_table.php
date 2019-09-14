<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth', function (Blueprint $table) {
            $table->increments('id');//主键
            $table->string('auth_name',20)->notnull();//权限名称
            $table->string('controller',40)->nullable();//权限对应的控制器
            $table->string('action',30)->nullable();//权限对应的方法
            $table->tinyInteger('pid');//当前权限其父级id
            $table->enum('is_nav',[1,2])->notnull()->default('1');//是否作为菜单显示
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth');
    }
}
