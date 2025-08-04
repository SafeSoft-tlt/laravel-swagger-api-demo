<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Building",
 *     title="Building",
 *     description="Building model"
 * )
 */
class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
    ];

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Building ID"
     * )
     * @OA\Property(
     *     property="address",
     *     type="string",
     *     description="Building address"
     * )
     * @OA\Property(
     *     property="latitude",
     *     type="number",
     *     format="float",
     *     description="Latitude coordinate"
     * )
     * @OA\Property(
     *     property="longitude",
     *     type="number",
     *     format="float",
     *     description="Longitude coordinate"
     * )
     * @OA\Property(
     *     property="created_at",
     *     type="string",
     *     format="date-time",
     *     description="Creation timestamp"
     * )
     * @OA\Property(
     *     property="updated_at",
     *     type="string",
     *     format="date-time",
     *     description="Last update timestamp"
     * )
     */

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
} 