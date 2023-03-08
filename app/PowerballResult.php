<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerballResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'type','round','result','normalball','powerball','status'
    ];

}
