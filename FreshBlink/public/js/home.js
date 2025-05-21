
    // Store cart items in an array
    let cart = [];

    // Function to handle adding item to the cart
    function addToCart(event) {
        const card = event.target.closest('.product-card, .bg-white.rounded-xl'); // Support both card types
        const name = card.querySelector('p')?.textContent.trim();
        const priceText = card.querySelector('.price, .text-green-600.font-bold')?.textContent.replace('$', '').trim();
        const imageSrc = card.querySelector('img')?.getAttribute('src');

        if (!name || !priceText || !imageSrc) return;

        const item = {
            name: name,
            price: parseFloat(priceText),
            image: imageSrc
        };

        cart.push(item);
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${item.name} added to cart!`);
        // Optional: Update a visible cart count or render a cart dropdown
    }

    // Add event listeners to all .add-btn buttons
    document.addEventListener('DOMContentLoaded', () => {
        const addButtons = document.querySelectorAll('.add-btn, .bg-red-500');
        addButtons.forEach(button => {
            button.addEventListener('click', addToCart);
        });

        // Load previous cart from localStorage
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
        }
    });
