<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostureCheck extends Model
{
    protected $fillable = [
        'check_key', 'name', 'domain', 'score', 'status', 'owner_id',
        'finding', 'remediation', 'last_checked_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'last_checked_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
