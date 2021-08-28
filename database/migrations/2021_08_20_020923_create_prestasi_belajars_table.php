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
            $table->foreignId("user_id");
            $table->string('mata_pelajaran')->nullable();
            $table->integer('nilai_kelas1_semester1')->nullable();
            $table->integer('nilai_kelas1_semester2')->nullable();
            $table->integer('nilai_kelas2_semester1')->nullable();
            $table->integer('nilai_kelas2_semester2')->nullable();
            $table->integer('nilai_kelas3_semester1')->nullable();
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
