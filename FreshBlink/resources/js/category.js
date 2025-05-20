const products = [
    { name: "Fresh Lettuce", price: "Rs.199", rating: 4, image: "/Users/manjusha/Desktop/practice/images/Lettuce.jpg", isFavorited: false },
    { name: "Red Apples", price: "Rs.349", rating: 5, image: "/Users/manjusha/Desktop/practice/images/apple.jpg", isFavorited: false },
    { name: "Bananas", price: "Rs.299", rating: 4, image: "/Users/manjusha/Desktop/practice/images/banana.png", isFavorited: false },
    { name: "Fresh Fish", price: "Rs.999", rating: 5, image: "/Users/manjusha/Desktop/practice/images/fish.jpg", isFavorited: false },
    { name: "Bakery Bread", price: "Rs.139", rating: 4, image: "/Users/manjusha/Desktop/practice/images/Brownbread.jpg", isFavorited: false },
    { name: "Tomatoes", price: "Rs.129", rating: 3, image: "/Users/manjusha/Desktop/practice/images/tomato.jpeg", isFavorited: false },
    { name: "Chicken Breast", price: "Rs.649", rating: 5, image: "/Users/manjusha/Desktop/practice/images/chickenbreast.png", isFavorited: false },
    { name: "Cheese Block", price: "Rs.599", rating: 4, image: "/Users/manjusha/Desktop/practice/images/cheese.jpg", isFavorited: false }
  ];
  
  const grid = document.getElementById("grid");
  const slides = document.getElementById("slides");
  let current = 0;
  
  function productCard(product, index) {
    const stars = Array.from({ length: 5 }).map((_, i) =>
      i < product.rating
        ? `<span class="cursor-pointer text-base" data-index="${index}" data-star="${i + 1}">★</span>`
        : `<span class="cursor-pointer text-base" data-index="${index}" data-star="${i + 1}">☆</span>`
    ).join("");
  
    return `
      <div class="bg-white border border-gray-300 rounded-md text-center transition-transform hover:scale-105 p-[0.75rem]">
        <div class="w-full h-[8rem] bg-gray-300 mb-[0.5rem] overflow-hidden rounded">
          <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover" />
        </div>
        <div class="text-sm font-semibold mb-[0.25rem]">${product.name}</div>
        <div class="text-yellow-400 mb-[0.25rem] text-base rating" data-index="${index}">
          ${stars}
        </div>
        <div class="font-bold mb-[0.25rem]">${product.price}</div>
        <div class="flex justify-center items-center gap-[0.5rem]">
          <span class="material-icons ${product.isFavorited ? 'text-red-500' : 'text-gray-600'} text-[1rem] cursor-pointer favorite-btn" data-index="${index}">
            ${product.isFavorited ? "favorite" : "favorite_border"}
          </span>
          <button class="border border-gray-300 px-[0.75rem] py-[0.25rem] text-xs rounded hover:bg-gray-100">
            Buy
          </button>
        </div>
      </div>
    `;
  }
  
  function renderGrid() {
    grid.innerHTML = "";
    products.forEach((p, i) => {
      grid.innerHTML += productCard(p, i);
    });
  }
  
  function renderSlider() {
    slides.innerHTML = "";
    products.forEach((p, i) => {
      slides.innerHTML += `
        <div class="min-w-full flex-shrink-0 p-[0.5rem]">
          ${productCard(p, i)}
        </div>
      `;
    });
    updateSliderPosition();
  }
  
  function updateSliderPosition() {
    const offset = -current * 100;
    slides.style.transform = `translateX(${offset}%)`;
  }
  
  function attachListeners() {
    document.querySelectorAll(".favorite-btn").forEach(btn => {
      btn.addEventListener("click", () => {
        const i = +btn.dataset.index;
        products[i].isFavorited = !products[i].isFavorited;
        refreshAll();
      });
    });
  
    document.querySelectorAll(".rating span").forEach(star => {
      star.addEventListener("click", () => {
        const i = +star.dataset.index;
        const val = +star.dataset.star;
        products[i].rating = val;
        refreshAll();
      });
    });
  }
  
  document.getElementById("nextBtn").onclick = () => {
    current = (current + 1) % products.length;
    updateSliderPosition();
  };
  
  document.getElementById("prevBtn").onclick = () => {
    current = (current - 1 + products.length) % products.length;
    updateSliderPosition();
  };
  
  function refreshAll() {
    renderGrid();
    renderSlider();
    attachListeners();
  }
  
  refreshAll();
  