<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sign extends Model
{
    /** @use HasFactory<\Database\Factories\SignFactory> */
    use HasFactory;

    public function movesets(): HasOne
    {
        return $this->hasOne(Moveset::class);
    }

    public function examples(): HasMany
    {
        return $this->hasMany(Example::class);
    }

    public function descriptions(): HasOne
    {
        return $this->hasOne(Description::class);
    }
}
