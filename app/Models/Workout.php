<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'location',
        'date' => 'date',
        'time',
        'duration',
        'capacity',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function joins()
    {
        return $this->hasMany(Join::class);
    }
}
