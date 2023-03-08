<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoList extends Model
{
    protected $fillable = [
        'url', 'count', 'type', 'status', 'file_path'
    ];
}
