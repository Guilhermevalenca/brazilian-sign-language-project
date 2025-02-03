<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moveset extends Model
{
    /** @use HasFactory<\Database\Factories\MovesetFactory> */
    use HasFactory;

    protected $primaryKey = 'sign_id';
}
