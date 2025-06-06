<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Keyword extends Model
{
    /** @use HasFactory<\Database\Factories\KeywordFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function signs(): BelongsToMany
    {
        return $this->belongsToMany(Sign::class, 'sign_keyword');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_keyword');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_keyword');
    }
}
