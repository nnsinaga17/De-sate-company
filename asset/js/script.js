// ===========================
// FoodHub - JavaScript Functions
// ===========================

// Shopping Cart Array
let cart = [];

// Initialize Cart from Local Storage
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    updateCartCount();
});

// Add Item to Cart
function addToCart(itemName, price) {
    const item = {
        id: Date.now(),
        name: itemName,
        price: price,
        quantity: 1
    };

    // Check if item already exists in cart
    const existingItem = cart.find(cartItem => cartItem.name === itemName);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push(item);
    }

    saveCartToStorage();
    updateCartCount();
    showNotification(`${itemName} added to cart!`);
    
    // Optional: Open cart modal
    // new bootstrap.Modal(document.getElementById('cartModal')).show();
}

// Remove Item from Cart
function removeFromCart(itemId) {
    cart = cart.filter(item => item.id !== itemId);
    saveCartToStorage();
    updateCartCount();
    displayCart();
}

// Update Item Quantity
function updateQuantity(itemId, quantity) {
    const item = cart.find(cartItem => cartItem.id === itemId);
    if (item) {
        item.quantity = parseInt(quantity);
        if (item.quantity <= 0) {
            removeFromCart(itemId);
        } else {
            saveCartToStorage();
            displayCart();
        }
    }
}

// Display Cart
function displayCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    const cartTotalSpan = document.getElementById('cartTotal');

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-muted">Your cart is empty</p>';
        cartTotalSpan.textContent = '$0.00';
        return;
    }

    let html = '';
    let total = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div>
                        <span>Qty: </span>
                        <input type="number" value="${item.quantity}" min="1" 
                               onchange="updateQuantity(${item.id}, this.value)" 
                               style="width: 50px; padding: 5px;">
                    </div>
                </div>
                <div class="text-end">
                    <div class="cart-item-price">$${itemTotal.toFixed(2)}</div>
                    <button class="cart-item-remove" onclick="removeFromCart(${item.id})" title="Remove">✕</button>
                </div>
            </div>
        `;
    });

    cartItemsDiv.innerHTML = html;
    cartTotalSpan.textContent = `$${total.toFixed(2)}`;
}

// Update Cart Count Badge
function updateCartCount() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // If you add a cart icon with badge in navbar, update it here
    console.log('Cart items:', totalItems);
}

// Show Cart Modal
function showCart() {
    displayCart();
    new bootstrap.Modal(document.getElementById('cartModal')).show();
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    alert(`Order confirmed! Total: $${total.toFixed(2)}\nThank you for your purchase!`);
    
    // Clear cart
    cart = [];
    saveCartToStorage();
    updateCartCount();
    
    // Close modal
    bootstrap.Modal.getInstance(document.getElementById('cartModal')).hide();
    displayCart();
}

// Save Cart to Local Storage
function saveCartToStorage() {
    localStorage.setItem('foodhubCart', JSON.stringify(cart));
}

// Load Cart from Local Storage
function loadCartFromStorage() {
    const savedCart = localStorage.getItem('foodhubCart');
    if (savedCart) {
        try {
            cart = JSON.parse(savedCart);
        } catch (e) {
            cart = [];
        }
    }
}

// Handle Contact Form Submission
function handleFormSubmit(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Simple validation
    if (!name || !email || !message) {
        alert('Please fill out all fields!');
        return;
    }

    // Show success message
    showNotification('Message sent successfully! We will contact you soon.');

    // Reset form
    document.getElementById('contactForm').reset();

    // In a real application, you would send this data to a server
    console.log('Form Data:', { name, email, message });
}

// Smooth Scroll to Menu
function scrollToMenu() {
    document.getElementById('menu').scrollIntoView({ behavior: 'smooth' });
}

// Smooth Scroll to About
function scrollToAbout() {
    document.getElementById('about').scrollIntoView({ behavior: 'smooth' });
}

// Show Notification/Toast
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification-toast';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #FF9500 0%, #FFD700 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        font-weight: 500;
    `;

    document.body.appendChild(notification);

    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add Animation Styles Dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
`;
document.head.appendChild(style);

// Dark Mode Toggle (Optional)
function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
}

// Load Dark Mode Preference
function loadDarkModePreference() {
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
}

// Add Search Functionality
function searchMenu(query) {
    const cards = document.querySelectorAll('.menu-card');
    const lowerQuery = query.toLowerCase();

    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const text = card.querySelector('.card-text').textContent.toLowerCase();

        if (title.includes(lowerQuery) || text.includes(lowerQuery)) {
            card.parentElement.style.display = 'block';
            card.style.opacity = '1';
        } else {
            card.parentElement.style.display = 'none';
            card.style.opacity = '0.5';
        }
    });
}

// Filter Menu by Category (Future Enhancement)
function filterMenu(category) {
    console.log('Filtering by category:', category);
    // Implement category-based filtering
}

// Analytics - Track User Actions
function trackEvent(eventName, eventData) {
    console.log(`Event: ${eventName}`, eventData);
    // Send to analytics service if available
}

// Initialize page on load
window.addEventListener('load', function() {
    loadDarkModePreference();
    loadCartFromStorage();
    console.log('FoodHub website loaded successfully!');
});

// Handle Scroll Events
let scrollCount = 0;
window.addEventListener('scroll', function() {
    scrollCount++;
    if (scrollCount % 5 === 0) {
        // Lazy load or other optimizations
    }
});

// Utility: Format Currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Utility: Validate Email
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Performance: Debounce Function
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}

// Example usage of debounce for search
const debouncedSearch = debounce(searchMenu, 300);

// ===========================
// Admin Authentication Functions
// ===========================

// Admin Login Function
function adminLogin(username, password) {
    // Default admin credentials
    const adminUser = 'admin';
    const adminPass = '12345';

    if (username === adminUser && password === adminPass) {
        // Store session data
        sessionStorage.setItem('adminLoggedIn', 'true');
        sessionStorage.setItem('adminUser', username);
        localStorage.setItem('adminLastLogin', new Date().toISOString());
        return true;
    }
    return false;
}

// Check if Admin is Logged In
function isAdminLoggedIn() {
    return sessionStorage.getItem('adminLoggedIn') === 'true';
}

// Admin Logout Function
function adminLogout() {
    sessionStorage.removeItem('adminLoggedIn');
    sessionStorage.removeItem('adminUser');
    window.location.href = 'admin-login.html';
}
