<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot() {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the FAQs for the category.
     */
    public function faqs() {
        return $this->hasMany(Faq::class);
    }

    /**
     * Scope to get active categories
     */
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by order and name
     */
    public function scopeOrdered($query) {
        return $query->orderBy('order')->orderBy('name');
    }
}

