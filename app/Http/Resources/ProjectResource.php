<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            // 'category_name' => $this->category->name,
            // 'category' => [
            //     'id' => $this->category->id,
            //     'name' => $this->category->name,
            //     '_links' => [
            //         '_self' => url('api/categories/' . $this->category->id)
            //     ]
            // ],
            '_links' => [
                '_self' => url('api/projects/' . $this->id)
            ]
        ];
    }
}
