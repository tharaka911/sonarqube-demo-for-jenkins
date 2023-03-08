<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balancing extends Model
{
    use HasFactory;

    protected $table = 'balancings';

    protected $fillable = [
        'balancing_type','status','stream_type'
    ];
}
