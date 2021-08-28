<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAyahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ayah', function (Blueprint $table) {
            $table->id();
            $table->string('nik_ayah')->nullable();
            $table->foreignId("user_id");
            $table->string('name_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nomor_telepon_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
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
        Schema::dropIfExists('data_ayah');
    }
}
