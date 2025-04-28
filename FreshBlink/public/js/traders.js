// Different products with different names and images
const products = [
  {
    name: "Fresh Lettuce",
    price: "Rs.199",
    rating: 4,
    image: "images/Lettuce.jpg",
    isFavorited: false,
  },
  {
    name: "Red Apples",
    price: "Rs.349",
    rating: 5,
    image: "images/apple.jpg",
    isFavorited: false,
  },
  {
    name: "Bananas",
    price: "Rs.299",
    rating: 4,
    image: "images/banana.png",
    isFavorited: false,
  },
  {
    name: "Fresh Fish",
    price: "Rs.999",
    rating: 5,
    image: "images/fish.jpg",
    isFavorited: false,
  },
  {
    name: "Bakery Bread",
    price: "Rs.139",
    rating: 4,
    image: "images/Brownbread.jpg",
    isFavorited: false,
  },
  {
    name: "Tomatoes",
    price: "Rs.129",
    rating: 3,
    image: "images/tomato.jpeg",
    isFavorited: false,
  },
  {
    name: "Chicken Breast",
    price: "Rs.649",
    rating: 5,
    image: "images/chickenbreast.png",
    isFavorited: false,
  },
  {
    name: "Cheese Block",
    price: "Rs.599",
    rating: 4,
    image: "images/cheese.jpg",
    isFavorited: false,
  },
  {
    name: "Broccoli",
    price: "Rs.219",
    rating: 4,
    image: "images/broccoli.jpg",
    isFavorited: false,
  },
  {
    name: "Carrots",
    price: "Rs.189",
    rating: 3,
    image: "images/carrot.jpg",
    isFavorited: false,
  },
  {
    name: "Shrimps",
    price: "Rs.129",
    rating: 5,
    image: "images/shrimp.jpg",
    isFavorited: false,
  },
  {
    name: "Avocados",
    price: "Rs.429",
    rating: 4,
    image: "images/avocado.jpg",
    isFavorited: false,
  },
];

const grid = document.getElementById("grid");

function renderProducts() {
  grid.innerHTML = "";
  products.forEach((product, index) => {
    const stars = Array.from({ length: 5 })
      .map((_, i) =>
        i < product.rating
          ? `<span class="cursor-pointer" data-index="${index}" data-star="${i + 1}">★</span>`
          : `<span class="cursor-pointer" data-index="${index}" data-star="${i + 1}">☆</span>`
      )
      .join("");

    grid.innerHTML += `
      <div class="bg-white border border-gray-300 rounded-md p-3 text-center transition-transform hover:scale-105">
        <div class="w-full h-[8rem] bg-gray-300 mb-2 overflow-hidden">
          <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover" />
        </div>
        <div class="text-sm font-semibold mb-1">${product.name}</div>
        <div class="text-yellow-400 mb-1 text-base rating" data-index="${index}">
          ${stars}
        </div>
        <div class="font-bold mb-2">${product.price}</div>
        <div class="flex justify-center items-center gap-2">
          <span class="material-icons ${product.isFavorited ? 'text-red-500' : 'text-gray-600'} text-base cursor-pointer favorite-btn" data-index="${index}">
            ${product.isFavorited ? "favorite" : "favorite_border"}
          </span>
          <button class="border border-gray-300 px-3 py-1 text-xs rounded hover:bg-gray-100">Buy</button>
        </div>
      </div>
    `;
  });

  attachListeners();
}

function attachListeners() {
  // Favorite buttons
  document.querySelectorAll(".favorite-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const index = parseInt(btn.getAttribute("data-index"));
      products[index].isFavorited = !products[index].isFavorited;
      renderProducts();
    });
  });

  // Rating stars
  document.querySelectorAll(".rating").forEach((ratingDiv) => {
    ratingDiv.querySelectorAll("span").forEach((star) => {
      star.addEventListener("click", () => {
        const index = parseInt(star.getAttribute("data-index"));
        const starValue = parseInt(star.getAttribute("data-star"));
        products[index].rating = starValue;
        renderProducts();
      });
    });
  });
}

renderProducts();
