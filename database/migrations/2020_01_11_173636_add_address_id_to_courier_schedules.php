<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressIdToCourierSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courier_schedules', function (Blueprint $table) {
            $table->integer('address_id')->nullable()->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('restrict');
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
            $table->dropColumn(['address_id']);
        });
    }
}
