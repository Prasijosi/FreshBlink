<!-- Footer -->
<footer class="bg-gray-300 pt-10 px-5 mt-16">
    <div class="flex flex-wrap justify-center lg:justify-around gap-6 mb-5">
        <div class="text-center lg:text-left">
            <img src="{{ asset('Image/logo2.png') }}" alt="FreshBlink Logo" class="w-36 mx-auto lg:mx-0">
        </div>

        <div class="min-w-[150px]">
            <h3 class="text-lg mb-2">Account</h3>
            <ul class="text-sm text-gray-800 space-y-2">
                <li><a href="#">Wishlist</a></li>
                <li><a href="#">Cart</a></li>
                <li><a href="#">Track Order</a></li>
                <li><a href="#">Shipping Details</a></li>
            </ul>
        </div>

        <div class="min-w-[150px]">
            <h3 class="text-lg mb-2">Useful Links</h3>
            <ul class="text-sm text-gray-800 space-y-2">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Hot Deals</a></li>
                <li><a href="#">Promotions</a></li>
                <li><a href="#">New Product</a></li>
            </ul>
        </div>

        <div class="min-w-[150px]">
            <h3 class="text-lg mb-2">Help Center</h3>
            <ul class="text-sm text-gray-800 space-y-2">
                <li><a href="#">Payment</a></li>
                <li><a href="#">Refund</a></li>
                <li><a href="#">Checkout</a></li>
                <li><a href="#">Q&amp;A</a></li>
                <li><a href="#">Shipping</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </div>

    <hr class="border-t border-gray-600 my-5">

    <div class="text-center text-sm text-gray-800 mb-3">
        <p>&copy; {{ date('Y') }}, All rights reserved</p>
    </div>
    <div class="text-center">
        <img src="{{ asset('Image/paypal.webp') }}" alt="PayPal" class="w-28 mx-auto">
    </div>
</footer> 