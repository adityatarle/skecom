@include('layout.header')

<style>
    .orders-page {
        padding: 2rem 0;
        background-color: #f8f9fa;
    }
    
    .orders-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 2rem;
    }
    
    .orders-title {
        color: #333;
        font-size: 2rem;
        margin-bottom: 2rem;
        text-align: center;
        border-bottom: 2px solid #b89f7e;
        padding-bottom: 1rem;
    }
    
    .order-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: #fafafa;
        transition: box-shadow 0.3s ease;
    }
    
    .order-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .order-id {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    
    .order-date {
        color: #666;
        font-size: 0.9rem;
    }
    
    .order-total {
        font-size: 1.1rem;
        font-weight: 600;
        color: #b89f7e;
    }
    
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-paid {
        background: #d4edda;
        color: #155724;
    }
    
    .status-processing {
        background: #cce5ff;
        color: #004085;
    }
    
    .status-shipped {
        background: #e2e3e5;
        color: #383d41;
    }
    
    .status-delivered {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-completed {
        background: #d4edda;
        color: #155724;
    }
    
    .order-items {
        margin-bottom: 1rem;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 1rem;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .item-qty {
        color: #666;
        font-size: 0.9rem;
    }
    
    .order-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-view {
        background: #b89f7e;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }
    
    .btn-view:hover {
        background: #9b8465;
        color: white;
        text-decoration: none;
    }
    
    .btn-reorder {
        background: #28a745;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }
    
    .btn-reorder:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }
    
    .empty-orders {
        text-align: center;
        padding: 3rem;
        color: #666;
    }
    
    .empty-orders h3 {
        margin-bottom: 1rem;
        color: #999;
    }
    
    .shop-now-btn {
        background: #b89f7e;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
    }
    
    .shop-now-btn:hover {
        background: #9b8465;
        color: white;
        text-decoration: none;
    }
    
    .breadcrumbs_area {
        background: linear-gradient(135deg, #b89f7e 0%, #f0ebe7 100%);
        padding: 20px 0;
    }
    
    .jewel-title {
        font-size: 2rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .pagination .page-link {
        color: #b89f7e;
        border-color: #b89f7e;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #b89f7e;
        border-color: #b89f7e;
    }
    
    .pagination .page-link:hover {
        color: #9b8465;
        border-color: #9b8465;
    }
</style>

<!-- Breadcrumbs Area -->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h3 class="jewel-title">My Orders</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>></li>
                        <li>My Orders</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Page -->
<div class="orders-page">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="orders-container">
            <h1 class="orders-title">My Orders</h1>

            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-id">Order #{{ $order->id }}</div>
                                <div class="order-date">{{ $order->created_at->format('F j, Y g:i A') }}</div>
                            </div>
                            <div class="text-end">
                                <div class="order-total">₹{{ number_format($order->total_price, 2) }}</div>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="order-items">
                            @if(is_array($order->products))
                                @foreach(array_slice($order->products, 0, 3) as $id => $product)
                                    <div class="order-item">
                                        @if(isset($product['image']))
                                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="item-image">
                                        @else
                                            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: #999; font-size: 0.8rem;">
                                                No Image
                                            </div>
                                        @endif
                                        <div class="item-details">
                                            <div class="item-name">{{ $product['name'] ?? 'Unknown Product' }}</div>
                                            <div class="item-qty">Qty: {{ $product['quantity'] ?? 0 }} × ₹{{ number_format(($product['price'] ?? 0), 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($order->products) > 3)
                                    <div class="text-muted mt-2">
                                        <small>+ {{ count($order->products) - 3 }} more items</small>
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">No items found in this order.</p>
                            @endif
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-view">
                                <i class="fa fa-eye"></i> View Details
                            </a>
                            @if(in_array($order->status, ['completed', 'delivered']))
                                <a href="#" class="btn-reorder" onclick="reorderItems({{ $order->id }})">
                                    <i class="fa fa-refresh"></i> Reorder
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="pagination-wrapper">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <div class="empty-orders">
                    <h3>No Orders Found</h3>
                    <p>You haven't placed any orders yet. Start exploring our collection!</p>
                    <a href="{{ route('products') }}" class="shop-now-btn">
                        <i class="fa fa-shopping-bag"></i> Shop Now
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function reorderItems(orderId) {
    if(confirm('Are you sure you want to add all items from this order to your cart?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch(`/orders/${orderId}/reorder`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                alert(data.message);
                
                // Update cart count if you have it in header
                if(typeof updateCartCount === 'function' && data.cart_count) {
                    updateCartCount(data.cart_count);
                }
                
                // Redirect to cart if URL provided
                if(data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                alert(data.message || 'Error adding items to cart');
            }
        })
        .catch(error => {
            console.error('Reorder error:', error);
            alert('Error processing reorder request. Please try again.');
        });
    }
}
</script>

@include('layout.footer')
