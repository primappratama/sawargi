<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model {
    protected $fillable = [
        'system', 'node_id', 'event_type',
        'severity', 'title', 'description',
    ];
}