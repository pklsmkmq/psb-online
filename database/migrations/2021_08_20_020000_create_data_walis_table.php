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
            $table->id();
            $table->string('nik_wali')->nullable();
            $table->foreignId("user_id");
            $table->string('name_wali')->nullable();
            $table->string('tempat_lahir_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('nomor_telepon_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
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
