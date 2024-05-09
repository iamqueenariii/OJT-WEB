<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Applicant extends Model
{
    use HasFactory;


    protected $fillable = ['lname','fname', 'mname', 'address', 'bday', 'started_date', 'hrs','office_id', 'school_id', 'status', 'type'];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function fullname()
    {
        return $this->fname.' '.$this->mname[0].'. '.$this->lname;
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}
