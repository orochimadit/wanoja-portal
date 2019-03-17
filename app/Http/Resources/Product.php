<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
     $data['categories'] = $this->categories;
        $data = array_merge($parent, $data);
    return [
        'status' => 'success',
        'message' => 'Product data',
        'data' => $data,
    ];
    }
}
