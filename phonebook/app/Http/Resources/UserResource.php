<?php

namespace App\Http\Resources;

use App\User;
use App\Contact;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type'          => 'user',
            'id'            => $this->id,
            'attributes'    => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'contacts' => route('users.listContacts', ['user' => $this->id]),
            ],
            'links'         => [
                'self' => route('users.show', $this->id),
            ]
        ];
    }
}
