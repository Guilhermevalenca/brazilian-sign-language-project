<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMonitoring extends Model
{
    /** @use HasFactory<\Database\Factories\UserMonitoringFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'part_of_page',
        'timestamp',
        'token',
        'reference_id',
    ];
}
