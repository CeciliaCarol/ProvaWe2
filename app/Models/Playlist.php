<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Song;

class Playlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The songs that belong to the playlist.
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    /**
     * The user that owns the playlist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
