<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'url', 'name', 'type', 'status', 'count', 'size','file_path','waiting_video_url'
    ];
}
