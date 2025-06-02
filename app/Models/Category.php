<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'parent_id',
        'image_url',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        'full_path',
        'device_count'
    ];

    /**
     * The validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'parent_id' => 'nullable|exists:categories,id',
        'image_url' => 'nullable|string',
        'is_active' => 'boolean'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
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
     * Get the devices for the category.
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all devices including those in child categories.
     */
    public function allDevices()
    {
        return Device::whereIn('category_id', 
            $this->descendants()->pluck('id')->push($this->id)
        );
    }

    /**
     * Get all descendant categories.
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get the full category path.
     */
    public function getFullPathAttribute(): string
    {
        $path = collect([$this->name]);
        $category = $this;

        while ($category->parent) {
            $category = $category->parent;
            $path->prepend($category->name);
        }

        return $path->implode(' > ');
    }

    /**
     * Get the number of devices in this category.
     */
    public function getDeviceCountAttribute(): int
    {
        return $this->devices()->count();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include root categories.
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
