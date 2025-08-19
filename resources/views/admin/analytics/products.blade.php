@include('dashboard.layout.header')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Product Performance</h1>
        <form method="GET" class="d-flex gap-2">
            <select name="category" class="form-select form-select-sm">
                <option value="">All Categories</option>
                @foreach($byCategory as $c)
                    <option value="{{ $c->id }}" {{ request('category')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        </form>
    </div>

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

