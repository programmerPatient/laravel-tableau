<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->notnull();
            $table->string('password')->notnull();
            $table->enum('gender',[1,2,3])->notnull()->default('1');//性别
            $table->string('mobile',11);
            $table->string('email',40);
            // $table->string('avatar');//头像
            $table->string('tableau_id')->nullable();//tableauid
            $table->timestamps();
            // $table->enum('type',[1,2])->notnull()->default('1');
           $table->enum('status',[1,2])->notnull()->default('2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
