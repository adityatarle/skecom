@include('dashboard.layout.header')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Customer Analytics</h1>
        <form method="GET" class="d-flex gap-2">
            <input type="date" name="start" value="{{ request('start') }}" class="form-control form-control-sm">
            <input type="date" name="end" value="{{ request('end') }}" class="form-control form-control-sm">
            <button class="btn btn-sm btn-primary">Apply</button>
            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        </form>
    </div>

    <div class="card mb-4">
        <div class="card-header">Top Customers (by Spend)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Email</th><th>Orders</th><th>Total Spent</th><th>Last Order</th></tr></thead>
                    <tbody>
                        @foreach($customersWithOrders as $c)
                            <tr>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->orders }}</td>
                                <td>₹{{ number_format($c->spent,2) }}</td>
                                <td>{{ $c->last_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Signups in last 30 days</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Date</th><th>Signups</th></tr></thead>
                    <tbody>
                        @foreach($signupsLast30 as $r)
                            <tr>
                                <td>{{ $r->date }}</td>
                                <td>{{ $r->count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')

