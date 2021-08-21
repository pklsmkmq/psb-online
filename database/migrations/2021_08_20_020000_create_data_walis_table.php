<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataWalisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_wali', function (Blueprint $table) {
            $table->double('nik_wali')->nullable(false)->primary();
            $table->foreignId("nik_siswa");
            $table->string('name_wali')->nullable(false);
            $table->string('tempat_lahir_wali')->nullable(false);
            $table->date('tanggal_lahir_wali')->nullable(false);
            $table->string('pekerjaan_wali')->nullable(false);
            $table->string('nomor_telepon_wali');
            $table->double('penghasilan_wali');
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
        Schema::dropIfExists('data_wali');
    }
}
