<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review - {{ $product->product_name }} - FreshBlink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            width: 30px;
            height: 30px;
            margin-right: 5px;
            color: #ddd;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #fbbf24;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center">
                    <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="w-20 h-20 object-cover rounded">
                    <div class="ml-4">
                        <h1 class="text-xl font-semibold">{{ $product->product_name }}</h1>
                        <p class="text-gray-600 text-sm">Write a review for this product</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf

                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5" class="fas fa-star"></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" class="fas fa-star"></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" class="fas fa-star"></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" class="fas fa-star"></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" class="fas fa-star"></label>
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Review</label>
                        <textarea
                            id="comment"
                            name="comment"
                            rows="4"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Share your thoughts about this product..."
                            required
                        >{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Minimum 10 characters, maximum 500 characters.</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('reviews.index', $product->id) }}" class="text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 