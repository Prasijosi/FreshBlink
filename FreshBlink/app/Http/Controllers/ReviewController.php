<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($productId);
        
        // Check if user has purchased the product
        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereHas('orderProducts', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status', 'completed')
            ->exists();

        // Check if user has already reviewed the product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified_purchase' => $hasPurchased,
            'status' => $hasPurchased ? 'approved' : 'pending'
        ]);

        $message = $hasPurchased 
            ? 'Thank you for your review!' 
            : 'Thank you for your review. It will be visible after approval.';

        return back()->with('success', $message);
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, $id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $review->is_verified_purchase ? 'approved' : 'pending'
        ]);

        return back()->with('success', 'Review updated successfully');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }

    /**
     * Show reviews for a product.
     */
    public function index($productId)
    {
        $product = Product::with(['reviews' => function($query) {
            $query->approved()
                ->with('user')
                ->latest();
        }])->findOrFail($productId);

        $userReview = null;
        if (Auth::check()) {
            $userReview = Review::where('product_id', $productId)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('reviews.index', compact('product', 'userReview'));
    }

    /**
     * Show review form.
     */
    public function create($productId)
    {
        $product = Product::findOrFail($productId);

        // Check if user has already reviewed the product
        if (Auth::check()) {
            $existingReview = Review::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($existingReview) {
                return redirect()->route('reviews.index', $productId)
                    ->with('error', 'You have already reviewed this product');
            }
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Show edit form for a review.
     */
    public function edit($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('reviews.edit', compact('review'));
    }
} 