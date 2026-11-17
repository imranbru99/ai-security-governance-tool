<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernancePolicy extends Model
{
    protected $fillable = [
        'code', 'title', 'slug', 'category', 'severity', 'status', 'version',
        'owner_id', 'enforcement_enabled', 'effective_at', 'reviewed_at',
        'summary', 'body', 'tags',
    ];

    protected function casts(): array
    {
        return [
            'enforcement_enabled' => 'boolean',
            'effective_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'tags' => 'array',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function violations(): HasMany
    {
        return $this->hasMany(PolicyViolation::class);
    }
}
