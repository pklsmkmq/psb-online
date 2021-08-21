<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiBelajarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi_belajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nik_siswa");
            $table->string('mata_pelajaran');
            $table->integer('nilai_kelas1_semester1');
            $table->integer('nilai_kelas1_semester2');
            $table->integer('nilai_kelas2_semester1');
            $table->integer('nilai_kelas2_semester2');
            $table->integer('nilai_kelas3_semester1');
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
        Schema::dropIfExists('prestasi_belajar');
    }
}
