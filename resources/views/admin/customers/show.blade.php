@include('dashboard.layout.header')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Customer Details
                            </h3>
                            <small class="opacity-90">View detailed information about {{ $customer->name }}</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Customers
                                </a>
                                <a href="mailto:{{ $customer->email }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-envelope me-1"></i>Send Email
                                </a>
                                @if($customer->phone)
                                    <a href="tel:{{ $customer->phone }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-phone me-1"></i>Call
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Customer Information -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-light py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-circle me-2"></i>Customer Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="symbol symbol-80px mx-auto mb-3">
                                    <div class="symbol-label bg-light-primary text-primary fw-bold fs-2">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </div>
                                </div>
                                <h4 class="fw-bold">{{ $customer->name }}</h4>
                                <p class="text-muted mb-0">Customer ID: {{ $customer->id }}</p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Email Address</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                            {{ $customer->email }}
                                        </a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Phone Number</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-muted me-2"></i>
                                        @if($customer->phone)
                                            <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                                {{ $customer->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Registration Date</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-muted me-2"></i>
                                        <span>{{ $customer->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Member Since</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock text-muted me-2"></i>
                                        <span>{{ $customer->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Statistics -->
                <div class="col-lg-8 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-cart fa-2x mb-2 opacity-75"></i>
                                    <h3 class="fw-bold">{{ $stats['total_orders'] }}</h3>
                                    <p class="mb-0 opacity-90">Total Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-money-bill-wave fa-2x mb-2 opacity-75"></i>
                                    <h3 class="fw-bold">₹{{ number_format($stats['total_spent'], 2) }}</h3>
                                    <p class="mb-0 opacity-90">Total Spent</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-2x mb-2 opacity-75"></i>
                                    <h3 class="fw-bold">₹{{ number_format($stats['average_order_value'], 2) }}</h3>
                                    <p class="mb-0 opacity-90">Average Order Value</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-check fa-2x mb-2 opacity-75"></i>
                                    <h3 class="fw-bold">{{ $stats['days_since_registration'] }}</h3>
                                    <p class="mb-0 opacity-90">Days as Member</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Last Order Information -->
                    @if($stats['total_orders'] > 0)
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-clock me-2"></i>Last Order Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="fw-semibold mb-1">Last Order Date</h6>
                                        <p class="text-muted mb-0">{{ $stats['last_order_date'] }}</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <a href="{{ route('admin.orders.show', $customer->orders->first()->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>View Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Order History
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($customer->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="px-4 py-3">Order ID</th>
                                        <th class="px-4 py-3">Date</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Items</th>
                                        <th class="px-4 py-3">Total Amount</th>
                                        <th class="px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer->orders as $order)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <span class="fw-semibold">#{{ $order->id }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div>
                                                    <div class="fw-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-info">Processing</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-primary">Shipped</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-success">Delivered</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-secondary">{{ $order->orderItems->count() }} items</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="fw-semibold text-success">₹{{ number_format($order->total_price, 2) }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x mb-3 text-muted opacity-50"></i>
                            <h5>No Orders Yet</h5>
                            <p class="text-muted mb-0">This customer hasn't placed any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')