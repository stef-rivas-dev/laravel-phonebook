<?php

namespace App\Http\Resources;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ContactResource::collection($this->collection),
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('contacts.index'),
            ],
        ];
    }
}
