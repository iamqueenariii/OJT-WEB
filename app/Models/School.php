<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_head', 'position'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

}
