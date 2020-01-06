<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceiverNameToPaymentMeans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_means', function (Blueprint $table) {
            $table->string('receiver_name')->nullable();
            $table->renameColumn('payment_type', 'payment_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_means', function (Blueprint $table) {
            $table->dropColumn(['receiver_name']);
            $table->renameColumn('payment_method', 'payment_type');
        });
    }
}
