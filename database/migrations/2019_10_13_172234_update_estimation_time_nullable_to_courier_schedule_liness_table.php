<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstimationTimeNullableToCourierScheduleLinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->string('estimation_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->string('estimation_time')->nullable()->change();
        });
    }
}
