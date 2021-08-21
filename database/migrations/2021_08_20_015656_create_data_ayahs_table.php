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
            $table->double('nik_ayah')->nullable(false)->primary();
            $table->foreignId("nik_siswa");
            $table->string('name_ayah')->nullable(false);
            $table->string('tempat_lahir_ayah')->nullable(false);
            $table->date('tanggal_lahir_ayah')->nullable(false);
            $table->string('pekerjaan_ayah')->nullable(false);
            $table->string('nomor_telepon_ayah');
            $table->double('penghasilan_ayah');
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
