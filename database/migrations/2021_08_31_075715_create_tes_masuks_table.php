<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string('kode_mapel')->nullable();
            $table->double('nilai')->nullable();
            $table->boolean('ulangi');
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
        Schema::dropIfExists('tes_masuk');
    }
}
