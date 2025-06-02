<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_admin',
    ];

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
        'is_admin' => 'boolean',
    ];

    /**
     * Get the rentals associated with the user.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Get the user's admin status.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        // If is_admin column exists, use it; otherwise, fall back to role
        return $this->attributes['is_admin'] ?? ($this->role === 'admin');
    }

    /**
     * Relationship with reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('slug', (array) $roles)->exists();
    }

    /**
     * Check if the user has all of the given roles.
     */
    public function hasAllRoles($roles)
    {
        $userRoles = $this->roles()->pluck('slug')->toArray();
        return empty(array_diff((array) $roles, $userRoles));
    }
}