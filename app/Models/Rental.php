<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'start_date',
        'end_date',
        'total_cost',
        'daily_price',
        'deposit_amount',
        'status',
        'return_date',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'return_date' => 'datetime',
        'total_cost' => 'decimal:2',
        'daily_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function calculateTotalCost()
    {
        $days = $this->start_date->diffInDays($this->end_date) + 1; // Including both start and end days
        $this->daily_price = $this->device->daily_rate;
        $this->total_cost = $days * $this->daily_price;
        return $this->total_cost;
    }

    public function setDepositAmount()
    {
        // Set deposit amount as 50% of total cost or minimum $50, whichever is higher
        $this->deposit_amount = max($this->total_cost * 0.5, 50.00);
        return $this->deposit_amount;
    }

    public function markAsActive()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }

    public function markAsCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
        $this->return_date = now();
        $this->save();
    }

    public function markAsCancelled()
    {
        $this->status = self::STATUS_CANCELLED;
        $this->save();
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
