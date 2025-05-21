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
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check if user has purchased the product
        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereHas('orderProducts', function($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->where('status', 'completed')
            ->exists();

        // Check if user has already reviewed the product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
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
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $review->is_verified_purchase ? 'approved' : 'pending'
        ]);

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully');
    }

    /**
     * Show reviews for a product.
     */
    public function productReviews($product_id)
    {
        $product = Product::findOrFail($product_id);
        $reviews = $product->reviews()->with('user')->latest()->paginate(10);
        
        return view('reviews.product', compact('product', 'reviews'));
    }

    /**
     * Show reviews for the authenticated user.
     */
    public function index()
    {
        $reviews = Auth::user()->reviews()->with('product')->latest()->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show review form.
     */
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);

        // Check if user has already reviewed the product
        if (Auth::check()) {
            $existingReview = Review::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->first();

            if ($existingReview) {
                return redirect()->route('reviews.index')
                    ->with('error', 'You have already reviewed this product');
            }
        }

        return view('reviews.create', compact('product'));
    }

    /**
     * Show edit form for a review.
     */
    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }
} 