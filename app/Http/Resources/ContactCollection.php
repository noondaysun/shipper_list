<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'contact_number' => $contact->contact_number,
                    'contact_type' => $contact->contact_type,
                    'shipper_id' => $contact->shipper_id,
                    'created_at' => $contact->created_at,
                    'updated_at' => $contact->updated_at,
                ];
            }),
            'links' => [
                'self' => route('contacts.index'),
            ],
        ];
    }
}
