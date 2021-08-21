<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataIbusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ibu', function (Blueprint $table) {
            $table->double('nik_ibu')->nullable(false)->primary();
            $table->foreignId("nik_siswa");
            $table->string('name_ibu')->nullable(false);
            $table->string('tempat_lahir_ibu')->nullable(false);
            $table->date('tanggal_lahir_ibu')->nullable(false);
            $table->string('pekerjaan_ibu')->nullable(false);
            $table->string('nomor_telepon_ibu');
            $table->double('penghasilan_ibu');
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
        Schema::dropIfExists('data_ibu');
    }
}
