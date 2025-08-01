@include('layout.header')

<style>
    /* Breadcrumbs (Reused from Previous Pages) */
.elegant-breadcrumbs {
    background: linear-gradient(135deg, #b89f7e 0%, #f0ebe7 100%);
    padding: 20px 0;
    border-bottom: 1px solid rgba(184, 159, 126, 0.2);
}
.jewel-title {
    font-size: 2.5rem;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.breadcrumb_content ul li {
    font-size: 0.9rem;
    color: #666;
}
.breadcrumb_content ul li a {
    text-decoration: none;
}
.breadcrumb_content ul li a:hover {
    text-decoration: underline;
}

/* Feedback */
.jewel-feedback {
    margin: 20px 0;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    display: none;
}
.jewel-feedback.success {
    background: rgba(184, 159, 126, 0.1);
    color: #b89f7e;
}
.jewel-feedback.error {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}
.jewel-alert {
    background: rgba(184, 159, 126, 0.1);
    border: 1px solid #b89f7e;
    color: #333;
    margin: 20px 0;
}
.alert-danger.jewel-alert {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid #dc3545;
}

/* Cart Area */
.jewel-cart {
    padding: 50px 0;
    background-color: #f0ebe7;
}
.jewel-table-wrapper {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 20px;
    display: block;
}
.cart-container.is-empty .jewel-table-wrapper,
.cart-container.is-empty .jewel-summary {
    display: none;
}

/* Table */
.jewel-table {
    width: 100%;
    border-collapse: collapse;
}
.jewel-table th {
    color: #333;
    background: rgba(184, 159, 126, 0.1);
    border-bottom: 2px solid #b89f7e;
    padding: 15px;
    text-align: center;
}
.jewel-table td {
    padding: 15px;
    color: #666;
    text-align: center;
    vertical-align: middle;
}
.jewel-row {
    border-bottom: 1px solid #f0ebe7;
    transition: background 0.3s ease;
}
.jewel-row:hover {
    background: rgba(184, 159, 126, 0.05);
}
.jewel-row.is-loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Remove Button */
.jewel-remove-btn {
    color: #b89f7e;
    font-size: 1.2rem;
    text-decoration: none;
    transition: color 0.3s ease;
}
.jewel-remove-btn:hover {
    color: #9b8465;
}

/* Image */
.jewel-img {
    max-width: 80px;
    border-radius: 5px;
    border: 1px solid #f0ebe7;
    transition: transform 0.3s ease;
}
.jewel-img:hover {
    transform: scale(1.05);
}
.jewel-no-img {
    display: inline-block;
    width: 80px;
    height: 80px;
    line-height: 80px;
    background: #f0ebe7;
    color: #666;
    border-radius: 5px;
    font-size: 0.9rem;
}

/* Product Link */
.jewel-link {
    color: #b89f7e;
    text-decoration: none;
    font-family: 'Lato', sans-serif;
    transition: color 0.3s ease;
}
.jewel-link:hover {
    color: #9b8465;
    text-decoration: underline;
}

/* Quantity Control */
.jewel-quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.jewel-qty-btn {
    display: inline-block;
    width: 25px;
    height: 25px;
    line-height: 25px;
    text-align: center;
    background: #b89f7e;
    color: #fff;
    border-radius: 50%;
    text-decoration: none;
    font-size: 1rem;
    transition: background 0.3s ease;
}
.jewel-qty-btn:hover {
    background: #9b8465;
}
.jewel-input {
    width: 60px;
    text-align: center;
    border: 1px solid #f0ebe7;
    border-radius: 5px;
    padding: 5px;
    color: #666;
    transition: border-color 0.3s ease;
}
.jewel-input:focus {
    border-color: #b89f7e;
    outline: none;
}

/* Submit Buttons */
.jewel-submit {
    margin-top: 20px;
    text-align: center;
}
.jewel-btn {
    display: inline-block;
    padding: 8px 20px;
    background: #b89f7e;
    color: #fff;
    border-radius: 5px;
    text-transform: uppercase;
    font-size: 0.9rem;
    border: none;
    transition: all 0.3s ease;
}
.jewel-btn:hover {
    background: #9b8465;
    color: #fff;
    box-shadow: 0 2px 10px rgba(184, 159, 126, 0.3);
}

/* Coupon and Totals */
.jewel-summary {
    margin-top: 30px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    padding: 20px;
}
.jewel-summary.is-loading {
    opacity: 0.6;
    pointer-events: none;
}
.jewel-heading {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 20px;
    position: relative;
}
.jewel-heading::after {
    content: '';
    width: 50px;
    height: 2px;
    background: #b89f7e;
    position: absolute;
    bottom: -10px;
    left: 0;
}
.jewel-coupon p,
.jewel-totals p {
    color: #666;
    margin-bottom: 10px;
}
.jewel-subtotal,
.jewel-total {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f0ebe7;
}
.jewel-total {
    font-weight: bold;
    color: #333;
}
.jewel-coupon-feedback {
    margin-top: 10px;
    font-size: 0.9em;
}

/* Empty Cart */
.jewel-empty-cart {
    text-align: center;
    padding: 40px;
    display: none;
}
.cart-container.is-empty .jewel-empty-cart {
    display: block;
}
.jewel-empty-text {
    color: #666;
    margin-bottom: 20px;
}

/* Checkout Button */
.jewel-checkout {
    margin-top: 20px;
    text-align: center;
}
</style>

<!-- Breadcrumbs Area -->
<div class="breadcrumbs_area elegant-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3 class="jewel-title">Your Jewellery Cart</h3>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>></li>
                        <li>Your Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Area -->
<div class="container">
    <div id="cart-feedback" class="jewel-feedback"></div>
    @if(session('success'))
    <div class="alert alert-success subtle-alert jewel-alert alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger subtle-alert jewel-alert alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<!-- Shopping Cart Area -->
<div class="shopping_cart_area jewel-cart">
    <div class="container cart-container {{ !empty($cart) && count($cart) > 0 ? '' : 'is-empty' }}">
        <div class="row">
            <div class="col-12">
                <!-- Cart Table Container -->
                <div id="cart-table-container" class="jewel-table-wrapper">
                    <div class="table_desc modern-cart jewel-table">
                        <div class="cart_page table-responsive">
                            <table class="jewelry-cart-table jewel-table">
                                <thead>
                                    <tr>
                                        <th class="product_remove">Remove</th>
                                        <th class="product_thumb1">Preview</th>
                                        <th class="product_name">Jewellery</th>
                                        <th class="product-price">Price</th>
                                        <th class="product_quantity">Qty</th>
                                        <th class="product_total">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-tbody">
                                    @php $total = 0; @endphp
                                    @forelse($cart as $id => $details)
                                    @php $subtotal = $details['quantity'] * $details['price']; $total += $subtotal; @endphp
                                    <tr class="cart-item-row jewel-row" id="cart-row-{{ $id }}" data-id="{{ $id }}">
                                        <td class="product_remove">
                                            <button type="button" class="remove-btn ajax-cart-remove jewel-remove-btn" data-id="{{ $id }}" title="Remove Item" style="background: none; border: none; color: #b89f7e; font-size: 1.2rem;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                        <td class="product_thumb1">
                                            <a href="{{ route('product.details', $id) }}">
                                                @if(isset($details['image']))
                                                @php $imagePath = asset($details['image']); @endphp
                                                <img src="{{ $imagePath }}" alt="{{ $details['name'] }}" class="cart-img jewel-img">
                                                @else
                                                <span class="no-img jewel-no-img">No Image</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product_name">
                                            <a href="{{ route('product.details', $id) }}" class="product-link jewel-link">{{ $details['name'] }}</a>
                                        </td>
                                        <td class="product-price">₹{{ number_format($details['price'], 2) }}</td>
                                        <td class="product_quantity">
                                            <div class="quantity-control jewel-quantity">
                                                <button type="button" class="qty-btn ajax-cart-decrease jewel-qty-btn" data-id="{{ $id }}" style="background: #b89f7e; color: #fff; border: none; border-radius: 50%; width: 25px; height: 25px;">-</button>
                                                <input min="1" max="100" value="{{ $details['quantity'] }}" type="number" class="qty-input cart-item-qty-input jewel-input" data-id="{{ $id }}" name="quantities[{{ $id }}]">
                                                <button type="button" class="qty-btn ajax-cart-increase jewel-qty-btn" data-id="{{ $id }}" style="background: #b89f7e; color: #fff; border: none; border-radius: 50%; width: 25px; height: 25px;">+</button>
                                            </div>
                                        </td>
                                        <td class="product_total cart-item-subtotal">₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="jewel-submit">
                            <a href="{{ route('products') }}" class="btn subtle-btn jewel-btn">Continue Shopping</a>
                        </div>
                    </div>
                </div>

                <!-- Coupon and Totals Area Container -->
                <div id="cart-summary-container" class="coupon_area elegant-coupon jewel-summary">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left jewel-coupon">
                                <h3 class="jewel-heading">Apply Coupon</h3>
                                <div class="coupon_inner">
                                    <p>Have a special code? Enter it here.</p>
                                    <input placeholder="Enter coupon code" type="text" class="coupon-input jewel-input w-50" id="coupon-code-input">
                                    <button type="button" class="btn jewel-btn">Apply</button>
                                    <div id="coupon-feedback" class="jewel-coupon-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 cart-summary-section">
                            <div class="coupon_code right jewel-totals">
                                <h3 class="jewel-heading">Cart Summary</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal jewel-subtotal">
                                        <p>Subtotal</p>
                                        <p class="cart_amount" id="cart-subtotal">₹{{ number_format($total ?? 0, 2) }}</p>
                                    </div>
                                    <div class="cart_subtotal jewel-subtotal">
                                        <p>Shipping</p>
                                        <p class="cart_amount" id="cart-shipping"><span>Flat Rate:</span> ₹0.00</p>
                                    </div>
                                    <div class="cart_subtotal total-row jewel-total">
                                        <p>Total</p>
                                        <p class="cart_amount" id="cart-grand-total">₹{{ number_format($total ?? 0, 2) }}</p>
                                    </div>
                                    <div class="checkout_btn jewel-checkout">
                                        <a href="{{ route('checkout') }}" class="btn jewel-btn">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty Cart Message -->
                <div id="empty-cart-message" class="jewel-empty-cart">
                    <p class="jewel-empty-text">Your cart is awaiting its treasures.</p>
                    <a href="{{ route('products') }}" class="btn subtle-btn jewel-btn">Explore Jewellery</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    const cartTbody = document.getElementById('cart-tbody');
    const cartFeedback = document.getElementById('cart-feedback');
    const cartContainer = document.querySelector('.cart-container');

    function showFeedback(message, isSuccess = true) {
        cartFeedback.textContent = message;
        cartFeedback.className = `jewel-feedback ${isSuccess ? 'success' : 'error'}`;
        cartFeedback.style.display = 'block';
        setTimeout(() => {
            cartFeedback.style.display = 'none';
        }, 4000);
    }

    function updateCartTotals(subtotal, total) {
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-grand-total');
        if (subtotalEl) subtotalEl.textContent = subtotal;
        if (totalEl) totalEl.textContent = total;
    }

    function checkCartEmptyState(isEmpty) {
        if (isEmpty) {
            cartContainer.classList.add('is-empty');
        } else {
            cartContainer.classList.remove('is-empty');
        }
    }

    function makeCartRequest(url, method, productId) {
        const formData = new FormData();
        if (method === 'POST') {
            if (url.includes('update')) {
                formData.append('product_id', productId);
                if (url.includes('increase')) {
                    formData.append('action', 'increase');
                } else if (url.includes('decrease')) {
                    formData.append('action', 'decrease');
                }
            }
        }
        
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }
        
        if (method === 'DELETE' && csrfToken) {
            formData.append('_method', 'DELETE');
        } else if (method === 'PATCH' && csrfToken) {
            formData.append('_method', 'PATCH');
        }

        return fetch(url, {
            method: method === 'DELETE' || method === 'PATCH' ? 'POST' : method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        });
    }

    if (cartTbody) {
        cartTbody.addEventListener('click', function(event) {
            const target = event.target;
            const button = target.closest('.ajax-cart-increase, .ajax-cart-decrease, .ajax-cart-remove');

            if (!button) return;

            event.preventDefault();

            const productId = button.dataset.id;
            const row = document.getElementById(`cart-row-${productId}`);
            const summary = document.querySelector('.cart-summary-section');

            if (!productId || !row) {
                console.error('Missing Product ID or Row Element');
                showFeedback('Could not update cart. Please try again.', false);
                return;
            }

            let url, method;
            
            if (button.classList.contains('ajax-cart-remove')) {
                url = `/cart/remove/${productId}`;
                method = 'DELETE';
            } else if (button.classList.contains('ajax-cart-increase')) {
                url = '/cart/update';
                method = 'POST';
            } else if (button.classList.contains('ajax-cart-decrease')) {
                url = '/cart/update';
                method = 'POST';
            }

            row.classList.add('is-loading');
            if (summary) summary.classList.add('is-loading');

            // Determine the action for update requests
            let action = '';
            if (button.classList.contains('ajax-cart-increase')) {
                action = 'increase';
            } else if (button.classList.contains('ajax-cart-decrease')) {
                action = 'decrease';
            }

            const requestData = new FormData();
            if (csrfToken) requestData.append('_token', csrfToken);
            
            if (method === 'DELETE') {
                requestData.append('_method', 'DELETE');
                method = 'POST'; // Laravel uses POST with _method override
            } else if (url.includes('update')) {
                requestData.append('product_id', productId);
                requestData.append('action', action);
            }

            fetch(url, {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: requestData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        throw new Error(errData.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showFeedback(data.message || 'Cart updated!', true);

                    if (button.classList.contains('ajax-cart-remove')) {
                        row.remove();
                        updateCartTotals(data.cartTotalFormatted, data.cartTotalFormatted);
                        checkCartEmptyState(data.cartIsEmpty);
                    } else {
                        const qtyInput = row.querySelector('.cart-item-qty-input');
                        const subtotalEl = row.querySelector('.cart-item-subtotal');

                        if (qtyInput) qtyInput.value = data.newQuantity;
                        if (subtotalEl) subtotalEl.textContent = data.newSubtotalFormatted;

                        updateCartTotals(data.cartTotalFormatted, data.cartTotalFormatted);
                    }
                } else {
                    showFeedback(data.message || 'Could not update item.', false);
                }
            })
            .catch(error => {
                console.error('Cart update error:', error);
                showFeedback(error.message || 'An error occurred. Please try refreshing the page.', false);
            })
            .finally(() => {
                row.classList.remove('is-loading');
                if (summary) summary.classList.remove('is-loading');
            });
        });
    }

    // Coupon functionality
    const couponButtons = document.querySelectorAll('.jewel-btn');
    const couponInput = document.getElementById('coupon-code-input');
    const couponFeedback = document.getElementById('coupon-feedback');

    couponButtons.forEach(button => {
        if (button.textContent.trim() === 'Apply') {
            button.addEventListener('click', function() {
                const code = couponInput?.value.trim();
                if (!code) {
                    if (couponFeedback) {
                        couponFeedback.textContent = 'Please enter a coupon code.';
                        couponFeedback.style.color = 'red';
                    }
                    return;
                }

                if (couponFeedback) {
                    couponFeedback.textContent = 'Applying...';
                    couponFeedback.style.color = '#666';
                }
                button.disabled = true;

                const formData = new FormData();
                formData.append('coupon_code', code);
                if (csrfToken) formData.append('_token', csrfToken);

                fetch('/apply-coupon', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (couponFeedback) {
                        if (data.success) {
                            couponFeedback.textContent = data.message || 'Coupon applied successfully!';
                            couponFeedback.style.color = 'green';
                            if (data.cartTotalFormatted) {
                                updateCartTotals(data.cartSubtotalFormatted || data.cartTotalFormatted, data.cartTotalFormatted);
                            }
                        } else {
                            couponFeedback.textContent = data.message || 'Invalid coupon code.';
                            couponFeedback.style.color = 'red';
                        }
                    }
                })
                .catch(error => {
                    console.error('Coupon error:', error);
                    if (couponFeedback) {
                        couponFeedback.textContent = 'Could not validate coupon.';
                        couponFeedback.style.color = 'red';
                    }
                })
                .finally(() => {
                    button.disabled = false;
                });
            });
        }
    });
});
</script>