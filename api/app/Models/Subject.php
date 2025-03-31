<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function signs(): BelongsToMany
    {
        return $this->belongsToMany(Sign::class);
    }

    public function suggestions(): BelongsToMany
    {
        return $this->belongsToMany(Suggestion::class);
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'subject_keyword', 'subject_id', 'keyword_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }
}
