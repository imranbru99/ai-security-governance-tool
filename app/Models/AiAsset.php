<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiAsset extends Model
{
    protected $fillable = [
        'code', 'name', 'slug', 'asset_type', 'environment', 'owner_team',
        'data_classification', 'vendor', 'risk_tier', 'is_active', 'tags', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'risk_tier' => 'integer',
            'tags' => 'array',
        ];
    }

    public function riskAssessments(): HasMany
    {
        return $this->hasMany(RiskAssessment::class);
    }

    public function violations(): HasMany
    {
        return $this->hasMany(PolicyViolation::class);
    }
}
