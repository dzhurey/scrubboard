<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryScheduleLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_schedule_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('delivery_schedule_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->time('estimation_time');
            $table->string('image_name')->nullable();
            $table->boolean('is_delivered')->default(false);

            $table->foreign('delivery_schedule_id')->references('id')->on('delivery_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_schedule_lines');
    }
}
