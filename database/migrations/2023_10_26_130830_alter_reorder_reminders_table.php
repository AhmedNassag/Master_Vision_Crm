<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReorderRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reorder_reminders', function (Blueprint $table) {
            $table->unsignedBigInteger('interest_id')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('expected_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
