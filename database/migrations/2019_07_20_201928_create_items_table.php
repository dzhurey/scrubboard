<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('item_type', ['service', 'item']);
            $table->text('description');
            $table->string('product', 255)->nullable();
            $table->string('service', 255)->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->integer('item_sub_category_id')->unsigned();

            $table->foreign('item_sub_category_id')->references('id')->on('item_sub_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
