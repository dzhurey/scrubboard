<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('payment_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->decimal('amount', 20, 2);

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_lines');
    }
}
