<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable=[
        'type',
        'read',
        'sender_id',
        'receiver_id',
        'workout_id',
        'comment_id'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function markAsRead()
    {
        $this->read = true;
        $this->save();
    }


}
