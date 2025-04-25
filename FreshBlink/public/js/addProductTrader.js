document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".add-product-form");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent actual form submission for testing
  
      const minOrder = parseInt(document.getElementById("minOrder").value);
      const maxOrder = parseInt(document.getElementById("maxOrder").value);
      const quantity = parseInt(document.getElementById("quantity").value);
  
      if (minOrder > maxOrder) {
        alert("Minimum order cannot be greater than maximum order.");
        return;
      }
  
      if (quantity < maxOrder) {
        alert("Quantity should be greater than or equal to maximum order.");
        return;
      }
  
      alert("Product submitted successfully!");
      form.reset(); // Optional: Clear form after submission
    });
  });
  