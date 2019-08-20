<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('transaction_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->decimal('quantity', 20, 2);
            $table->decimal('unit_price', 20, 2);
            $table->decimal('amount', 20, 2);
            $table->text('note');

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('restrict');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_lines');
    }
}
