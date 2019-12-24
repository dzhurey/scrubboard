<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayemntTypeToPaymentMeans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_means', function (Blueprint $table) {
            $table->enum('payment_type', ['down_payment', 'acquittance'])->nullable();
            Schema::table('payment_means', function (Blueprint $table) {
                $table->dropColumn(['payment_method']);
            });

            Schema::table('payment_means', function (Blueprint $table) {
                $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'other', 'bebemoney'])->default('cash');
            });
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
            Schema::table('payment_means', function (Blueprint $table) {
                $table->dropColumn(['payment_method']);
            });

            Schema::table('payment_means', function (Blueprint $table) {
                $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'other'])->default('cash');
            });
        });
    }
}
