<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *   @OA\Xml(name="Contact"),
 *   @OA\Property(property="name", type="string", example="Monster Inc."),
 *   @OA\Property(property="address", type="string", example="722 Heidenreich Bridge\nNorth Ursula, FL 04743"),
 *   @OA\Property(property="created_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="updated_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="deleted_at", type="timestamp", example="1970-01-01 00:00:00"),
 * )
 */
class Shipper extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function scopeFilterByRequest(Builder $query, Request $request): Builder
    {
        if ($request->has('name')) {
            $query->where('name', 'ilike', "%{$request->get('name')}%");
        }

        return $query;
    }
}
