<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropItemGroupIdToItemSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_sub_categories', function (Blueprint $table) {
            $table->dropColumn('item_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_sub_categories', function (Blueprint $table) {
            $table->integer('item_group_id')->nullable()->unsigned();

            $table->foreign('item_group_id')->references('id')->on('item_groups')->onDelete('restrict');
        });
    }
}
