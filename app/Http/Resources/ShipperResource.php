<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipperResource extends JsonResource
{
    public static $wrap;

    public function toArray($request): array|Arrayable|\JsonSerializable
    {
        return [
            'data' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'address' => $this->resource->address,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ],
            'links' => [
                'self' => route('shippers.show', ['shipper_id' => $this->resource->id]),
            ],
        ];
    }
}
