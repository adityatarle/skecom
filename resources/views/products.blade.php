@include('layout.header')

<!-- Include jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    /* Shop Inner Page Styling */
    #shop-inner-page {
        background: linear-gradient(135deg, #f8f1e9 0%, #e8e2d9 100%);
        font-family: 'Playfair Display', serif;
    }

    /* Sidebar Styling */
    .sidebar_widget {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
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
    }

    .widget_categories a:hover,
    .widget_categories a.active {
        color: #fff;
        background: linear-gradient(90deg, #c19a6b, #a67b5b);
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
    }

    .widget_filter button:hover {
        transform: scale(1.05);
        background: linear-gradient(90deg, #a67b5b, #c19a6b);
    }

    /* 12/4/25 Start */
    /* Default styles for larger screens */
    .mobile-filter-dropdown .filter-toggle {
        display: none;
    }

    .mobile-filter-dropdown .filter-content {
        display: block;
    }

    /* Mobile view */
    @media (max-width: 767px) {
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
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 col-md-12 order-md-1 order-2 sticky-top" style="z-index: 999;">
                <!-- Sidebar Widget Start -->
                <div class="sidebar_widget">
                    <!-- Mobile Dropdown Wrapper -->
                    <div class="mobile-filter-dropdown">
                        <button class="filter-toggle">Filter Products</button>
                        <div class="filter-content">
                            <!-- Categories Section -->
                            <div class="widget_list widget_categories">
                                <h2>Categories</h2>
                                <ul>
                                    @foreach($categories as $category)
                                    <li>
                                        <a class="nav-link" href="{{ route('products', ['category' => $category->name]) }}">
                                            {{ $category->name }}
                                            @if($category->subcategories->count() > 0)
                                            <span class="dropdown-arrow d-lg-none"><i class="fas fa-chevron-down"></i></span>
                                            @endif
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Price Filter Section -->
                            <div class="widget_list widget_filter">
                                <h2>Filter by Price</h2>
                                <form id="price-filter-form" action="{{ route('products') }}" method="GET">
                                    <input type="hidden" name="category" id="filter-category" value="{{ request('category') }}">
                                    <div id="slider-range"></div>
                                    <input type="text" name="amount" id="amount" readonly>
                                    <input type="hidden" id="min_price" name="min_price" value="">
                                    <input type="hidden" id="max_price" name="max_price" value="">
                                    <button type="submit">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ... rest of your sidebar widgets ... -->
                </div>
                <!-- Sidebar Widget End -->
            </div>
            <div class="col-lg-9 col-md-12 order-md-2 order-1">
                <!-- Shop Wrapper Start -->
                <div class="shop_wrapper">
                    <!-- Shop Tab Product Start -->
                    <div class="tab-content">
                        <div class="tab-pane grid_view fade show active" id="large" role="tabpanel">
                            <div id="product-grid-container" class="row row-cols-2 row-cols-md-3 g-4">
                                @include('partials.product_grid')
                            </div>
                        </div>
                    </div>
                    <!-- Shop Tab Product End -->
                </div>
                <!-- Shop Wrapper End -->
            </div>
        </div>
    </div>
</div>
<!-- Shop Area End -->

<!-- Include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function() {
        

        // Price slider
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 10000,
            values: [0, 10000],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
            },
            stop: function(event, ui) {
                updateProducts($('#filter-category').val(), ui.values[0], ui.values[1]);
            }
        });

        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
        $("#min_price").val($("#slider-range").slider("values", 0));
        $("#max_price").val($("#slider-range").slider("values", 1));

        // Prevent the price filter form from submitting normally
        $('#price-filter-form').on('submit', function(e) {
            e.preventDefault();
            updateProducts($('#filter-category').val(), $('#min_price').val(), $('#max_price').val());
        });

        // Function to update product list via AJAX
        function updateProducts(category, min_price, max_price) {
            console.log('Updating products with:', {
                category,
                min_price,
                max_price
            }); // Debug
            $.ajax({
                url: "{{ route('products') }}",
                type: "GET",
                data: {
                    category: category,
                    min_price: min_price,
                    max_price: max_price,
                    _t: new Date().getTime() // Cache buster
                },
                success: function(data) {
                    console.log('AJAX success, updating grid'); // Debug
                    $("#product-grid-container").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", status, error, xhr.responseText); // Debug
                }
            });
        }

        // Mobile filter toggle
        $('.filter-toggle').on('click', function() {
            $(this).parent('.mobile-filter-dropdown').toggleClass('active');
        });
    });
</script>

@include('layout.footer')