<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if the role has any of the given permissions.
     */
    public function hasAnyPermission($permissions)
    {
        return !empty(array_intersect($permissions, $this->permissions ?? []));
    }

    /**
     * Check if the role has all of the given permissions.
     */
    public function hasAllPermissions($permissions)
    {
        return empty(array_diff($permissions, $this->permissions ?? []));
    }
}
