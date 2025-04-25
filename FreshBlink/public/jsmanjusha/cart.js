// Listen to quantity changes
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', updateSubtotal);
  });
  
  function updateSubtotal() {
    let cartItems = document.querySelectorAll('.cart-item');
    let total = 0;
  
    cartItems.forEach(item => {
      const price = parseFloat(item.querySelector('.item-price').textContent.replace('Rs.', '').trim());
      const qty = parseInt(item.querySelector('.qty-input').value);
      const subtotal = price * qty;
      
      item.querySelector('.item-subtotal').textContent = 'Rs. ' + subtotal.toFixed(2);
      total += subtotal;
    });
  
    document.getElementById('cart-subtotal').textContent = 'Rs. ' + total.toFixed(2);
    document.getElementById('order-total').textContent = 'Rs. ' + total.toFixed(2);
  }
  
  // Clear Cart
  document.getElementById('clear-cart-btn').addEventListener('click', () => {
    document.querySelectorAll('.cart-item').forEach(item => item.remove());
    document.getElementById('cart-subtotal').textContent = 'Rs. 0';
    document.getElementById('order-total').textContent = 'Rs. 0';
  });
  
