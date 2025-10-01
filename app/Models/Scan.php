<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Scan extends Model
{
    protected $fillable = ['project_id', 'scan_date', 'raw_result'];
    protected $casts = [
        'raw_result' => 'array',
        'scan_date' => 'datetime',
    ];
    /**
     * Relasi Scan milik 1 Project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Relasi 1 Scan memiliki banyak Vulnerability
     */
    public function vulnerabilities(): HasMany
    {
        return $this->hasMany(Vulnerability::class);
    }
}