<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     title="Organization",
 *     description="Organization model"
 * )
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building_id',
    ];

    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Organization ID"
     * )
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Organization name"
     * )
     * @OA\Property(
     *     property="building_id",
     *     type="integer",
     *     description="Building ID"
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

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(OrganizationPhoneNumber::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_organization');
    }
} 