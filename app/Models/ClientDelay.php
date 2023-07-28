<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDelay extends Model
{
    use HasFactory;
    protected $table = 'client_delays';
    protected $fillable = [
        'pm_id', 'project_id', 'pm_text', 'admin_text', 'status', 'approved_by', 'extra_time', 'pm_file'
    ];

    protected $casts = [
        'pm_file' => 'array'
    ];
}
