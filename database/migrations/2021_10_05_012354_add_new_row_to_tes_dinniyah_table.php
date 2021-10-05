<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRowToTesDinniyahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tes_diniyyah', function (Blueprint $table) {
            $table->time('jam_tes')->nullable();
            $table->string('dibuat_oleh')->nullable();
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
            $table->dropColumn('jam_tes');
            $table->dropColumn('dibuat_oleh');
        });
    }
}
