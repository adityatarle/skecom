@include('layout.header')

@section('title', 'Jewelry Collection - Browse All Products | SK Ornaments')
@section('description', 'Explore our complete jewelry collection. Filter by category, price range, and more. Find the perfect piece from our curated selection of rings, necklaces, earrings, and more.')
@section('keywords', 'jewelry, rings, necklaces, earrings, bracelets, diamond jewelry, gold jewelry, silver jewelry, SK Ornaments')

@section('og_title', 'Jewelry Collection - SK Ornaments')
@section('og_description', 'Browse our complete jewelry collection with advanced filtering options.')

<!-- Include jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    /* Shop Inner Page Styling */
    #shop-inner-page {
        background: linear-gradient(135deg, #f8f1e9 0%, #e8e2d9 100%);
        font-family: 'Playfair Display', serif;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .filter-controls {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .filter-group select,
    .filter-group input {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        min-width: 150px;
    }

    .search-box {
        flex: 1;
        min-width: 200px;
    }

    .search-box input {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 25px;
        background: #f8f9fa;
    }

    .clear-filters {
        background: #dc3545;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .clear-filters:hover {
        background: #c82333;
    }

    /* Sidebar Styling */
    .sidebar_widget {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
    }

    .widget_list h2 {
        font-size: 20px;
        color: #333;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        position: relative;
    }

    .widget_list h2::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 40px;
        height: 2px;
        background: #c19a6b;
    }

    /* Categories */
    .widget_categories ul {
        list-style: none;
        padding: 0;
    }

    .widget_categories li {
        margin-bottom: 12px;
    }

    .widget_categories a {
        color: #666;
        text-decoration: none;
        font-size: 15px;
        transition: all 0.3s ease;
        padding: 8px 15px;
        display: block;
        border-radius: 5px;
        position: relative;
    }

    .widget_categories a:hover,
    .widget_categories a.active {
        color: #fff;
        background: linear-gradient(90deg, #c19a6b, #a67b5b);
    }

    .subcategory-list {
        margin-left: 20px;
        margin-top: 5px;
        display: none;
    }

    .subcategory-list.show {
        display: block;
    }

    .subcategory-list li {
        margin-bottom: 8px;
    }

    .subcategory-list a {
        font-size: 13px;
        padding: 5px 10px;
        background: #f8f9fa;
        border-left: 3px solid #c19a6b;
    }

    .subcategory-list a:hover,
    .subcategory-list a.active {
        background: linear-gradient(90deg, #e8e2d9, #d4c4b7);
        color: #333;
    }

    .category-toggle {
        float: right;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .category-toggle.rotated {
        transform: rotate(90deg);
    }

    /* Price Filter */
    .widget_filter {
        margin-top: 30px;
        padding: 0;
        border: none;
    }

    .widget_filter h2 {
        font-size: 20px;
        color: #333;
        margin-bottom: 20px;
    }

    #slider-range {
        margin: 20px 0;
        background: #e0d8d0;
        height: 6px;
        border-radius: 3px;
        border: none;
    }

    #slider-range .ui-slider-range {
        background: #c19a6b;
        height: 100%;
        border-radius: 3px;
    }

    #slider-range .ui-slider-handle {
        width: 16px;
        height: 16px;
        background: #fff;
        border: 2px solid #c19a6b;
        border-radius: 50%;
        top: -5px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    #slider-range .ui-slider-handle:hover {
        transform: scale(1.2);
    }

    #amount {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: none;
        background: none;
        color: #c19a6b;
        font-weight: 600;
        font-size: 16px;
        text-align: center;
    }

    .widget_filter button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #c19a6b, #a67b5b);
        border: none;
        border-radius: 25px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .widget_filter button:hover {
        transform: scale(1.05);
        background: linear-gradient(90deg, #a67b5b, #c19a6b);
    }

    /* Product Grid */
    .product-grid {
        min-height: 400px;
    }

    .product-grid .jewelry-product {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .product-grid .jewelry-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 2rem;
        text-align: center;
    }

    .pagination {
        justify-content: center;
    }

    .page-link {
        color: #c19a6b;
        border-color: #e8e2d9;
    }

    .page-link:hover {
        background-color: #c19a6b;
        border-color: #c19a6b;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #c19a6b;
        border-color: #c19a6b;
    }

    /* Loading State */
    .loading {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .loading::after {
        content: '';
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid #c19a6b;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Mobile Responsive */
    .mobile-filter-dropdown .filter-toggle {
        display: none;
    }

    .mobile-filter-dropdown .filter-content {
        display: block;
    }

    @media (max-width: 767px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .filter-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-filter-dropdown .filter-toggle {
            display: block;
            width: 100%;
            padding: 10px;
            background: #f9f5f3;
            border: 1px solid #ddd;
            text-align: left;
            cursor: pointer;
            font-size: 16px;
            position: relative;
        }

        .mobile-filter-dropdown .filter-toggle::after {
            content: '▼';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #b89f7e;
        }

        .mobile-filter-dropdown .filter-content {
            display: none;
            background: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 5px;
        }

        .mobile-filter-dropdown.active .filter-content {
            display: block;
        }

        .mobile-filter-dropdown.active .filter-toggle::after {
            content: '▲';
        }
    }
</style>

<!-- Shop Area Start -->
<div class="shop_area shop_reverse" id="shop-inner-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>Jewelry Collection</h1>
            <p>Discover our exquisite collection of fine jewelry</p>
        </div>
    </div>

    <div class="container">
        <!-- Filter Bar -->
        <div class="filter-bar">
            <form id="filter-form" method="GET" action="{{ route('products') }}">
                <div class="filter-controls">
                    <div class="filter-group">
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" data-id="{{ $cat->id }}" {{ $category == $cat->name ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="subcategory">Subcategory</label>
                        <select name="subcategory" id="subcategory">
                            <option value="">All Subcategories</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="sort">Sort By</label>
                        <select name="sort" id="sort">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </div>

                    <div class="filter-group search-box">
                        <label for="search">Search</label>
                        <input type="text" name="search" id="search" placeholder="Search products..." value="{{ $search }}">
                    </div>

                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>

                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button type="button" class="clear-filters" onclick="clearFilters()">Clear All</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row g-5">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-12 order-md-1 order-2">
                <div class="sidebar_widget">
                    <!-- Mobile Dropdown Wrapper -->
                    <div class="mobile-filter-dropdown">
                        <button class="filter-toggle">Filter Products</button>
                        <div class="filter-content">
                            <!-- Categories Section -->
                            <div class="widget_list widget_categories">
                                <h2>Categories</h2>
                                <ul>
                                    <li>
                                        <a href="{{ route('products') }}" class="{{ !$category ? 'active' : '' }}">
                                            All Categories
                                        </a>
                                    </li>
                                    @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('products', ['category' => $cat->name]) }}" 
                                           class="{{ $category == $cat->name ? 'active' : '' }}">
                                            {{ $cat->name }}
                                            @if($cat->subcategories->count() > 0)
                                                <span class="category-toggle" onclick="toggleSubcategories({{ $cat->id }})">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            @endif
                                        </a>
                                        @if($cat->subcategories->count() > 0)
                                            <ul class="subcategory-list" id="subcategories-{{ $cat->id }}">
                                                @foreach($cat->subcategories as $sub)
                                                    <li>
                                                        <a href="{{ route('products', ['category' => $cat->name, 'subcategory' => $sub->name]) }}"
                                                           class="{{ $subcategory == $sub->name ? 'active' : '' }}">
                                                            {{ $sub->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Price Filter Section -->
                            <div class="widget_list widget_filter">
                                <h2>Filter by Price</h2>
                                <form id="price-filter-form">
                                    <div id="slider-range"></div>
                                    <input type="text" name="amount" id="amount" readonly>
                                    <input type="hidden" id="min_price" name="min_price" value="{{ $min_price }}">
                                    <input type="hidden" id="max_price" name="max_price" value="{{ $max_price }}">
                                    <button type="submit">Apply Price Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9 col-md-12 order-md-2 order-1">
                <div class="shop_wrapper">
                    <!-- Results Summary -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products</span>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="product-grid">
                        <div id="product-grid-container" class="row row-cols-2 row-cols-md-3 g-4">
                            @include('partials.product_grid')
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="pagination-wrapper">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize price slider
    $("#slider-range").slider({
        range: true,
        min: {{ $minPrice }},
        max: {{ $maxPrice }},
        values: [{{ $min_price ?: $minPrice }}, {{ $max_price ?: $maxPrice }}],
        slide: function(event, ui) {
            $("#amount").val("₹" + ui.values[0].toLocaleString() + " - ₹" + ui.values[1].toLocaleString());
            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
        }
    });

    $("#amount").val("₹" + $("#slider-range").slider("values", 0).toLocaleString() + " - ₹" + $("#slider-range").slider("values", 1).toLocaleString());

    // Category change handler
    $('#category').on('change', function() {
        const categoryId = $(this).find('option:selected').data('id');
        updateSubcategories(categoryId);
    });

    // Form submission handler
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        updateProducts();
    });

    // Price filter form submission
    $('#price-filter-form').on('submit', function(e) {
        e.preventDefault();
        updateProducts();
    });

    // Search input handler with debounce
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            updateProducts();
        }, 500);
    });

    // Sort change handler
    $('#sort').on('change', function() {
        updateProducts();
    });

    // Mobile filter toggle
    $('.filter-toggle').on('click', function() {
        $(this).parent('.mobile-filter-dropdown').toggleClass('active');
    });
});

