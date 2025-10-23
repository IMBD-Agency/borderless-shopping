<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = [
        'order_request_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'float'
    ];

    public function orderRequest() {
        return $this->belongsTo(OrderRequest::class);
    }
}
