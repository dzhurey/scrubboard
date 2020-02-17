<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoIdToTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->integer('promo_id')->nullable()->unsigned();
            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->dropColumn(['promo_id']);
        });
    }
}
