@include('dashboard.layout.header')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Sales Reports</h1>
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="start" value="{{ request('start') }}" class="form-control form-control-sm">
            <input type="date" name="end" value="{{ request('end') }}" class="form-control form-control-sm">
            <button class="btn btn-sm btn-primary">Apply</button>
            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        </form>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Orders Today</div><div class="h4">{{ $totals['orders_today'] }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Revenue Today</div><div class="h4">₹{{ number_format($totals['revenue_today'],2) }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Orders This Month</div><div class="h4">{{ $totals['orders_month'] }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Revenue This Month</div><div class="h4">₹{{ number_format($totals['revenue_month'],2) }}</div></div></div></div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Sales Timeline</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
                    <tbody>
                        @foreach($dailySales as $row)
                            <tr>
                                <td>{{ $row->date }}</td>
                                <td>{{ $row->orders }}</td>
                                <td>₹{{ number_format($row->revenue,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">Top Products</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead><tr><th>Product</th><th>Qty</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @foreach($topProducts as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->qty }}</td>
                                        <td>₹{{ number_format($p->revenue,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">Category Performance</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead><tr><th>Category</th><th>Qty</th><th>Revenue</th></tr></thead>
                            <tbody>
                                @foreach($categoryPerformance as $c)
                                    <tr>
                                        <td>{{ $c->category }}</td>
                                        <td>{{ $c->qty }}</td>
                                        <td>₹{{ number_format($c->revenue,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')

