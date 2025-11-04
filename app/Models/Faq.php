<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the FAQ.
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to get active FAQs
     */
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by category and order
     */
    public function scopeOrdered($query) {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Get category name (from relationship or fallback to old category field)
     */
    public function getCategoryNameAttribute() {
        return $this->category ? $this->category->name : $this->category;
    }
}

