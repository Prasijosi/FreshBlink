const products = Array.from({ length: 12 }).map((_, i) => ({
    name: `Product Name`,
    price: '8.99$',
    rating: 3 + (i % 2),
  }));
  
  const grid = document.getElementById('grid');
  
  products.forEach(product => {
    grid.innerHTML += `
      <div class="product-card">
        <div class="product-image">
          <img src="https://via.placeholder.com/150" alt="Product Image" />
        </div>
        <div class="product-name">${product.name}</div>
        <div class="product-rating">
          ${'★'.repeat(product.rating)}${'☆'.repeat(5 - product.rating)}
        </div>
        <div class="product-price">${product.price}</div>
        <div class="product-actions">
          <span class="material-icons">favorite_border</span>
          <button>Buy</button>
        </div>
      </div>
    `;
  });