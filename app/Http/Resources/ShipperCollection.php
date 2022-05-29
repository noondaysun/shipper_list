<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShipperCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($shipper) {
                return [
                    'id' => $shipper->id,
                    'name' => $shipper->name,
                    'address' => $shipper->contact_number,
                    'created_at' => $shipper->created_at,
                    'updated_at' => $shipper->updated_at,
                ];
            }),
            'links' => [
                'self' => route('shippers.index'),
            ],
        ];
    }
}
