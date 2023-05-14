<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'body',
        'status',
        'color_status',
        'status_log'
    ];

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['body'])) {
            $query->where('body', $filters['body']);
        }

        return $query;
    }

    public function addStatusLog($newStatus, $timestamp)
    {
        $statusLog = json_decode($this->status_log, true) ?? [];

        $statusLog[] = [
            'status' => $newStatus,
            'timestamp' => $timestamp,
        ];

        $this->status_log = $statusLog;
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
