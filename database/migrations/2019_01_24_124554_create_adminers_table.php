<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminersTable extends Migration
{
    public function up()
    {
        Schema::create('adminers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account');
            $table->string('password');
            $table->string('nick_name')->default('');
            $table->string('avatar')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adminers');
    }
}
