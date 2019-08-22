<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountToTransactionLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_lines', function (Blueprint $table) {
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('discount_amount', 20, 2)->default(0);
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
            $table->dropColumn(['discount', 'discount_amount']);
        });
    }
}
