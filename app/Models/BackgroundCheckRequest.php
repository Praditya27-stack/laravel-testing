<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BackgroundCheckRequest extends Model
{
    protected $fillable = [
        'application_id',
        'referee_id',
        'token',
        'form_link',
        'sent_at',
        'link_expiry_date',
        'status',
        'send_method',
        'reminder_count',
        'last_reminder_at',
        'completed_at',
        'sent_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'link_expiry_date' => 'datetime',
        'last_reminder_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function referee()
    {
        return $this->belongsTo(ApplicationReferee::class, 'referee_id');
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function response()
    {
        return $this->hasOne(BackgroundCheckResponse::class, 'request_id');
    }

    public function followups()
    {
        return $this->hasMany(BackgroundCheckFollowup::class, 'request_id');
    }

    public static function generateToken()
    {
        return Str::random(64);
    }

    public function generateFormLink()
    {
        $this->token = self::generateToken();
        $this->form_link = route('bgc.form', ['token' => $this->token]);
        $this->save();

        return $this->form_link;
    }

    public function isExpired()
    {
        return $this->link_expiry_date < now();
    }

    public function canAccess()
    {
        return $this->status !== 'completed' && !$this->isExpired();
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function extendExpiry($days = 7)
    {
        $this->update([
            'link_expiry_date' => now()->addDays($days),
        ]);
    }

    public function sendReminder()
    {
        $this->increment('reminder_count');
        $this->update(['last_reminder_at' => now()]);
    }
}
