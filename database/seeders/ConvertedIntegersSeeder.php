<?php

namespace Database\Seeders;

use App\Services\RomanNumeralConverter;
use Illuminate\Database\Seeder;

class ConvertedIntegersSeeder extends Seeder
{
    private RomanNumeralConverter $converter;

    public function __construct()
    {
        $this->converter = new RomanNumeralConverter();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableData = [];

        for ($i = 1; $i < 15; $i++) {
            $tableData[$i] = [
                'roman' => $this->converter->convertInteger($i),
                'integer_value' => $i,
                'created_at' => now()->addDays($i)
            ];
        }

        \DB::table('converted_integers')->insert($tableData);
    }
}
