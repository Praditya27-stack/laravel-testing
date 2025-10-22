<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundCheckFollowup extends Model
{
    protected $fillable = [
        'request_id',
        'action_type',
        'notes',
        'performed_by',
        'performed_at',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function request()
    {
        return $this->belongsTo(BackgroundCheckRequest::class, 'request_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
