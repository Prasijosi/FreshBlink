<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // Points earned per dollar spent (1 point per $10)
    const POINTS_PER_DOLLAR = 0.1;
    
    // Points to discount conversion rate (100 points = $1 discount)
    const POINTS_TO_DISCOUNT_RATE = 0.01;
    
    // Minimum points required for redemption
    const MIN_POINTS_REDEMPTION = 500;

    /**
     * Display customer loyalty points and available discounts
     */
    public function showLoyaltyPoints()
    {
        $customer = Auth::user()->customer;
        $availableDiscount = $this->calculateAvailableDiscount($customer->loyalty_points);
        
        return view('customer.loyalty', compact('customer', 'availableDiscount'));
    }

    /**
     * Award loyalty points after order completion
     */
    public function awardPoints(Order $order)
    {
        $customer = $order->user->customer;
        
        // Calculate points based on order total
        $pointsEarned = floor($order->total_order * self::POINTS_PER_DOLLAR);
        
        // Update customer loyalty points
        $customer->loyalty_points += $pointsEarned;
        $customer->save();
        
        return $pointsEarned;
    }

    /**
     * Calculate available discount based on loyalty points
     */
    public function calculateAvailableDiscount($points)
    {
        if ($points < self::MIN_POINTS_REDEMPTION) {
            return 0;
        }
        
        return $points * self::POINTS_TO_DISCOUNT_RATE;
    }

    /**
     * Apply loyalty points discount to order
     */
    public function applyPointsDiscount(Request $request)
    {
        $request->validate([
            'points_to_redeem' => 'required|integer|min:' . self::MIN_POINTS_REDEMPTION,
        ]);

        $customer = Auth::user()->customer;
        $pointsToRedeem = $request->points_to_redeem;

        if ($pointsToRedeem > $customer->loyalty_points) {
            return back()->with('error', 'Not enough loyalty points available');
        }

        // Calculate discount amount
        $discountAmount = $this->calculateAvailableDiscount($pointsToRedeem);

        // Store the discount in session for checkout
        session(['loyalty_discount' => [
            'points_redeemed' => $pointsToRedeem,
            'discount_amount' => $discountAmount
        ]]);

        return back()->with('success', 'Loyalty points discount applied successfully');
    }

    /**
     * Process points redemption after successful order
     */
    public function processPointsRedemption(Order $order)
    {
        if (!session()->has('loyalty_discount')) {
            return;
        }

        $loyaltyDiscount = session('loyalty_discount');
        $customer = $order->user->customer;

        DB::transaction(function () use ($customer, $loyaltyDiscount, $order) {
            // Deduct redeemed points
            $customer->loyalty_points -= $loyaltyDiscount['points_redeemed'];
            $customer->save();

            // Record the redemption
            $order->update([
                'points_redeemed' => $loyaltyDiscount['points_redeemed'],
                'points_discount' => $loyaltyDiscount['discount_amount']
            ]);
        });

        // Clear the session
        session()->forget('loyalty_discount');
    }
} 