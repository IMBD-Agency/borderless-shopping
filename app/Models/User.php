<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function getFormattedLastLoginAtAttribute() {
        return $this->last_login_at ? $this->last_login_at->format('d M y | h:i a') : 'Never';
    }

    /**
     * Check if the user is active
     *
     * @return bool
     */
    public function isActive(): bool {
        return $this->status === 'active';
    }

    /**
     * Check if the user is inactive
     *
     * @return bool
     */
    public function isInactive(): bool {
        return $this->status === 'inactive';
    }

    /**
     * Get the order requests for the user
     */
    public function orderRequests() {
        return $this->hasMany(OrderRequest::class);
    }

    /**
     * Check if the user is a super admin
     *
     * @return bool
     */
    public function isSuperAdmin(): bool {
        return $this->role === 'super_admin';
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a customer
     *
     * @return bool
     */
    public function isCustomer(): bool {
        return $this->role === 'customer';
    }

    /**
     * Check if the user has admin privileges (super_admin or admin)
     *
     * @return bool
     */
    public function hasAdminPrivileges(): bool {
        return in_array($this->role, ['super_admin', 'admin']);
    }
}
