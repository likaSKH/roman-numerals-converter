<?php

namespace App\Services;

use App\Models\RomanNumeralsToIntegerValues;

class RomanNumeralConverter
{
    public function convertInteger($number): string
    {
        // Roman equivalents for specific integers.
        $numeralValues =  RomanNumeralsToIntegerValues::all();
        $roman = "";

        foreach($numeralValues as $numeralValue) {
            while ($numeralValue->integer_value <= $number) {
                $roman .=  $numeralValue->roman_numeral;
                $number -= $numeralValue->integer_value;
            }
        }

        return $roman;
    }
}
