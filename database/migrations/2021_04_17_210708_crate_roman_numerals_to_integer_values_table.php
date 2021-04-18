<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateRomanNumeralsToIntegerValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roman_numerals_to_integer_values', function (Blueprint $table) {
            $table->id();
            $table->char('roman_numeral');
            $table->integer('integer_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roman_numerals_to_integer_values');
    }
}
