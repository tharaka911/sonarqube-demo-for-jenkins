<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiveMinVideoList extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'url', 'count', 'type', 'status', 'file_path'
    ];
}
