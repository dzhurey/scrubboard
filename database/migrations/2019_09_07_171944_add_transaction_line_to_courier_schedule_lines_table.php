<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionLineToCourierScheduleLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'status']);
        });

        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->integer('transaction_line_id')->nullable()->unsigned();
            $table->enum('status', ['scheduled', 'overdue', 'done', 'canceled'])->default('scheduled');

            $table->foreign('transaction_line_id')->references('id')->on('transaction_lines')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->dropColumn(['transaction_line_id', 'status']);
        });

        Schema::table('courier_schedule_lines', function (Blueprint $table) {
            $table->integer('transaction_id')->nullable()->unsigned();
            $table->enum('status', ['scheduled', 'overdue', 'done'])->default('scheduled');

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('restrict');
        });
    }
}
