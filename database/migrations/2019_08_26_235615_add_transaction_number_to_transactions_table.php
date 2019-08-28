<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionNumberToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_number', 255)->default('');
        });
        \DB::statement('UPDATE transactions SET transaction_number = id');
        Schema::table('transactions', function (Blueprint $table) {
            $table->unique('transaction_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique(['transactions_transaction_number_unique']);
            $table->dropColumn(['transaction_number']);
        });
    }
}
