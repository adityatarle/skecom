@include('layout.header')

<style>
    /* Modern Order Details Styles */
    .order-details-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .order-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .order-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .order-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .order-date {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }
    
    .status-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .status-badge {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .status-pending {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #856404;
    }
    
    .status-processing {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }
    
    .status-shipped {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }
    
    .status-delivered {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .status-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .status-cancelled {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .order-progress {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-bottom: 2rem;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 3px;
        background: #e9ecef;
        transform: translateY(-50%);
        z-index: 1;
    }
    
    .progress-step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        background: white;
        border: 3px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .step-active .step-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .step-completed .step-icon {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        color: white;
    }
    
    .step-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-align: center;
        max-width: 80px;
    }
    
    .step-active .step-label {
        color: #667eea;
    }
    
    .step-completed .step-label {
        color: #28a745;
    }
    
    .order-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    .order-items-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .product-item:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 1.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .product-details {
        flex: 1;
    }
    
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .product-meta {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .product-price {
        color: #667eea;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .order-summary-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        height: fit-content;
        position: sticky;
        top: 2rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.2rem;
        color: #333;
        padding-top: 1.5rem;
        margin-top: 1rem;
        border-top: 2px solid #667eea;
    }
    
    .summary-label {
        color: #6c757d;
    }
    
    .summary-value {
        font-weight: 600;
        color: #333;
    }
    
    .shipping-address-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .address-details {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }
    
    .address-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }
    
    .address-line {
        color: #6c757d;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .breadcrumb-custom {
        background: transparent;
        padding: 1rem 0;
        margin-bottom: 2rem;
    }
    
    .breadcrumb-custom .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .breadcrumb-custom .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .back-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .back-button:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .payment-info {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1rem;
    }
    
    .payment-method {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .payment-id {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .order-content {
            grid-template-columns: 1fr;
        }
        
        .progress-steps {
            flex-direction: column;
            gap: 1rem;
        }
        
        .progress-steps::before {
            display: none;
        }
        
        .order-number {
            font-size: 2rem;
        }
        
        .product-item {
            flex-direction: column;
            text-align: center;
        }
        
        .product-image {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
    
    /* Animation for status updates */
    @keyframes statusUpdate {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .status-update-animation {
        animation: statusUpdate 0.5s ease-in-out;
    }
</style>

<!-- Order Details Page -->
<div class="order-details-page">
    <div class="container order-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('orders.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to My Orders
            </a>
        </div>

        <!-- Order Header -->
        <div class="order-header-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="order-number">Order #{{ $order->id }}</h1>
                    <div class="order-date">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Placed on {{ $order->created_at->format('F j, Y') }} at {{ $order->created_at->format('g:i A') }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="status-container">
                        <div id="status-badge" class="status-badge status-{{ $order->status }}">
                            <i class="fas fa-circle"></i>
                            {{ ucfirst($order->status) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Progress -->
        <div class="order-progress">
            <h4 class="card-title">
                <i class="fas fa-route text-primary"></i>
                Order Progress
            </h4>
            <div class="progress-steps">
                <div class="progress-step step-completed">
                    <div class="step-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="step-label">Order Placed</div>
                </div>
                <div class="progress-step {{ in_array($order->status, ['processing', 'shipped', 'delivered', 'completed']) ? 'step-completed' : ($order->status === 'pending' ? 'step-active' : '') }}">
                    <div class="step-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="step-label">Processing</div>
                </div>
                <div class="progress-step {{ in_array($order->status, ['shipped', 'delivered', 'completed']) ? 'step-completed' : ($order->status === 'shipped' ? 'step-active' : '') }}">
                    <div class="step-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="step-label">Shipped</div>
                </div>
                <div class="progress-step {{ in_array($order->status, ['delivered', 'completed']) ? 'step-completed' : '' }}">
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="step-label">Delivered</div>
                </div>
            </div>
        </div>

        <!-- Order Content -->
        <div class="order-content">
            <!-- Order Items -->
            <div class="order-items-card">
                <h3 class="card-title">
                    <i class="fas fa-box text-primary"></i>
                    Order Items
                </h3>
                
                @if(is_array($order->products) && count($order->products) > 0)
                    @foreach($order->products as $id => $product)
                        <div class="product-item">
                            @if(isset($product['image']))
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image">
                            @else
                                <div class="product-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                            <div class="product-details">
                                <div class="product-name">{{ $product['name'] ?? 'Unknown Product' }}</div>
                                <div class="product-meta">
                                    <i class="fas fa-hashtag me-1"></i>Quantity: {{ $product['quantity'] ?? 0 }}
                                </div>
                                <div class="product-price">
                                    ₹{{ number_format(($product['price'] ?? 0), 2) }} each
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="product-price">
                                    <strong>₹{{ number_format(($product['price'] ?? 0) * ($product['quantity'] ?? 0), 2) }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No items found in this order.</p>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="order-summary-card">
                <h3 class="card-title">
                    <i class="fas fa-receipt text-primary"></i>
                    Order Summary
                </h3>
                
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">₹{{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Shipping</span>
                    <span class="summary-value">Free</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">₹{{ number_format($order->total_price, 2) }}</span>
                </div>

                <!-- Payment Information -->
                <div class="payment-info">
                    <div class="payment-method">
                        <i class="fas fa-credit-card"></i>
                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                    </div>
                    @if($order->razorpay_payment_id)
                        <div class="payment-id">
                            Payment ID: {{ $order->razorpay_payment_id }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="shipping-address-card">
            <h3 class="card-title">
                <i class="fas fa-map-marker-alt text-primary"></i>
                Shipping Address
            </h3>
            <div class="address-details">
                <div class="address-name">{{ $order->first_name }} {{ $order->last_name }}</div>
                <div class="address-line">
                    <i class="fas fa-home"></i>
                    {{ $order->street_address }}
                </div>
                <div class="address-line">
                    <i class="fas fa-city"></i>
                    {{ $order->city }}, {{ $order->state }}
                </div>
                <div class="address-line">
                    <i class="fas fa-globe"></i>
                    {{ $order->country }}
                </div>
                <div class="address-line">
                    <i class="fas fa-phone"></i>
                    {{ $order->phone }}
                </div>
                <div class="address-line">
                    <i class="fas fa-envelope"></i>
                    {{ $order->email }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Real-time Status Update Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update order status
    function updateOrderStatus() {
        fetch(`/api/orders/{{ $order->id }}/status`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.status !== '{{ $order->status }}') {
                    // Update status badge
                    const statusBadge = document.getElementById('status-badge');
                    statusBadge.className = `status-badge status-${data.status}`;
                    statusBadge.innerHTML = `<i class="fas fa-circle"></i> ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}`;
                    statusBadge.classList.add('status-update-animation');
                    
                    // Update progress steps
                    updateProgressSteps(data.status);
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        statusBadge.classList.remove('status-update-animation');
                    }, 500);
                    
                    // Show notification
                    showNotification('Order status updated!', 'success');
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
            });
    }
    
    // Function to update progress steps
    function updateProgressSteps(status) {
        const steps = document.querySelectorAll('.progress-step');
        
        // Reset all steps
        steps.forEach(step => {
            step.classList.remove('step-active', 'step-completed');
        });
        
        // Mark completed steps based on status
        switch(status) {
            case 'pending':
                steps[0].classList.add('step-completed');
                steps[1].classList.add('step-active');
                break;
            case 'processing':
                steps[0].classList.add('step-completed');
                steps[1].classList.add('step-completed');
                steps[2].classList.add('step-active');
                break;
            case 'shipped':
                steps[0].classList.add('step-completed');
                steps[1].classList.add('step-completed');
                steps[2].classList.add('step-completed');
                steps[3].classList.add('step-active');
                break;
            case 'delivered':
            case 'completed':
                steps.forEach(step => step.classList.add('step-completed'));
                break;
        }
    }
    
    // Function to show notification
    function showNotification(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // Check for status updates every 30 seconds
    setInterval(updateOrderStatus, 30000);
    
    // Also check when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateOrderStatus();
        }
    });
});
</script>

@include('layout.footer')