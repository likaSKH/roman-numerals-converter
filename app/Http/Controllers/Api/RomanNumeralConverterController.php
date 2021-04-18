<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RomanNumeralConverter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ConvertedIntegers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RomanNumeralConverterResource;

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
     */
    public function index()
    {
        // Record of converted integers ordered DESC
        $convertedIntegersData = ConvertedIntegers::orderBy('created_at', 'desc')->get();

        return RomanNumeralConverterResource::collection($convertedIntegersData);
    }

    /**
     * Returns the top 10 converted integers.
     *
     */
    public function topConvertedIntegers()
    {
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

        return RomanNumeralConverterResource::collection($integers);
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
        $validator = Validator::make($request->all(), ['integer' => 'required|numeric|min:1|max:3999']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Call function from RomanNumeralConverter Service to return roman equivalent for integer.
        $numeral = $this->converter->convertInteger($request->integer);

        // Save converted integer into the DB along with roman numeral.
        ConvertedIntegers::create([
            'integer_value' => $request->integer,
            'roman'   => $numeral
        ]);

        return response()->json($numeral);
    }
}
