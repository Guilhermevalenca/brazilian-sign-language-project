<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sign extends Model
{
    /** @use HasFactory<\Database\Factories\SignFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'display'
    ];

    public function description(): BelongsTo
    {
        return $this->belongsTo(Description::class);
    }

    public function example(): BelongsTo
    {
        return $this->belongsTo(Example::class);
    }

    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class);
    }

    public function suggestions(): BelongsToMany
    {
        return $this->belongsToMany(Suggestion::class);
    }
}
