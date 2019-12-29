<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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

            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'description' => $this->description,
            'links' => [
                'Categories' => route('api.categories.index'),
                'show' => route('api.categories.show',$this->id),
                'edit' => route('api.categories.edit',$this->id),
                'put' => route('api.categories.update',$this->id),
                'delete' => route('api.categories.delete',$this->id),
            ],
        ];
//        return parent::toArray($request);
    }
}
