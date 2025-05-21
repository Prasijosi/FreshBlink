// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", () => {
    const removeButtons = document.querySelectorAll(".btn-remove");
    const addCartButtons = document.querySelectorAll(".btn-add-cart");
  
    removeButtons.forEach(button => {
      button.addEventListener("click", () => {
        const item = button.closest(".wishlist-item");
        item.remove();
      });
    });
  
    addCartButtons.forEach(button => {
      button.addEventListener("click", () => {
        alert("Item added to cart!");
        // Optional: remove from wishlist after adding to cart
        // button.closest(".wishlist-item").remove();
      });
    });
  });