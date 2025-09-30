<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model {
    use HasFactory;
    protected $guarded = ['id'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->hasMany(OrderRequestProduct::class);
    }

    public function timelines() {
        return $this->hasMany(OrderTimeline::class)->orderBy('created_at', 'asc');
    }

    public function addTimelineEntry($status, $description = null, $actionBy = 'system', $userId = null, $metadata = null) {
        return $this->timelines()->create([
            'status' => $status,
            'description' => $description,
            'action_by' => $actionBy,
            'user_id' => $userId,
            'metadata' => $metadata
        ]);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function getTotalPaidAmountAttribute() {
        return $this->payments()->sum('amount');
    }

    public function getTotalPendingAmountAttribute() {
        return $this->total_amount - $this->total_paid_amount;
    }
}
