<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_completed',
        'profile_image',
        'location',
        'about_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }

    public function isFollowing(User $user)
    {
        return $this->follows()->where('follow_id', $user->id)->exists();
    }

    public function follow(User $user)
    {
        return $this->follows()->attach($user->id);
    }

    public function unfollow(User $user)
    {
        return $this->follows()->detach($user->id);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function hasLiked(Workout $workout)
    {
        return $this->likes()->where('workout_id', $workout->id)->exists();
    }

    public function joins()
    {
        return $this->hasMany(Join::class);
    }

    public function hasJoined(Workout $workout)
    {
        return $this->joins()->where('workout_id', $workout->id)->exists();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }



}
