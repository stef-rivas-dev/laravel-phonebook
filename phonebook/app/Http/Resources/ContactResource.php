<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'          => 'contact',
            'id'            => $this->id,
            'attributes'    => [
                'user_id' => $this->user_id,
                'label' => $this->label,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'created_at' => $this->created_at,
            ],
            'links'         => [
                'self' => route('contacts.show', $this->id),
            ]
        ];
    }
}
