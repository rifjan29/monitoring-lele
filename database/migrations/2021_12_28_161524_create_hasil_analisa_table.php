<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilAnalisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_analisa', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('nilai_asam');
            $table->tinyInteger('nilai_netral');
            $table->tinyInteger('nilai_basa');
            $table->tinyInteger('nilai_rendah');
            $table->tinyInteger('nilai_normal');
            $table->tinyInteger('nilai_tinggi');
            $table->float('rata_rata');
            $table->string('keterangan');
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
        Schema::dropIfExists('hasil_analisa');
    }
}
