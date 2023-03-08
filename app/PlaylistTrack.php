<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id','video_id','status','track_id'
    ];
}
