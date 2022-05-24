<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *   @OA\Xml(name="Contact"),
 *   @OA\Property(property="name", type="string", example="John Doe"),
 *   @OA\Property(property="contact_number", type="string", example="916-825-5237"),
 *   @OA\Property(property="status", type="enum", enum={"primary", "site", "shipping", "billing", "admin"}, example="site"),
 *   @OA\Property(property="shipper_id", type="string", example="XYbl6Nd05WqEJ1A4"),
 *   @OA\Property(property="created_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="updated_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="deleted_at", type="timestamp", example="1970-01-01 00:00:00"),
 * )
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipper_id',
        'name',
        'contact_number',
        'contact_type',
    ];

    public function scopeFilterByRequest(Builder $query, Request $request): Builder
    {
        if ($request->has('name')) {
            $query->where('name', 'ilike', "%{$request->get('name')}%");
        }

        if ($request->has('contact-type')) {
            $query->where('contact_type', $request->get('contact-type'));
        }

        if ($request->has('shipper-name')) {
            $query->select(['contacts.*'])
                ->join('shippers', 'shippers.id', '=', 'contacts.shipper_id')
                ->where('shippers.name', 'ilike', "%{$request->get('shipper-name')}%");
        }

        return $query;
    }

    public function shipper(): BelongsTo
    {
        return $this->belongsTo(Shipper::class);
    }
}
