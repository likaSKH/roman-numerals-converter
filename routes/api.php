<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('convert', 'RomanNumeralConverterController@convert');
Route::get('top_converted_integers', 'RomanNumeralConverterController@topConvertedIntegers');
Route::get('recently_converted_integers', 'RomanNumeralConverterController@index');
