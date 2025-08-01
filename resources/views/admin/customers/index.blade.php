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
                                <i class="fas fa-users me-2"></i>Customer Management
                            </h3>
                            <small class="opacity-90">Manage and view all registered customers</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.customers.export') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-download me-1"></i>Export
                                </a>
                                <a href="{{ route('admin.customers.groups') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-layer-group me-1"></i>Customer Groups
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by name, email, or phone..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Date Filter</label>
                            <select name="date_filter" class="form-select">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                                <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Customers</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-user me-1"></i>Customer
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-phone me-1"></i>Phone
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-calendar me-1"></i>Registered
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-shopping-cart me-1"></i>Orders
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-money-bill me-1"></i>Total Spent
                                    </th>
                                    <th class="px-4 py-3">
                                        <i class="fas fa-clock me-1"></i>Last Order
                                    </th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-cogs me-1"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $customer)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-40px me-3">
                                                    <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ $customer->name }}</h6>
                                                    <small class="text-muted">ID: {{ $customer->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="mailto:{{ $customer->email }}" class="text-decoration-none">
                                                {{ $customer->email }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($customer->phone)
                                                <a href="tel:{{ $customer->phone }}" class="text-decoration-none">
                                                    {{ $customer->phone }}
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold">{{ $customer->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-primary">{{ $customer->orders_count }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-semibold text-success">
                                                ₹{{ number_format($customer->orders_sum_total_price ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($customer->orders_count > 0)
                                                @php
                                                    $lastOrder = $customer->orders()->latest()->first();
                                                @endphp
                                                <div>
                                                    <div class="fw-semibold">{{ $lastOrder->created_at->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $lastOrder->created_at->diffForHumans() }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">No orders</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.customers.show', $customer) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="mailto:{{ $customer->email }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Send Email">
                                                    <i class="fas fa-envelope"></i>
                                                </a>
                                                @if($customer->phone)
                                                    <a href="tel:{{ $customer->phone }}" 
                                                       class="btn btn-sm btn-outline-success" 
                                                       title="Call Customer">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-5 text-center text-muted">
                                            <i class="fas fa-users fa-3x mb-3 d-block text-muted opacity-50"></i>
                                            <h5>No customers found</h5>
                                            <p class="mb-3">No customers match your search criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($customers->hasPages())
                        <div class="card-footer bg-white border-top-0">
                            {{ $customers->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')