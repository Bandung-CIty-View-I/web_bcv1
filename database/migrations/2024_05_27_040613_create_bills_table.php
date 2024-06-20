<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('paid');
            $table->string('thn_bl');
            $table->integer('ipl');
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->integer('penggunaan_air');
            $table->integer('tag_air');
            $table->integer('adm_air')->default(12500);
            $table->integer('admin')->default(2500);
            $table->integer('tunggakan_1')->default(0);
            $table->integer('tunggakan_2')->default(0);
            $table->integer('tunggakan_3')->default(0);
            $table->integer('tag_now');
            $table->integer('total_tag');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
