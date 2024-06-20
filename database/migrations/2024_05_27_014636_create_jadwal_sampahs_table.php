<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalSampahsTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_sampahs', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->string('waktu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_sampahs');
    }
}
