<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class Project extends Model
{
    protected $fillable = ['name', 'repo_url'];
    /**
     * Relasi 1 Project memiliki banyak Scan
     */
    public function scans(): HasMany
    {
        return $this->hasMany(Scan::class);
    }
    /**
     * Relasi 1 Project memiliki banyak Vulnerability melalui Scan
     */
    public function vulnerabilities(): HasManyThrough
    {
        return $this->hasManyThrough(Vulnerability::class, Scan::class);
    }
}
