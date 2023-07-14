<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address'); // Kolom 'address'
        $table->string('phone_number');
        $table->string('sim_number');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
