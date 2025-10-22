<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiredExportLog extends Model
{
    protected $fillable = [
        'export_type',
        'file_path',
        'date_from',
        'date_to',
        'total_records',
        'exported_fields',
        'exported_by',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'exported_fields' => 'array',
    ];

    public function exportedBy()
    {
        return $this->belongsTo(User::class, 'exported_by');
    }
}
