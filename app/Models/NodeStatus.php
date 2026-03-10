<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NodeStatus extends Model {
    protected $fillable = [
        'node_id', 'node_name', 'node_type',
        'is_online', 'last_seen', 'battery', 'rssi',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_seen' => 'datetime',
    ];
}