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
                                <i class="fas fa-layer-group me-2"></i>Customer Groups
                            </h3>
                            <small class="opacity-90">View customers categorized by spending patterns</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back to Customers
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Groups -->
            <div class="row">
                <!-- VIP Customers -->
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-gradient-success text-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-crown me-2"></i>
                                <h5 class="card-title mb-0">VIP Customers</h5>
                            </div>
                            <small class="opacity-90">Spent ₹1000+</small>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="text-success fw-bold">{{ $customerGroups['vip']->count() }}</h2>
                                <p class="text-muted mb-0">VIP Customers</p>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse($customerGroups['vip']->take(5) as $customer)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-3">
                                                <div class="symbol-label bg-light-success text-success fw-bold">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $customer->name }}</h6>
                                                <small class="text-muted">
                                                    ₹{{ number_format($customer->orders_sum_total_price ?? 0, 2) }} • {{ $customer->orders_count }} orders
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-crown fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0">No VIP customers yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('admin.customers.index', ['status' => 'vip']) }}" class="btn btn-success btn-sm w-100">
                                View All VIP Customers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Regular Customers -->
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-check me-2"></i>
                                <h5 class="card-title mb-0">Regular Customers</h5>
                            </div>
                            <small class="opacity-90">Spent ₹100-₹999</small>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="text-primary fw-bold">{{ $customerGroups['regular']->count() }}</h2>
                                <p class="text-muted mb-0">Regular Customers</p>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse($customerGroups['regular']->take(5) as $customer)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-3">
                                                <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $customer->name }}</h6>
                                                <small class="text-muted">
                                                    ₹{{ number_format($customer->orders_sum_total_price ?? 0, 2) }} • {{ $customer->orders_count }} orders
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-user-check fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0">No regular customers yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('admin.customers.index', ['status' => 'regular']) }}" class="btn btn-primary btn-sm w-100">
                                View All Regular Customers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- New Customers -->
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-gradient-info text-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-plus me-2"></i>
                                <h5 class="card-title mb-0">New Customers</h5>
                            </div>
                            <small class="opacity-90">Spent < ₹100</small>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="text-info fw-bold">{{ $customerGroups['new']->count() }}</h2>
                                <p class="text-muted mb-0">New Customers</p>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse($customerGroups['new']->take(5) as $customer)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-3">
                                                <div class="symbol-label bg-light-info text-info fw-bold">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $customer->name }}</h6>
                                                <small class="text-muted">
                                                    ₹{{ number_format($customer->orders_sum_total_price ?? 0, 2) }} • {{ $customer->orders_count }} orders
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-user-plus fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0">No new customers yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('admin.customers.index', ['status' => 'new']) }}" class="btn btn-info btn-sm w-100">
                                View All New Customers
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inactive Customers -->
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-gradient-warning text-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-clock me-2"></i>
                                <h5 class="card-title mb-0">Inactive Customers</h5>
                            </div>
                            <small class="opacity-90">No orders placed</small>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2 class="text-warning fw-bold">{{ $customerGroups['inactive']->count() }}</h2>
                                <p class="text-muted mb-0">Inactive Customers</p>
                            </div>
                            <div class="list-group list-group-flush">
                                @forelse($customerGroups['inactive']->take(5) as $customer)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px me-3">
                                                <div class="symbol-label bg-light-warning text-warning fw-bold">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $customer->name }}</h6>
                                                <small class="text-muted">
                                                    Registered {{ $customer->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-user-clock fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0">No inactive customers</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('admin.customers.index', ['status' => 'inactive']) }}" class="btn btn-warning btn-sm w-100">
                                View All Inactive Customers
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Customer Distribution Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-success fw-bold">{{ $customerGroups['vip']->count() }}</h3>
                                        <p class="text-muted mb-0">VIP Customers</p>
                                        <small class="text-success">
                                            {{ $customerGroups['vip']->count() > 0 ? round(($customerGroups['vip']->count() / ($customerGroups['vip']->count() + $customerGroups['regular']->count() + $customerGroups['new']->count() + $customerGroups['inactive']->count())) * 100, 1) : 0 }}%
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-primary fw-bold">{{ $customerGroups['regular']->count() }}</h3>
                                        <p class="text-muted mb-0">Regular Customers</p>
                                        <small class="text-primary">
                                            {{ $customerGroups['regular']->count() > 0 ? round(($customerGroups['regular']->count() / ($customerGroups['vip']->count() + $customerGroups['regular']->count() + $customerGroups['new']->count() + $customerGroups['inactive']->count())) * 100, 1) : 0 }}%
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h3 class="text-info fw-bold">{{ $customerGroups['new']->count() }}</h3>
                                        <p class="text-muted mb-0">New Customers</p>
                                        <small class="text-info">
                                            {{ $customerGroups['new']->count() > 0 ? round(($customerGroups['new']->count() / ($customerGroups['vip']->count() + $customerGroups['regular']->count() + $customerGroups['new']->count() + $customerGroups['inactive']->count())) * 100, 1) : 0 }}%
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <h3 class="text-warning fw-bold">{{ $customerGroups['inactive']->count() }}</h3>
                                        <p class="text-muted mb-0">Inactive Customers</p>
                                        <small class="text-warning">
                                            {{ $customerGroups['inactive']->count() > 0 ? round(($customerGroups['inactive']->count() / ($customerGroups['vip']->count() + $customerGroups['regular']->count() + $customerGroups['new']->count() + $customerGroups['inactive']->count())) * 100, 1) : 0 }}%
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')