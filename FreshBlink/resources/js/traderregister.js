document.addEventListener("DOMContentLoaded", function () {
    // ================== Form Submission ==================
    const form = document.getElementById("trader-form");
  
    form.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const password = document.getElementById("password").value;
      const confirm = document.getElementById("confirm-password").value;
  
      if (password !== confirm) {
        alert("Passwords do not match!");
        return;
      }
  
      alert("Trader registered successfully!");
      form.reset();
    });
  
    // ================== Populate Trader Types ==================
    const traderTypes = [
      "Butchers",
      "Greengrocer",
      "Fishmonger",
      "Bakery",
      "Delicatessen"
    ];
  
    const traderSelect = document.getElementById("trader-type");
    const defaultOption = document.createElement("option");
    defaultOption.textContent = "Select a type";
    defaultOption.value = "";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    traderSelect.appendChild(defaultOption);
  
    traderTypes.forEach(type => {
      const option = document.createElement("option");
      option.value = type.toLowerCase();
      option.textContent = type;
      traderSelect.appendChild(option);
    });
  
    // ================== Navbar Button Actions ==================
    document.querySelector(".search-box button").addEventListener("click", () => {
      const searchValue = document.querySelector(".search-box input").value.trim();
      if (searchValue) {
        alert("You searched for: " + searchValue);
      } else {
        alert("Please enter a search term.");
      }
    });
  
    document.querySelectorAll(".nav-actions a").forEach(link => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const action = link.innerText.trim();
        alert(`"${action}" functionality will be implemented here.`);
      });
    });
  
    document.querySelector(".login-btn").addEventListener("click", () => {
      alert("Login button clicked. Redirect to login page.");
    });
  });
  