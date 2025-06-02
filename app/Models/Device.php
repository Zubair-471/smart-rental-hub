<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Device extends Model
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
        'daily_rate',
        'image_url',
        'category_id',
        'status',
        'is_featured',
        'condition',
        'specifications',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'daily_rate' => 'decimal:2',
        'specifications' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        'average_rating',
        'total_reviews',
        'availability_status',
        'status_badge',
        'condition_badge',
        'is_available'
    ];

    /**
     * The validation rules for the model.
     *
     * @var array<string, string>
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'daily_rate' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:available,rented,maintenance',
        'condition' => 'required|in:new,good,fair,poor',
        'specifications' => 'nullable|array',
        'image_url' => 'nullable|string',
        'is_featured' => 'boolean',
    ];

    // Define the possible status values
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';

    // Define the possible condition values
    const CONDITION_NEW = 'new';
    const CONDITION_GOOD = 'good';
    const CONDITION_FAIR = 'fair';
    const CONDITION_POOR = 'poor';

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::deleting(function ($device) {
            if ($device->image_url) {
                Storage::delete($device->image_url);
            }
        });
    }

    /**
     * Get the category that owns the device.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the rentals for the device.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the reviews for the device.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the current rental if the device is rented.
     */
    public function currentRental()
    {
        return $this->rentals()
            ->where('status', 'active')
            ->whereNull('return_date')
            ->latest()
            ->first();
    }

    /**
     * Check if the device is available for rent.
     */
    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'success',
            self::STATUS_RENTED => 'warning',
            self::STATUS_MAINTENANCE => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get the availability status display.
     */
    public function getAvailabilityStatusAttribute(): string
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_RENTED => 'Currently Rented',
            self::STATUS_MAINTENANCE => 'Under Maintenance',
            default => 'Unknown'
        };
    }

    /**
     * Get the condition badge color.
     */
    public function getConditionBadgeAttribute(): string
    {
        return match($this->condition) {
            self::CONDITION_NEW => 'success',
            self::CONDITION_GOOD => 'info',
            self::CONDITION_FAIR => 'warning',
            self::CONDITION_POOR => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get whether the device is available.
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    /**
     * Calculate the average rating for this device.
     *
     * @return float
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get the average rating.
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->averageRating(), 1);
    }

    /**
     * Get the total number of reviews.
     */
    public function getTotalReviewsAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Scope a query to only include available devices.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    /**
     * Scope a query to only include featured devices.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function activeRental()
    {
        return $this->rentals()
            ->where('status', Rental::STATUS_ACTIVE)
            ->whereNull('return_date')
            ->first();
    }

    public function isRented()
    {
        return $this->status === self::STATUS_RENTED;
    }

    public function isInMaintenance()
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    public function isAvailableForDates($startDate, $endDate)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $conflictingRentals = $this->rentals()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->whereIn('status', [Rental::STATUS_PENDING, Rental::STATUS_ACTIVE])
            ->count();

        return $conflictingRentals === 0;
    }

    public function markAsRented()
    {
        $this->status = self::STATUS_RENTED;
        $this->save();
    }

    public function markAsAvailable()
    {
        $this->status = self::STATUS_AVAILABLE;
        $this->save();
    }

    public function markAsInMaintenance()
    {
        $this->status = self::STATUS_MAINTENANCE;
        $this->save();
    }
}
