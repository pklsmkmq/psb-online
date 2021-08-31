<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesDiniyyahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes_diniyyah', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->dateTime('tanggal');
            $table->boolean("metode");
            $table->boolean('status');
            $table->longText('catatan')->nullable();
            $table->string('approved_by');
            $table->boolean('jadwal_ulang')->nullable();
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
        Schema::dropIfExists('tes_diniyyah');
    }
}
