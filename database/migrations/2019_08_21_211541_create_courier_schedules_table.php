<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourierSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('courier_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->enum('schedule_type', ['pickup', 'delivery']);
            $table->date('schedule_date');

            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('restrict');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courier_schedules');
    }
}
