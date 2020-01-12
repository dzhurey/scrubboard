<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('code', 255)->unique();
            $table->string('quota', 255)->nullable();
            $table->decimal('percentage', 5, 2);
            $table->decimal('max_promo', 20, 2);
            $table->dateTime('start_promo');
            $table->dateTime('end_promo');
            $table->enum('type', ['promo', 'bebemoney']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
