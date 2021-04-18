<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RomanNumeralsToIntegerValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = \DB::table('roman_numerals_to_integer_values');

        $table->delete();

        $table->insert(
            [
                [
                    'roman_numeral' => 'M',
                    'integer_value' => 1000,
                ],
                [
                    'roman_numeral' => 'CM',
                    'integer_value' => 900,
                ],
                [
                    'roman_numeral' => 'D',
                    'integer_value' => 500,
                ],
                [
                    'roman_numeral' => 'CD',
                    'integer_value' => 400,
                ],
                [
                    'roman_numeral' => 'C',
                    'integer_value' => 100,
                ],
                [
                    'roman_numeral' => 'XC',
                    'integer_value' => 90,
                ],
                [
                    'roman_numeral' => 'L',
                    'integer_value' => 50,
                ],
                [
                    'roman_numeral' => 'XL',
                    'integer_value' => 40,
                ],
                [
                    'roman_numeral' => 'X',
                    'integer_value' => 10,
                ],
                [
                    'roman_numeral' => 'IX',
                    'integer_value' => 9,
                ],
                [
                    'roman_numeral' => 'V',
                    'integer_value' => 5,
                ],
                [
                    'roman_numeral' => 'IV',
                    'integer_value' => 4,
                ],
                [
                    'roman_numeral' => 'I',
                    'integer_value' => 1,
                ],
            ]
        );
    }
}
