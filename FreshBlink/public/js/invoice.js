// Run after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {

    // ========== Hardcoded Product Data ==========
    // Example product data (name, quantity, price per unit)
    const products = [
      { name: "Product A", quantity: 2, price: 20 },
      { name: "Product B", quantity: 4, price: 20 },
      { name: "Product C", quantity: 1, price: 60 }
    ];
  
    // Select elements needed for invoice manipulation
    const tableBody = document.querySelector(".invoice-table tbody");
    const totalTop = document.getElementById("invoice-total");
    const totalBottom = document.getElementById("invoice-total-bottom");
  
    let totalAmount = 0;
  
    // Loop through each product and create a row in the invoice table
    products.forEach(product => {
      const amount = product.quantity * product.price;  // Calculate total amount for this product
      totalAmount += amount;  // Add to overall total
  
      // Create a table row and fill in product details
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${product.name}</td>
        <td>${product.quantity}</td>
        <td>$${product.price.toFixed(2)}</td>
        <td>$${amount.toFixed(2)}</td>
      `;
      tableBody.appendChild(row);  // Append row to table
    });
  
    // Display total amount in both top and bottom sections
    totalTop.textContent = totalAmount.toFixed(2);
    totalBottom.textContent = totalAmount.toFixed(2);
  
    // ========== Search Button ==========
    const searchBtn = document.querySelector('.search-box button');
    const searchInput = document.querySelector('.search-box input');
    if (searchBtn && searchInput) {
      // Alert the search term or warn if empty
      searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        alert(query ? `Searching for: "${query}"` : "Please enter a search term.");
      });
    }
  
    // ========== Login Button ==========
    const loginBtn = document.querySelector('.login-btn');
    if (loginBtn) {
      // Redirect to login page on click
      loginBtn.addEventListener('click', () => {
        window.location.href = 'login.html';
      });
    }
  
    // ========== Download Invoice Button ==========
    const downloadBtn = document.querySelector('.download-btn');
    if (downloadBtn) {
      // Print the invoice when clicked
      downloadBtn.addEventListener('click', () => {
        window.print();
      });
    }
  
    // ========== Saved Button ==========
    const savedBtn = document.querySelector('.nav-actions a:nth-child(1)');
    if (savedBtn) {
      // Redirect to saved items page
      savedBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'saved.html';
      });
    }
  
    // ========== Cart Button ==========
    const cartBtn = document.querySelector('.nav-actions a:nth-child(2)');
    if (cartBtn) {
      // Redirect to cart page
      cartBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'cart.html';
      });
    }
  
    // ========== Register Button ==========
    const registerBtn = document.querySelector('.nav-actions a:nth-child(3)');
    if (registerBtn) {
      // Redirect to register page
      registerBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'register.html';
      });
    }
  });
  