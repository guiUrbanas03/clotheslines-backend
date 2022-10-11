<?php

namespace App\Models;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'text'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function hearts()
    {
        return $this->morphMany(Heart::class, 'hearteable');
    }

    public function getResourceAttribute()
    {
        return new CommentResource($this);
    }
}
