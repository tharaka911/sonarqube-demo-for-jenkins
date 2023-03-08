<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DhBet extends Model
{
    protected $table = 'dh_bet';
    use HasFactory;
    protected $fillable = [
        'round', 'account_name', 'account_password','status'
    ];
}
