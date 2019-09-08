<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatusAtTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['transaction_status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('transaction_status', ['open', 'scheduled', 'delivered', 'closed', 'canceled'])->default('open');
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
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn(['transaction_status']);
            });

            Schema::table('transactions', function (Blueprint $table) {
                $table->enum('transaction_status', ['open', 'scheduled', 'delivered', 'closed'])->default('open');
            });
        });
    }
}
