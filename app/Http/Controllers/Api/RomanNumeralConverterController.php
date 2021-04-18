<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RomanNumeralConverter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ConvertedIntegers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RomanNumeralConverterController extends Controller
{
    private RomanNumeralConverter $converter;

    public function __construct()
    {
        $this->converter = new RomanNumeralConverter();
    }

    /**
     * Returns all converted integers.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Record of converted integers ordered DESC
            $convertedIntegersData = ConvertedIntegers::orderBy('created_at', 'desc')->get();

            return response()->json([
                'status' => 'success',
                'data' => $convertedIntegersData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Returns the top 10 converted integers.
     *
     * @return JsonResponse
     */
    public function topConvertedIntegers(): JsonResponse
    {
        try {
            // Getting tp 10 most requested integer records from DB.
            $integers =  ConvertedIntegers::select('integer_value', DB::raw('COUNT(integer_value) AS occurrences'))
                ->groupBy('integer_value')
                ->orderBy('occurrences', 'DESC')
                ->limit(10)
                ->get();

            foreach($integers  as $integer) {
                // Getting last record with created_at time and roman equivalent.s
                $lastRecord = ConvertedIntegers::orderBy('created_at', 'desc')
                    ->where('integer_value', '=', $integer->integer_value)
                    ->first();

                $integer->created_at = $lastRecord->created_at;
                $integer->roman = $lastRecord->roman;
            }

            return response()->json([
                'status' => 'success',
                'data' => $integers
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Returns converted roman numerals.
     * Saves converted number with corresponding roman numerals.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function convert(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), ['integer' => 'required|numeric|min:1|max:3999']);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'success',
                    'numerals' => $validator->errors()
                ]);
            }

            // Call function from RomanNumeralConverter Service to return roman equivalent for integer.
            $numeral = $this->converter->convertInteger($request->integer);

            // Save converted integer into the DB along with roman numeral.
            ConvertedIntegers::create([
                'integer_value' => $request->integer,
                'roman'   => $numeral
            ]);

            return response()->json([
                'status' => 'success',
                'numerals' => $numeral
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
