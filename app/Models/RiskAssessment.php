<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessment extends Model
{
    protected $fillable = [
        'code', 'subject_type', 'subject_name', 'ai_asset_id', 'assessor_id',
        'score', 'level', 'status', 'factors', 'recommendation', 'assessed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'factors' => 'array',
            'assessed_at' => 'datetime',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AiAsset::class, 'ai_asset_id');
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }
}
