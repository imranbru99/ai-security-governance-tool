<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolicyViolation extends Model
{
    protected $fillable = [
        'code', 'governance_policy_id', 'ai_asset_id', 'reported_by', 'title',
        'severity', 'status', 'description', 'detected_at', 'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'detected_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    public function policy(): BelongsTo
    {
        return $this->belongsTo(GovernancePolicy::class, 'governance_policy_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AiAsset::class, 'ai_asset_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
