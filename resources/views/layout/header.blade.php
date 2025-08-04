<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    
    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('title', 'SK Ornaments - Premium Jewelry Store | Diamond Rings, Gold Jewelry, Silver Jewelry')</title>
    <meta name="description" content="@yield('description', 'SK Ornaments - Your trusted destination for premium jewelry. Explore our exclusive collection of diamond rings, gold jewelry, silver jewelry, and designer pieces. Free shipping, certified diamonds, 30-day return policy.')">
    <meta name="keywords" content="@yield('keywords', 'jewelry, diamond rings, gold jewelry, silver jewelry, designer jewelry, wedding rings, engagement rings, necklaces, earrings, bracelets, SK Ornaments, premium jewelry store')">
    <meta name="author" content="SK Ornaments">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'SK Ornaments - Premium Jewelry Store')">
    <meta property="og:description" content="@yield('og_description', 'Discover exclusive jewelry collection at SK Ornaments. Diamond rings, gold jewelry, and designer pieces with free shipping.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo/logo.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="SK Ornaments">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'SK Ornaments - Premium Jewelry Store')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Discover exclusive jewelry collection at SK Ornaments. Diamond rings, gold jewelry, and designer pieces.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/img/logo/logo.jpg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/logo/favicon-16x16.png') }}">
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Structured Data for Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "JewelryStore",
        "name": "SK Ornaments",
        "description": "Premium jewelry store offering diamond rings, gold jewelry, silver jewelry, and designer pieces",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/img/logo/logo.jpg') }}",
        "image": "{{ asset('assets/img/logo/logo.jpg') }}",
        "telephone": "+91-8450999000",
        "email": "customer.service@skornaments.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E)",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "400022",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "19.0760",
            "longitude": "72.8777"
        },
        "openingHours": "Mo-Su 10:00-20:00",
        "priceRange": "₹₹₹",
        "paymentAccepted": "Cash, Credit Card, Debit Card, UPI, Net Banking",
        "currenciesAccepted": "INR",
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Jewelry Collection",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Product",
                        "name": "Diamond Rings"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Product",
                        "name": "Gold Jewelry"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Product",
                        "name": "Silver Jewelry"
                    }
                }
            ]
        },
        "sameAs": [
            "https://www.facebook.com/skornaments",
            "https://www.instagram.com/skornaments",
            "https://www.youtube.com/skornaments"
        ]
    }
    </script>

    <!--modernizr min js here-->
    <script src="{{ asset('assets/js/vendor/modernizr-3.7.1.min.js') }}"></script>

    <script>
        $(function() {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 1000,
                values: [0, 1000],
                slide: function(event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
        });
    </script>

</head>

<body>
    <!--header sidebar area start-->
    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay"></div>

    <!-- Main Wrapper Start -->
    <div class="home_three_body_wrapper">
        <!--header area start-->
        <!-- Header Section -->
        <header class="header_area header_three">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between py-3 py-sm-0">
                    <!-- Hamburger Menu -->
                    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Logo -->
                    <!-- Desktop logo (lg and up) -->
                    <a href="{{ route('home') }}" class="logo d-none d-lg-block">
                        <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments - Premium Jewelry Store" class="logo-img img-fluid pt-0 pt-lg-3">
                    </a>

                    <!-- Tablet view (md to lg) -->
                    <div class="d-none d-md-flex d-lg-none align-items-center justify-content-between w-100">
                        <!-- Tablet logo -->
                        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                            <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments" class="img-fluid py-3">
                        </a>

                        <!-- Search bar -->
                        <div class="search-bar d-flex align-items-center ms-3">
                            <form action="{{ route('products') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Search for jewelry..." value="{{ request('search') }}">
                                <button type="submit" class="btn ms-2"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile logo (sm and below) -->
                    <a href="{{ route('home') }}" class="logo d-flex d-md-none align-items-center w-100">
                        <img src="{{ asset('assets/img/logo/logo.jpg') }}" alt="SK Ornaments" class="logo-img img-fluid">
                        <p class="ms-2 fw-bold fs-6 mb-0">SK Ornaments</p>
                    </a>

                    <!-- Desktop Search -->
                    <div class="search-bar d-none d-lg-flex">
                        <form action="{{ route('products') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Search for jewelry..." value="{{ request('search') }}">
                            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Header Icons -->
                    <div class="header-icons">
                        <a href="tel:8450999000" title="Call us">
                            <i class="fas fa-headphones d-none d-lg-block"></i>
                        </a>
                        <a href="{{ route('wishlist.index') }}" title="Wishlist">
                            <i class="fa-regular fa-heart">
                                <span class="badge fs-6" id="wishlist_count">
                                    @auth
                                    {{ \App\Models\Wishlist::where('user_id', Auth::id())->count() }}
                                    @else
                                    {{ count(session('wishlist', [])) }}
                                    @endauth
                                </span>
                            </i>
                        </a>
                        <a href="{{ route('cart.index') }}" title="Shopping Cart">
                            <i class="fa-solid fa-cart-shopping">
                                <span class="badge fs-6" id="cart_count">{{ count(session('cart', [])) }}</span>
                            </i>
                        </a>
                        @auth
                            <a href="{{ route('profile.show') }}" title="My Account">
                                <i class="fas fa-user d-none d-md-block"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" title="Login">
                                <i class="fas fa-user d-none d-md-block"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Search Bar (Visible only on mobile) -->
                <div class="mobile-search-bar d-lg-none d-md-none d-flex align-items-center">
                    <form action="{{ route('products') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                    </form>
                    @auth
                        <a href="{{ route('profile.show') }}" title="My Account">
                            <i class="fas fa-2x fa-user ms-3"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" title="Login">
                            <i class="fas fa-2x fa-user ms-3"></i>
                        </a>
                    @endauth
                </div>

                <!-- Navigation -->
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                        <ul class="navbar-nav navbar-links">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            @foreach($categories as $category)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $category->name }}
                                </a>

                                @if($category->subcategories->count() > 0)
                                <ul class="dropdown-menu">
                                    @foreach($category->subcategories as $subcategory)
                                    <li>
                                        <a class="dropdown-item header-dropdown" href="{{ route('products', ['subcategory' => $subcategory->name]) }}">
                                            {{ $subcategory->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('about') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--header area end-->

        @yield('content')
    </div> <!-- Closing home_three_body_wrapper -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-mail.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/header-script.js') }}"></script>

</body>
</html>