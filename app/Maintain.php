<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintain extends Model
{
    use HasFactory;

    protected $table = 'maintain_games';

    protected $fillable = [
        'game_type', 'type', 'maintain_status', 'maintain_type', 'status'
    ];
}
