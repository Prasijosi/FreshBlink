<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - {{ $product->product_name }} - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center">
                    <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="w-24 h-24 object-cover rounded">
                    <div class="ml-6">
                        <h1 class="text-2xl font-semibold">{{ $product->product_name }}</h1>
                        <div class="flex items-center mt-2">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $product->reviews->avg('rating'))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">{{ number_format($product->reviews->avg('rating'), 1) }} ({{ $product->reviews->count() }} reviews)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Write Review Button -->
            @auth
                @if (!$userReview)
                <div class="mb-6">
                    <a href="{{ route('reviews.create', $product->id) }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200">
                        Write a Review
                    </a>
                </div>
                @endif
            @else
                <div class="mb-6 bg-blue-50 text-blue-700 px-6 py-4 rounded-md">
                    Please <a href="{{ route('login') }}" class="underline">login</a> to write a review.
                </div>
            @endauth

            <!-- Reviews List -->
            <div class="space-y-6">
                @forelse ($product->reviews as $review)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center">
                                <span class="font-medium">{{ $review->user->name }}</span>
                                @if ($review->is_verified_purchase)
                                <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Verified Purchase</span>
                                @endif
                            </div>
                            <div class="flex text-yellow-400 mt-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                            <p class="text-gray-400 text-sm mt-2">{{ $review->created_at->format('F j, Y') }}</p>
                        </div>
                        @if ($review->user_id === Auth::id())
                        <div class="flex space-x-2">
                            <a href="{{ route('reviews.edit', $review->id) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this review?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-gray-50 text-gray-600 text-center py-8 rounded-lg">
                    No reviews yet. Be the first to review this product!
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html> 