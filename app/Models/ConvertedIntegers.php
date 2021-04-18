<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvertedIntegers extends Model
{
    use HasFactory;

    protected $fillable = ['integer_value', 'roman', 'created_at', 'updated_at'];
}
