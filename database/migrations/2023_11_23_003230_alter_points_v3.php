<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPointsV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
          $table->dropColumn('activity_id');
          $table->dropColumn('sub_activity_id');

        });

        Schema::table('points', function (Blueprint $table) {
          $table->unsignedBigInteger('activity_id')->nullable();
          $table->unsignedBigInteger('sub_activity_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            //
        });
    }
}
