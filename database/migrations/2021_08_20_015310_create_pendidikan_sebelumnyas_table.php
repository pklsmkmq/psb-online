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
            $table->foreignId("user_id");
            $table->string('asal_sekolah')->nullable();
            $table->text('alamat_sekolah')->nullable();
            $table->string('nomor_telepon_sekolah')->nullable();
            $table->double('nisn')->nullable();
            $table->double('npsn')->nullable();
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
