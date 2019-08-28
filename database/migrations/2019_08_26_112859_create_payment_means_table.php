<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_means', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('payment_id')->unsigned();
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->enum('payment_type', ['cash', 'bank_transfer', 'credit_card','other']);
            $table->decimal('amount', 20, 2);
            $table->date('payment_date');
            $table->text('note')->nullable();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_means');
    }
}
