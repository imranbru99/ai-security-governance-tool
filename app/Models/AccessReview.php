<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessReview extends Model
{
    protected $fillable = [
        'code', 'title', 'scope', 'status', 'reviewer_id', 'entitlements_total',
        'entitlements_reviewed', 'flags_count', 'due_on', 'started_at',
        'completed_at', 'summary', 'metadata',
    ];

    protected function casts(): array
    {
        return [
            'due_on' => 'date',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'metadata' => 'array',
            'entitlements_total' => 'integer',
            'entitlements_reviewed' => 'integer',
            'flags_count' => 'integer',
        ];
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
