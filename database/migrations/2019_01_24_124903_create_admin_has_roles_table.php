<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminHasRolesTable extends Migration
{
    public function up()
    {
        Schema::create('admin_has_roles', function (Blueprint $table) {
            $table->unsignedInteger('adminer_id');
            $table->unsignedInteger('role_id');
            $table->foreign('adminer_id')->references('id')->on('adminers')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_has_roles');
    }
}
