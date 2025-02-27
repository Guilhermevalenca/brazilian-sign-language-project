<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Example extends Model
{
    /** @use HasFactory<\Database\Factories\ExampleFactory> */
    use HasFactory;

    protected $primaryKey = 'sign_id';

    protected $fillable = [
        'description',
        'display',
        'sign_id'
    ];

    public function sign(): BelongsTo
    {
        return $this->belongsTo(Sign::class);
    }
}
