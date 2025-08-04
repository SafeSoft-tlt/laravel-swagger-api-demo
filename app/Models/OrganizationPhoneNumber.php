<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationPhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'phone_number',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
} 