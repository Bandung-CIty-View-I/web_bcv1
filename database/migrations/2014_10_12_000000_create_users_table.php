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
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('blok_cluster')->nullable();
            $table->string('nomor_kavling');
            $table->string('no_hp')->unique();
            $table->string('rt');
            $table->integer('ipl');
            $table->string('password');
            $table->string('role')->default('warga');
            $table->string('id_pelanggan_online')->unique(); 
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
