<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBebeFieldsToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('partner_type', ['customer', 'vendor', 'endorser']);
            $table->string('bebe_name', 255)->nullable();
            $table->enum('bebe_gender', ['male', 'female'])->nullable();
            $table->date('bebe_birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['partner_type', 'bebe_name', 'bebe_gender', 'bebe_birth_date']);
        });
    }
}
