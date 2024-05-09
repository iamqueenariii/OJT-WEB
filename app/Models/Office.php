<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'office_head', 'position'];

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
