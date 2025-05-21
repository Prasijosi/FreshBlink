<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshBlink - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    @guest
    {{-- Show this if the user is NOT logged in --}}
    @include('components.navbar')
    @endguest

    @auth
    {{-- Show this if the user IS logged in --}}
    @include('userblade.loggedin')
    @endauth
    <!-- Secondary Navbar -->
    <header class="navbar">
        <button class="categories-btn">
            <img src="/images/Grid.png" alt="">
            Browse All Categories
        </button>
        <nav class="nav-links">
            <a href="home.html" class="active">Home</a>
            <a href="#">Shop</a>
            <a href="ContactUs.html">Contact</a>
        </nav>
    </header>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <p class="tagline">
                <span class="highlight">100%</span> Organic
            </p>
            <h1>Start Shopping At
                <br>Our Store
            </h1>
            <p class="subtext">Save up to 50% off on your first order</p>
        </div>
        <div class="hero-images">
            <!-- <img src="/images/1.png" alt="Meat" class="meat-image" /> -->
            <img src="/images/2.png" alt="Vegetables" class="vegetables">
        </div>
    </section>
    <!-- Product Promo Cards Section -->
    <section class="promo-section">
        <div class="promo-card card-blue">
            <div class="promo-content">
                <h3>The best Organic
                    <br>Product Online
                </h3>
                <a href="#" class="shop-now">Shop Now</a>
            </div>
            <img src="/images/greenvegie.png" alt="Vegetables" class="promo-image">
        </div>
        <div class="promo-card card-beige">
            <div class="promo-content">
                <h3>Everyday Fresh &
                    <br>Clean Product
                </h3>
                <a href="#" class="shop-now">Shop Now</a>
            </div>
            <img src="/images/ginger.png" alt="Ginger" class="promo-image">
        </div>
        <div class="promo-card card-pink">
            <div class="promo-content">
                <h3>Make your Breakfast
                    <br>Healthy and Easy
                </h3>
                <a href="#" class="shop-now">Shop Now</a>
            </div>
            <img src="/images/cake.png" alt="Cake" class="promo-image">
        </div>
    </section>
    <!-- Featured Categories -->
    <section class="featured-section">
        <h2 class="featured-heading">Featured Categories</h2>
        <div class="categories">
            <div class="category-box category-bakery">
                <img src="/images/bakery_vector.png" alt="Bakery">
                <p>Bakery</p>
            </div>
            <div class="category-box category-butchery">
                <img src="/images/meat_steak.webp" alt="Butchery">
                <p>Butchery</p>
            </div>
            <div class="category-box category-greengrocer">
                <img src="/images/vegetable_vector.png" alt="Greengrocer">
                <p>Greengrocer</p>
            </div>
            <div class="category-box category-delicatessen">
                <img src="/images/vector.png" alt="Delicatessen">
                <p>Delicatessen</p>
            </div>
            <div class="category-box category-fishmonger">
                <img src="/images/seer_fish.png" alt="Fishmonger">
                <p>Fishmonger</p>
            </div>
        </div>
    </section>
    <!-- Popular Products -->
    <section class="popular-products">
        <h2 class="featured-heading">Popular Products</h2>
        <div class="product-grid">
            <div class="product-card">
                <img src="/images/watermelom.png" alt="Watermelon">
                <p>Watermelon 500gm</p>
                <p class="price">$4
                    <span class="old-price">$5.99</span>
                </p>
                <button class="add-btn">Add</button>
            </div>
            <div class="product-card">
                <img src="/images/grainbread.png" alt="Brown Bread">
                <p>Brown Bread</p>
                <p class="price">$2.99
                    <span class="old-price">$3.99</span>
                </p>
                <button class="add-btn">Add</button>
            </div>
            <div class="product-card">
                <img src="/images/apple.png" alt="Apple">
                <p>Apple 1000gm</p>
                <p class="price">$2.99
                    <span class="old-price">$3.99</span>
                </p>
                <button class="add-btn">Add</button>
            </div>
            <div class="product-card">
                <img src="/images/buff2.png" alt="Buff Meat">
                <p>Buff Meat 200gm</p>
                <p class="price">$4.99
                    <span class="old-price">$6.99</span>
                </p>
                <button class="add-btn">Add</button>
            </div>
            <div class="product-card">
                <img src="/images/snacks-PL_mob.png" alt="Nut Bar">
                <p>Nut Bar</p>
                <p class="price">$0.99
                    <span class="old-price">$1.99</span>
                </p>
                <button class="add-btn">Add</button>
            </div>
        </div>
    </section>
    <!-- Footer -->

    <section class="px-8 py-12 bg-white">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Deals Of The Day</h2>
            <a href="#" class="text-sm text-gray-500 hover:text-green-600">All Deals →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Deal Card -->
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="/images/redrice.jpg" alt="Seeds of Change Organic Quinoa" class="rounded-t-xl w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-800 leading-snug">
                        Seeds of Change Organic Quinoa, Brown, & Red Rice
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">By
                        <span class="text-green-600 font-medium">NestFood</span>
                    </p>
                    <div class="flex items-center text-sm mt-2 text-yellow-400">
                        ★★★★☆
                        <span class="text-gray-400 ml-1 text-xs">(4.0)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <span class="text-green-600 font-bold text-lg">$32.85</span>
                            <span class="text-gray-400 line-through text-sm ml-1">$33.8</span>
                        </div>
                        <button class="bg-red-500 text-white px-4 py-1 rounded text-sm">Add</button>
                    </div>
                </div>
            </div>
            <!-- Deal 2 -->
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="/images/lemon.jpg" alt="Perdue Simply Smart" class="rounded-t-xl w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-800 leading-snug">
                        Perdue Simply Smart Organics Gluten Free
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">By
                        <span class="text-green-600 font-medium">Old El Paso</span>
                    </p>
                    <div class="flex items-center text-sm mt-2 text-yellow-400">
                        ★★★★☆
                        <span class="text-gray-400 ml-1 text-xs">(4.0)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <span class="text-green-600 font-bold text-lg">$24.85</span>
                            <span class="text-gray-400 line-through text-sm ml-1">$26.8</span>
                        </div>
                        <button class="bg-red-500 text-white px-4 py-1 rounded text-sm">Add</button>
                    </div>
                </div>
            </div>
            <!-- Deal 3 -->
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                <img src="/images/pea.jpg" alt="Signature Wood-Fired Mushroom" class="rounded-t-xl w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-800 leading-snug">
                        Signature Wood-Fired Mushroom and Caramelized
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">By
                        <span class="text-green-600 font-medium">Progresso</span>
                    </p>
                    <div class="flex items-center text-sm mt-2 text-yellow-400">
                        ★★★☆☆
                        <span class="text-gray-400 ml-1 text-xs">(3.0)</span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div>
                            <span class="text-green-600 font-bold text-lg">$12.85</span>
                            <span class="text-gray-400 line-through text-sm ml-1">$13.8</span>
                        </div>
                        <button class="bg-red-500 text-white px-4 py-1 rounded text-sm">Add</button>
                    </div>
                </div>


</body>

</html>