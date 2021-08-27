<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidikanSebelumnyasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendidikan_sebelumnya', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nik_siswa");
            $table->string('asal_sekolah');
            $table->text('alamat_sekolah');
            $table->string('nomor_telepon_sekolah');
            $table->double('nisn');
            $table->double('npsn');
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
        Schema::dropIfExists('pendidikan_sebelumnya');
    }
}
