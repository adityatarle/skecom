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

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">Revenue Over Time</div>
                <div class="card-body"><canvas id="salesLine"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Orders Over Time</div>
                <div class="card-body"><canvas id="ordersLine"></canvas></div>
            </div>
        </div>
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
                    <canvas id="topProductsBar" class="mb-3"></canvas>
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
                    <canvas id="categoryDoughnut" class="mb-3"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        const daily = @json($dailySales);
        const labels = daily.map(d => d.date);
        const revenue = daily.map(d => Number(d.revenue));
        const orders = daily.map(d => Number(d.orders));

        new Chart(document.getElementById('salesLine'), {
            type: 'line',
            data: { labels, datasets: [{ label: 'Revenue', data: revenue, borderColor: '#4f46e5', backgroundColor: 'rgba(79,70,229,.15)', tension:.3, fill:true }] },
            options: { plugins:{legend:{display:true}}, scales:{y:{beginAtZero:true}} }
        });

        new Chart(document.getElementById('ordersLine'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Orders', data: orders, backgroundColor: '#22c55e' }] },
            options: { plugins:{legend:{display:true}}, scales:{y:{beginAtZero:true}} }
        });

        const top = @json($topProducts);
        new Chart(document.getElementById('topProductsBar'), {
            type: 'bar',
            data: {
                labels: top.map(t => t.name),
                datasets: [{ label: 'Qty', data: top.map(t => Number(t.qty)), backgroundColor: '#14b8a6' }]
            },
            options: { indexAxis: 'y', scales:{x:{beginAtZero:true}} }
        });

        const cat = @json($categoryPerformance);
        new Chart(document.getElementById('categoryDoughnut'), {
            type: 'doughnut',
            data: {
                labels: cat.map(c => c.category),
                datasets: [{ data: cat.map(c => Number(c.revenue)), backgroundColor: ['#8b5cf6','#f59e0b','#10b981','#ef4444','#3b82f6','#06b6d4','#f97316','#84cc16'] }]
            },
            options: { plugins:{legend:{position:'bottom'}} }
        });
    })();
</script>

@include('dashboard.layout.footer')

