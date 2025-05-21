document.addEventListener("DOMContentLoaded", () => {
    const customerTableBody = document.getElementById("customerTableBody");
  
    const customers = [
      {
        name: "Customer1",
        contact: "1234567890",
        address: "abc",
        email: "abc@1.com",
        orders: 5,
        points: "120",
        image: "images/Customer.jpg"
      },
      {
        name: "Customer2",
        contact: "2345678901",
        address: "pqr",
        email: "pqr@2.com",
        orders: 3,
        points: "90",
        image: "images/Customer.jpg"
      },
      {
        name: "Customer3",
        contact: "3456789012",
        address: "xyz",
        email: "xyz@3.com",
        orders: 7,
        points: "150",
        image: "images/Customer.jpg"
      },
      {
        name: "Customer4",
        contact: "4567890123",
        address: "mno",
        email: "mno@4.com",
        orders: 2,
        points: "60",
        image: "images/Customer.jpg"
      }
    ];
  
    customers.forEach((customer, index) => {
      const row = document.createElement("tr");
      row.className = "border-b";
  
      row.innerHTML = `
        <td class="p-3 flex flex-col items-center">
          <label class="cursor-pointer relative group">
            <img src="${customer.image}" alt="${customer.name}" class="w-12 h-12 rounded-full object-cover border border-gray-300" id="customer-img-${index}" />
            <input type="file" accept="image/*" class="hidden" id="file-input-${index}" />
            <span class="absolute inset-0 bg-black bg-opacity-30 rounded-full flex items-center justify-center text-xs text-white opacity-0 group-hover:opacity-100 transition">Edit</span>
          </label>
          <button class="bg-green-600 text-white px-3 py-1 mt-2 text-sm rounded toggle-detail">
            Detail Info ▼
          </button>
          <div class="hidden mt-2 text-sm text-gray-600 detail-content">
            Additional details about ${customer.name}
          </div>
        </td>
        <td class="p-3">${customer.name}</td>
        <td class="p-3">${customer.contact}</td>
        <td class="p-3">${customer.address}</td>
        <td class="p-3">${customer.email}</td>
        <td class="p-3">${customer.orders}</td>
        <td class="p-3">${customer.points}</td>
      `;
  
      customerTableBody.appendChild(row);
  
      const fileInput = document.getElementById(`file-input-${index}`);
      const image = document.getElementById(`customer-img-${index}`);
  
      image.addEventListener("click", () => fileInput.click());
  
      fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = e => {
            image.src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
    });
  
    // Toggle detail info
    document.querySelectorAll(".toggle-detail").forEach(button => {
      button.addEventListener("click", () => {
        const detail = button.nextElementSibling;
        detail.classList.toggle("hidden");
      });
    });
  
    // Slide Buttons
    const tableWrapper = document.getElementById("tableWrapper");
    const slideBtnRight = document.getElementById("slideBtn");
    const slideBtnLeft = document.getElementById("slideBtnLeft");
  
    slideBtnRight.addEventListener("click", () => {
      tableWrapper.scrollBy({ left: 200, behavior: "smooth" });
    });
  
    slideBtnLeft.addEventListener("click", () => {
      tableWrapper.scrollBy({ left: -200, behavior: "smooth" });
    });
  });
  