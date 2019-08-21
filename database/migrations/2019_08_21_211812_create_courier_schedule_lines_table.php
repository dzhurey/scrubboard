<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourierScheduleLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_schedule_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('courier_schedule_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->time('estimation_time');
            $table->string('image_name')->nullable();
            $table->enum('status', ['scheduled', 'overdue', 'done'])->default('scheduled');

            $table->foreign('courier_schedule_id')->references('id')->on('courier_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courier_schedule_lines');
    }
}
