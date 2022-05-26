<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *   @OA\Xml(name="Contact"),
 *   @OA\Property(property="name", type="string", example="participants-mm-bulk-import.csv"),
 *   @OA\Property(property="address", type="string", example="722 Heidenreich Bridge\nNorth Ursula, FL 04743"),
 *   @OA\Property(property="created_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="updated_at", type="timestamp", example="1970-01-01 00:00:00"),
 *   @OA\Property(property="deleted_at", type="timestamp", example="1970-01-01 00:00:00"),
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
