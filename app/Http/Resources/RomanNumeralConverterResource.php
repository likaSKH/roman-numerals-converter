<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RomanNumeralConverterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'integer' => $this->integer_value,
            'roman' => $this->roman,
            'created_at' => $this->created_at,
        ];
    }
}
