<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiSmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi_smp', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nik_siswa");
            $table->string('cabang_lomba');
            $table->integer('peringkat_tingkat_kab');
            $table->integer('peringkat_tingkat_provinsi');
            $table->integer('peringkat_tingkat_nasional');
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
        Schema::dropIfExists('prestasi_smp');
    }
}
