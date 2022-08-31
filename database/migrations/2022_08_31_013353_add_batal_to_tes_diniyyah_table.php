<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatalToTesDiniyyahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tes_diniyyah', function (Blueprint $table) {
            $table->boolean('is_batal');
            $table->string('keterangan_batal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tes_diniyyah', function (Blueprint $table) {
            $table->dropColumn('is_batal');
            $table->dropColumn('keterangan_batal');
        });
    }
}
