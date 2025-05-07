<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organic Store</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: white;
      color: #1a1a1a;
      padding: 0 96px;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 48px;
    }

    nav {
      grid-column: 1 / -1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 0;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    nav .left,
    nav .right {
      display: flex;
      gap: 16px;
      align-items: center;
    }

    nav .browse-btn {
      background-color: #22c55e;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    nav a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }

    nav a.active {
      color: #15803d;
      font-weight: bold;
    }

    .hero {
      grid-column: 1 / -1;
      background-color: #d1fae5;
      padding: 48px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .hero img {
      max-width: 50%;
      height: 300px;
      object-fit: cover;
      border-radius: 12px;
    }

    .hero-text {
      max-width: 50%;
    }

    .hero-text h1 {
      font-size: 36px;
      font-weight: bold;
    }

    .promo {
      grid-column: 1 / -1;
      display: flex;
      gap: 48px;
      padding: 32px 0;
    }

    .promo-card {
      flex: 1;
      padding: 24px;
      border-radius: 12px;
    }

    .promo-card.blue {
      background-color: #e0f2fe;
    }

    .promo-card.yellow {
      background-color: #fef9c3;
    }

    .promo-card.pink {
      background-color: #fce7f3;
    }

    .promo-card button {
      background-color: #f97316;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      margin-top: 12px;
    }

    .promo-card img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .categories {
      grid-column: 1 / -1;
      padding: 32px 0;
    }

    .categories h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 24px;
    }

    .category-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 48px;
    }

    .category-box {
      background-color: #f3f4f6;
      border-radius: 12px;
      text-align: center;
      padding: 16px;
      transition: transform 0.3s ease;
    }

    .category-box:hover {
      transform: translateY(-5px);
    }

    .category-box img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .category-box p {
      font-weight: bold;
    }

    .products, .deals {
      grid-column: 1 / -1;
      margin: 48px 0;
    }

    .products h2, .deals h2 {
      font-size: 22px;
      margin-bottom: 24px;
    }

    .product-grid, .deal-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 24px;
    }

    .product-card, .deal-card {
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 16px;
      text-align: center;
    }

    .product-card img, .deal-card img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .product-card button, .deal-card button {
      background-color: #ef4444;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 8px;
    }

    .price-old {
      text-decoration: line-through;
      color: #9ca3af;
      font-size: 14px;
      margin-left: 8px;
    }
  </style>
</head>

<body>
  <div class="container">
    <nav>
      <div class="left">
        <button class="browse-btn"> Browse All Categories</button>
        <a href="#">🔥 Hot Deals</a>
      </div>
      <div class="right">
        <a href="#" class="active">Home</a>
        <a href="#">Shop</a>
        <a href="#">About</a>
        <a href="#">Blog</a>
        <a href="#">Contact</a>
      </div>
    </nav>

    <section class="hero">
      <div class="hero-text">
        <p style="color: #15803d; font-weight: bold;">100% Organic</p>
        <h1>Start Shopping At Our Store</h1>
        <p style="margin-top: 8px; color: #4b5563;">Save up to 50% off on your first order</p>
      </div>
      <img src="{{ asset('images/vector.png') }}" alt="Fruits and Veggies">
    </section>

    <div class="promo">
      <div class="promo-card blue">
        <h2>The best Organic Product Online</h2>
        <img src="{{ asset('images/greenvegie.png') }}">
        <button>Shop Now</button>
      </div>
      <div class="promo-card yellow">
        <h2>Everyday Fresh & Clean Product</h2>
        <img src="{{ asset('images/ginger.png') }}">
        <button>Shop Now</button>
      </div>
      <div class="promo-card pink">
        <h2>Make your Breakfast Healthy and Easy</h2>
        <img src="{{ asset('images/cake.png') }}">
        <button>Shop Now</button>
      </div>
    </div>

    <section class="categories">
      <h2>Featured Categories</h2>
      <div class="category-grid">
        <div class="category-box" style="background-color: #fef3c7;">
          <img src="{{ asset('images/bakery.jpg') }}">
          <p>Bakery</p>
        </div>
        <div class="category-box" style="background-color: #fecaca;">
          <img src="{{ asset('images/meat_steak.webp') }}">
          <p>Butchery</p>
        </div>
        <div class="category-box" style="background-color: #bbf7d0;">
          <img src="{{ asset('images/vegetable_vector.png') }}">
          <p>Greengrocer</p>
        </div>
        <div class="category-box" style="background-color: #fed7aa;">
          <img src="{{ asset('images/sandwitch.jpg') }}">
          <p>Delicatessen</p>
        </div>
        <div class="category-box" style="background-color: #bfdbfe;">
          <img src="{{ asset('images/fish.png') }}">
          <p>Fishmonger</p>
        </div>
      </div>
    </section>

    <section class="products">
      <h2>Popular Products</h2>
      <div class="product-grid">
        <div class="product-card">
          <img src="{{ asset('images/watermelom.png') }}" alt="Watermelon">
          <p>Vegetable<br>Watermelon 500gm</p>
          <p>4$ <span class="price-old">5.99$</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="product-card">
          <img src="{{ asset('images/bread.png') }}" alt="Bread">
          <p>Bakery<br>Brown Bread</p>
          <p>2.99$ <span class="price-old">3.99$</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="product-card">
          <img src="{{ asset('images/apple.png') }}" alt="Apple">
          <p>Fruits<br>Apple 1000 gm</p>
          <p>2.99$ <span class="price-old">3.99$</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="product-card">
          <img src="{{ asset('images/buff2.png') }}" alt="Meat">
          <p>Butchery<br>Buff Meat 200 gm</p>
          <p>4.99$ <span class="price-old">6.99$</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="product-card">
          <img src="{{ asset('images/cookies.png') }}" alt="Nut Bar">
          <p>Snacks<br>Nut Bar</p>
          <p>0.99$ <span class="price-old">1.99$</span></p>
          <button>🛒 Add</button>
        </div>
      </div>
    </section>

    <section class="deals">
      <h2>Deals Of The Day</h2>
      <div class="deal-grid">
        <div class="deal-card">
          <img src="{{ asset('images/1.png') }}" alt="Quinoa">
          <p>Seeds of Change Organic Quinoa, Brown, & Red Rice</p>
          <p>$32.85 <span class="price-old">$53.8</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="deal-card">
          <img src="{{ asset('images/2.png') }}" alt="Orange Meal">
          <p>Perdue Simply Smart Organics Gluten Free</p>
          <p>$24.85 <span class="price-old">$25.6</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="deal-card">
          <img src="{{ asset('images/piz.jpg') }}" alt="Mushroom">
          <p>Signature Wood-Fired Mushroom and Caramelized</p>
          <p>$12.85 <span class="price-old">$18.6</span></p>
          <button>🛒 Add</button>
        </div>
        <div class="deal-card">
          <img src="{{ asset('images/lime.webp') }}" alt="Lemonade">
          <p>Simply Lemonade with Raspberry Juice</p>
          <p>$15.85 <span class="price-old">$18.6</span></p>
          <button>🛒 Add</button>
        </div>
      </div>
    </section>
  </div>
</body>

</html>
