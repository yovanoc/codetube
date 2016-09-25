<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $fillable = [
        'user_id',
        'ip'
    ];

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeLatestByUser($query, User $user)
    {
        return $query->byUser($user)->orderBy('created_at', 'desc')->take(1);
    }

    public function scopeLatestByIp($query, $ip)
    {
        return $query->where('ip', $ip)->orderBy('created_at', 'desc')->take(1);
    }
}
