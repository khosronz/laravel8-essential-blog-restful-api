<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'Title'=>$this->title,
            'Slug'=>$this->slug,
            'Body'=>$this->body,
            'date'=>$this->updated_at->format('m/d/Y'),
        ];
    }
}
