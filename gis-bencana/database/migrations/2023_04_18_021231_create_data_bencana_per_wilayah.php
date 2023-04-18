<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBencanaPerWilayah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bencana_per_wilayah', function (Blueprint $table) {
            $table->integer('id_bencana_per_wilayah');
            $table->integer('jumlah')->default("0");
            $table->date('tgl_terjadi');
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
        Schema::dropIfExists('data_bencana_per_wilayah');
    }
}
