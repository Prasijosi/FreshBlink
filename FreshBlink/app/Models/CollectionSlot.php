<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionSlot extends Model
{
    use HasFactory;

    const MAX_ORDERS_PER_SLOT = 20;
    const MIN_ADVANCE_HOURS = 24;
    const COLLECTION_DAYS = ['Wednesday', 'Thursday', 'Friday'];
    const TIME_SLOTS = [
        '10:00-13:00',
        '13:00-16:00',
        '16:00-19:00'
    ];

    protected $fillable = [
        'order_id',
        'slot_date',
        'time_slot',
        'is_made_for',
        'required_slot',
    ];

    protected $casts = [
        'slot_date' => 'date',
        'is_made_for' => 'boolean',
        'required_slot' => 'boolean',
    ];

    /**
     * Get the order associated with the collection slot.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if a slot is available for the given date and time.
     */
    public static function isSlotAvailable($date, $timeSlot): bool
    {
        $dayOfWeek = $date->format('l');
        if (!in_array($dayOfWeek, self::COLLECTION_DAYS)) {
            return false;
        }

        $orderCount = self::where('slot_date', $date)
            ->where('time_slot', $timeSlot)
            ->count();

        return $orderCount < self::MAX_ORDERS_PER_SLOT;
    }

    /**
     * Get available slots for a given date.
     */
    public static function getAvailableSlots($date): array
    {
        $availableSlots = [];
        foreach (self::TIME_SLOTS as $slot) {
            if (self::isSlotAvailable($date, $slot)) {
                $availableSlots[] = $slot;
            }
        }
        return $availableSlots;
    }

    /**
     * Validate if a slot booking is valid.
     */
    public static function validateBooking($date, $timeSlot): bool
    {
        $now = now();
        $bookingTime = \Carbon\Carbon::parse($date . ' ' . explode('-', $timeSlot)[0]);
        
        // Check if booking is at least 24 hours in advance
        if ($bookingTime->diffInHours($now) < self::MIN_ADVANCE_HOURS) {
            return false;
        }

        // Check if slot is available
        return self::isSlotAvailable($date, $timeSlot);
    }
}
