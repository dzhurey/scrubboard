<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBirthDateNullableToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->change();
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
            $table->date('birth_date')->nullable()->change();
        });
    }
}
