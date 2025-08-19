@include('dashboard.layout.header')

<div class="container mt-4">
    <h1>Customer Analytics</h1>

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

