@include('dashboard.layout.header')

<div class="container mt-4">
    <h1>Product Performance</h1>

    <div class="row g-3 mb-4">
        @foreach($productCounts as $status => $count)
            <div class="col-md-3">
                <div class="card"><div class="card-body">
                    <div class="text-muted text-capitalize">{{ $status ?: 'unknown' }}</div>
                    <div class="h4">{{ $count }}</div>
                </div></div>
            </div>
        @endforeach
    </div>

    <div class="card mb-4">
        <div class="card-header">Products by Category</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Category</th><th>Products</th></tr></thead>
                    <tbody>
                        @foreach($byCategory as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->products_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Recently Added Products</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Name</th><th>Price</th></tr></thead>
                    <tbody>
                        @foreach($topViewed as $p)
                            <tr>
                                <td>{{ $p->name }}</td>
                                <td>₹{{ number_format($p->price,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('dashboard.layout.footer')

