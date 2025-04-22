const products = Array.from({ length: 12 }).map((_, i) => ({
    name: `Product Name`,
    price: '8.99$',
    rating: 3 + (i % 2),
  }));
  
  const grid = document.getElementById('grid');
  
  products.forEach((product, index) => {
    const card = document.createElement('div');
    card.classList.add('product-card');
  
    card.innerHTML = `
      <div class="product-image">
        <img src="https://via.placeholder.com/150" alt="Product Image" />
      </div>
      <div class="product-name">${product.name}</div>
      <div class="product-rating" data-index="${index}">
        ${[...Array(5)].map((_, i) => 
          `<span class="material-icons">${i < product.rating ? 'star' : 'star_border'}</span>`
        ).join('')}
      </div>
      <div class="product-price">${product.price}</div>
      <div class="product-actions">
        <span class="material-icons fav-btn">favorite_border</span>
        <button>Buy</button>
      </div>
    `;
  
    grid.appendChild(card);
  });
  
  // Favorite toggle
  document.querySelectorAll('.fav-btn').forEach(icon => {
    icon.addEventListener('click', () => {
      icon.textContent = icon.textContent === 'favorite_border' ? 'favorite' : 'favorite_border';
      icon.classList.toggle('favorite');
    });
  });
  
  // Rating click interaction
  document.querySelectorAll('.product-rating').forEach(ratingContainer => {
    const stars = ratingContainer.querySelectorAll('span');
  
    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        stars.forEach((s, i) => {
          s.textContent = i <= index ? 'star' : 'star_border';
        });
      });
    });
  });