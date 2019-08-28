<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCourierIdToCourierSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courier_schedules', function (Blueprint $table) {
            $table->dropColumn(['courier_id']);
            $table->integer('person_id')->nullable()->unsigned();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courier_schedules', function (Blueprint $table) {
            $table->dropColumn(['person_id']);
            $table->integer('courier_id')->nullable()->unsigned();

            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('restrict');
        });
    }
}
