<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('item_group_id')->unsigned();
            $table->string('name', 255);

            $table->foreign('item_group_id')->references('id')->on('item_groups')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_sub_categories');
    }
}
