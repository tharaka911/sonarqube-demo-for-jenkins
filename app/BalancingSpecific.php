<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalancingSpecific extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_time','result','finish_time'
    ];
}
