<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTimeline extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function orderRequest() {
        return $this->belongsTo(OrderRequest::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getStatusDisplayAttribute() {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function getActionByDisplayAttribute() {
        return match ($this->action_by) {
            'admin' => 'Admin',
            'system' => 'System',
            'user' => 'Customer',
            default => 'Unknown'
        };
    }
}
