<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalonSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->double('nik_siswa')->nullable(false)->primary();
            $table->string('name_siswa')->nullable(false);
            $table->foreignId("user_id");
            $table->string('tempat_lahir_siswa')->nullable(false);
            $table->date('tanggal_lahir_siswa')->nullable(false);
            $table->string('jenis_kelamin');
            $table->string('agama')->nullable(false);
            $table->string('golongan_darah');
            $table->text('alamat_siswa')->nullable(false);
            $table->string('nomor_telepon_siswa');
            $table->string('pihak_yg_dihubungi')->nullable(false);
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->string('ukuran_baju');
            $table->string('cita_cita');
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
        Schema::dropIfExists('calon_siswa');
    }
}
