<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Description extends Model
{
    /** @use HasFactory<\Database\Factories\DescriptionFactory> */
    use HasFactory;

    protected $primaryKey = 'sign_id';

    protected $fillable = [
        'text',
        'display',
        'sign_id',
    ];

    public function sign(): HasOne
    {
        return $this->hasOne(Sign::class);
    }
}
