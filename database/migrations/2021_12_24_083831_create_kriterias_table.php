<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria')->nullable();
            $table->integer('nilai_bawah')->nullable();
            $table->integer('nilai_tengah')->nullable();
            $table->integer('nilai_atas')->nullable();
            $table->string('nama_bawah',100)->nullable();
            $table->string('nama_tengah',100)->nullable();
            $table->string('nama_atas',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriterias');
    }
}