// Function to update subcategories
function updateSubcategories(categoryId) {
    if (!categoryId) {
        $('#subcategory').html('<option value="">All Subcategories</option>');
        return;
    }

    $.ajax({
        url: "{{ route('get.subcategories') }}",
        type: 'GET',
        data: { category_id: categoryId },
        success: function(data) {
            let options = '<option value="">All Subcategories</option>';
            data.forEach(function(subcategory) {
                options += `<option value="${subcategory.name}">${subcategory.name}</option>`;
            });
            $('#subcategory').html(options);
        }
    });
}

// Function to update products via AJAX
function updateProducts() {
    const formData = $('#filter-form').serialize();
    const priceData = $('#price-filter-form').serialize();
    const allData = formData + '&' + priceData;

    $('#product-grid-container').html('<div class="loading">Loading products...</div>');

    $.ajax({
        url: "{{ route('products') }}",
        type: 'GET',
        data: allData,
        success: function(response) {
            $('#product-grid-container').html(response);
            
            // Update URL without page reload
            const url = new URL(window.location);
            const params = new URLSearchParams(allData);
            url.search = params.toString();
            window.history.pushState({}, '', url);
        },
        error: function() {
            $('#product-grid-container').html('<div class="text-center text-danger">Error loading products. Please try again.</div>');
        }
    });
}

// Function to clear all filters
function clearFilters() {
    window.location.href = "{{ route('products') }}";
}

// Function to toggle subcategories
function toggleSubcategories(categoryId) {
    const subcategoryList = $(`#subcategories-${categoryId}`);
    const toggle = subcategoryList.prev().find('.category-toggle');
    
    subcategoryList.toggleClass('show');
    toggle.toggleClass('rotated');
}

// Initialize subcategories on page load
$(document).ready(function() {
    const selectedCategory = $('#category option:selected');
    if (selectedCategory.val()) {
        updateSubcategories(selectedCategory.data('id'));
    }
});
</script>

@include('layout.footer')