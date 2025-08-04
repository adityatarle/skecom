@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-1">
                                <i class="fas fa-receipt me-2"></i>Order Details
                            </h3>
                            <p class="mb-0 opacity-90">
                                Order #{{ $order->id }} - {{ $order->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Orders
                                </a>
                                <button class="btn btn-light btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Order Summary -->
                <div class="col-lg-8">
                    <div class="row g-4">
                        <!-- Order Information -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Order Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Order ID</label>
                                                <h5 class="mb-0">#{{ $order->id }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Status</label>
                                                <div>
                                                    @switch($order->status)
                                                        @case('pending')
                                                            <span class="badge bg-warning fs-6">
                                                                <i class="fas fa-clock me-1"></i>Pending
                                                            </span>
                                                            @break
                                                        @case('processing')
                                                            <span class="badge bg-info fs-6">
                                                                <i class="fas fa-cog me-1"></i>Processing
                                                            </span>
                                                            @break
                                                        @case('shipped')
                                                            <span class="badge bg-primary fs-6">
                                                                <i class="fas fa-shipping-fast me-1"></i>Shipped
                                                            </span>
                                                            @break
                                                        @case('delivered')
                                                            <span class="badge bg-info fs-6">
                                                                <i class="fas fa-truck me-1"></i>Delivered
                                                            </span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success fs-6">
                                                                <i class="fas fa-check me-1"></i>Completed
                                                            </span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="badge bg-danger fs-6">
                                                                <i class="fas fa-times me-1"></i>Cancelled
                                                            </span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary fs-6">{{ ucfirst($order->status) }}</span>
                                                    @endswitch
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Order Date</label>
                                                <div>{{ $order->created_at->format('F d, Y') }}</div>
                                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Payment Method</label>
                                                <div>
                                                    @if($order->payment_method === 'cash_on_delivery')
                                                        <i class="fas fa-money-bill me-1"></i>Cash on Delivery
                                                    @elseif($order->payment_method === 'razorpay')
                                                        <i class="fas fa-credit-card me-1"></i>Online Payment
                                                    @else
                                                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Total Amount</label>
                                                <h4 class="mb-0 text-success">₹{{ number_format($order->total_price, 2) }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-user me-2 text-success"></i>
                                        Customer Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Customer Name</label>
                                                <h6 class="mb-0">{{ $order->first_name }} {{ $order->last_name }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Email</label>
                                                <div>
                                                    <a href="mailto:{{ $order->email }}" class="text-decoration-none">
                                                        <i class="fas fa-envelope me-1"></i>{{ $order->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Phone</label>
                                                <div>
                                                    <a href="tel:{{ $order->phone }}" class="text-decoration-none">
                                                        <i class="fas fa-phone me-1"></i>{{ $order->phone }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Location</label>
                                                <div>{{ $order->city }}, {{ $order->state }}, {{ $order->country }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="info-item">
                                                <label class="fw-bold text-muted small">Shipping Address</label>
                                                <div class="bg-light p-3 rounded">
                                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                    {{ $order->street_address }}<br>
                                                    {{ $order->city }}, {{ $order->state }}<br>
                                                    {{ $order->country }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Actions & Status -->
                <div class="col-lg-4">
                    <div class="row g-4">
                        <!-- Status Update -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-edit me-2 text-warning"></i>
                                        Update Status
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bold">Order Status</label>
                                            <select name="status" id="status" class="form-select form-select-lg" required>
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                    <i class="fas fa-clock"></i> Pending
                                                </option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                    <i class="fas fa-cog"></i> Processing
                                                </option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                    <i class="fas fa-shipping-fast"></i> Shipped
                                                </option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                    <i class="fas fa-truck"></i> Delivered
                                                </option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                    <i class="fas fa-check"></i> Completed
                                                </option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                    <i class="fas fa-times"></i> Cancelled
                                                </option>
                                            </select>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-warning btn-lg">
                                                <i class="fas fa-save me-2"></i>Update Status
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-bolt me-2 text-primary"></i>
                                        Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" onclick="window.print()">
                                            <i class="fas fa-print me-2"></i>Print Order
                                        </button>
                                        <a href="mailto:{{ $order->email }}" class="btn btn-success">
                                            <i class="fas fa-envelope me-2"></i>Email Customer
                                        </a>
                                        <a href="tel:{{ $order->phone }}" class="btn btn-info">
                                            <i class="fas fa-phone me-2"></i>Call Customer
                                        </a>
                                        @if($order->status !== 'cancelled')
                                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    <i class="fas fa-times me-2"></i>Cancel Order
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h5 class="card-title mb-0 fw-bold">
                                        <i class="fas fa-history me-2 text-info"></i>
                                        Order Timeline
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Order Placed</h6>
                                                <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                                            </div>
                                        </div>
                                        @if($order->status !== 'pending')
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-info"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">Status: {{ ucfirst($order->status) }}</h6>
                                                    <small class="text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-box me-2 text-success"></i>
                                    Order Items ({{ count($order->products) }})
                                </h5>
                                <div class="text-end">
                                    <h5 class="mb-0 text-success">Total: ₹{{ number_format($order->total_price, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-3">Product</th>
                                            <th class="px-4 py-3">Quantity</th>
                                            <th class="px-4 py-3">Unit Price</th>
                                            <th class="px-4 py-3">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $product)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        @if(isset($product['image']) && $product['image'])
                                                            <img src="{{ asset($product['image']) }}" 
                                                                 alt="{{ $product['name'] }}" 
                                                                 class="me-3 img-thumbnail" 
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="me-3 bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 60px; height: 60px; border-radius: 0.375rem;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $product['name'] }}</h6>
                                                            @if(isset($product['description']))
                                                                <small class="text-muted">{{ Str::limit(strip_tags($product['description']), 60) }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="badge bg-primary fs-6">{{ $product['quantity'] }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="fw-bold">₹{{ number_format($product['price'], 2) }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="fw-bold text-success">₹{{ number_format($product['price'] * $product['quantity'], 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="3" class="px-4 py-3 text-end">Total Amount:</th>
                                            <th class="px-4 py-3">
                                                <span class="h5 mb-0 text-success">₹{{ number_format($order->total_price, 2) }}</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 1rem;
}

.info-item label {
    display: block;
    margin-bottom: 0.25rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 1.5rem;
    width: 2px;
    height: calc(100% + 0.5rem);
    background-color: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -1.75rem;
    top: 0.25rem;
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

@media print {
    .btn, .card-header, .timeline { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>

@include('dashboard.layout.footer')