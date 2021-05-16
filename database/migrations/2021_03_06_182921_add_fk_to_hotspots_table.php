<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToHotspotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->foreignId('sourceScene')->constrained('scenes')->cascadeOnDelete();
            $table->foreignId('targetScene')->constrained('scenes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->dropForeign(['sourceScene'],['targetScene']);
            $table->dropColumn(['sourceScene'],['targetScene']);
        });
    }
}
