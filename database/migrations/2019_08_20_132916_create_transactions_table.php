<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->enum('transaction_type', ['order', 'invoice']);
            $table->enum('transaction_status', ['open', 'closed']);
            $table->integer('customer_id')->unsigned();
            $table->date('transaction_date');
            $table->date('pickup_date');
            $table->date('delivery_date');
            $table->decimal('original_amount', 20, 2);
            $table->decimal('discount', 20, 2);
            $table->decimal('discount_amount', 20, 2);
            $table->decimal('freight', 20, 2);
            $table->decimal('total_amount', 20, 2);
            $table->text('note');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
