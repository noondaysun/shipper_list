<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public static $wrap;

    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return [
            'data' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'contact_number' => $this->resource->contact_number,
                'contact_type' => $this->resource->contact_type,
                'shipper_id' => $this->resource->shipper_id,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ],
            'links' => [
                'self' => route('contacts.show', ['contact_id' => $this->resource->id]),
            ],
        ];
    }
}
