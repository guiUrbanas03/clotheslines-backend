<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'title',
        'description'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function hearts()
    {
        return $this->morphMany(Heart::class, 'hearteable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
