<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('phone_number', 15);
            $table->string('mobile_number', 15);
            $table->string('email');
            $table->text('address');
            $table->string('sub_district', 150);
            $table->string('district', 150);
            $table->string('city', 150);
            $table->string('country', 150);
            $table->string('zip_code', 10);
            $table->string('contact_name', 255);
            $table->string('contact_phone_number', 15);
            $table->string('contact_mobile_number', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
