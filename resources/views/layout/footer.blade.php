<footer class="footer_widgets">
    <div class="container">
        <div class="footer_top">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="widgets_container contact_us">
                        <h3>About SK</h3>
                        <div class="footer_contact">
                            <p><i class="fa-solid fa-location-dot me-2"></i><a href="https://maps.app.goo.gl/1yAUhdB3UTGKTHsq7" target="_blank"> 201, Bansari Bhuvan, Shop No.11, Tamil Sangam Marg, Opp. Union Bank, Sion (E), Mumbai - 400 022. India</a></p>
                            <p><i class="fa-solid fa-phone me-2"></i> <a href="tel:8450999000" target="_blank">8450999000</a> | <a href="tel:8450999088" target="_blank">8450999088</a></p>
                            <p><i class="fa-solid fa-tty me-2"></i><a href="tel:022 - 2403 3043" target="_blank">+91 022 - 2403 3043/44/45</a></p>
                            <p><i class="fa-solid fa-envelope me-2"></i><a href="mailto:customer.service@skornaments.com" target="_blank">customer.service@skornaments.com</a></p>
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-4 col-6">
                    <div class="widgets_container widget_menu">
                        <h3>Information</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('blog') }}">Blog</a></li>
                                <li><a href="{{ route('products') }}">Products</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                                <li><a href="{{ route('size.guide') }}">Size Guide</a></li>
                                <li><a href="{{ route('jewelry.care') }}">Jewelry Care</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-5 col-6">
                    <div class="widgets_container widget_menu">
                        <h3>My Account</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{ route('profile.show') }}">My Account</a></li>
                                <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                                <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="widgets_container product_widget">
                        <h3>Top Rated Products</h3>
                        <div class="simple_product">
                            <div class="simple_product_items">
                                <div class="simple_product_thumb">
                                    <a href="#"><img src="{{ asset('assets/img/s-product/product5.jpg') }}" alt=""></a>
                                </div>
                                <div class="simple_product_content">
                                    <div class="tag_cate">
                                        <a href="#">Rings,</a>
                                        <a href="#">Bracelet</a>
                                    </div>
                                    <div class="product_name">
                                        <h3><a href="#">Diamond Rings</a></h3>
                                    </div>
                                    <div class="product_price">
                                        <span class="old_price">$86.00</span>
                                        <span class="current_price">$70.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="simple_product_items">
                                <div class="simple_product_thumb">
                                    <a href="#"><img src="{{ asset('assets/img/s-product/24.jpeg') }}" alt=""></a>
                                </div>
                                <div class="simple_product_content">
                                    <div class="tag_cate">
                                        <a href="#">Bracelet</a>
                                    </div>
                                    <div class="product_name">
                                        <h3><a href="#">Diamond Bracelet</a></h3>
                                    </div>
                                    <div class="product_price">
                                        <span class="old_price">$74.00</span>
                                        <span class="current_price">$69.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_middel">
            <div class="row">
                <div class="col-12">
                    <div class="footer_middel_menu">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('products') }}">Online Store</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.conditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('shipping.policy') }}">Shipping Policy</a></li>
                            <li><a href="{{ route('return.policy') }}">Return Policy</a></li>
                            <li><a href="#">Terms Of Use</a></li>
                            <li><a href="#">Sitemap</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Contacts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="row">
                <div class="col-12">
                    <div class="copyright_area">
                        <p>© Copyright <a href="#" class="text-uppercase">Heuristic Technopark Pvt Ltd</a>. All Rights Reserved</p>
                        <img src="{{ asset('assets/img/icon/papyel2.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product1.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product2.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product3.jpg" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab4" role="tabpanel">
                                        <div class="modal_tab_img">
                                            <a href="#"><img src="assets/img/product/product5.jpg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false"><img src="assets/img/product/product1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false"><img src="assets/img/product/product2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link button_three" data-bs-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"><img src="assets/img/product/product3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false"><img src="assets/img/product/product5.jpg" alt=""></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>Donec eu furniture</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    <span class="new_price">$64.99</span>
                                    <span class="old_price">$78.99</span>
                                </div>
                                <div class="see_all">
                                    <a href="product-details.html">See all features</a>
                                </div>
                                <div class="modal_add_to_cart mb-15">
                                    <form action="#">
                                        <input min="0" max="100" step="2" value="1" type="number">
                                        <button type="submit">add to cart</button>
                                    </form>
                                </div>
                                <div class="modal_description mb-15">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                </div>
                                <div class="modal_social">
                                    <h2>Share this product</h2>
                                    <ul>
                                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                        <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal area start-->

</div>

<script>
    $(document).ready(function() {
        // Add to Cart
        $(document).on('click', '.add_to_cart1', function(e) {
            e.preventDefault();
            var productId = $(this).data("id");
            var button = $(this);
            var originalText = button.text();
            
            // Disable button and show loading state
            button.prop('disabled', true).text('Adding...');

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === "success") {
                        // Show success message
                        showNotification(response.message, 'success');
                        
                        // Update cart count in header
                        updateCartCount(response.cart_count);
                        
                        // Show button feedback
                        button.text('Added!').removeClass('btn-dark').addClass('btn-success');
                        setTimeout(function() {
                            button.text(originalText).removeClass('btn-success').addClass('btn-dark');
                        }, 2000);
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Cart Error:', xhr.responseText);
                    showNotification("Error adding to cart", 'error');
                },
                complete: function() {
                    button.prop('disabled', false);
                    if (button.text() === 'Adding...') {
                        button.text(originalText);
                    }
                }
            });
        });

        // Add to Wishlist
        $(document).on('click', '.add_to_wishlist', function(e) {
            e.preventDefault();
            var productId = $(this).data("id");
            var button = $(this);
            var icon = button.find('i');

            $.ajax({
                url: "{{ route('wishlist.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === "success") {
                        showNotification(response.message, 'success');
                        updateWishlistCount(response.wishlist_count);
                        
                        // Update icon to show added state
                        if (icon.length) {
                            icon.removeClass('fa-heart-o').addClass('fa-heart').css('color', '#e74c3c');
                        }
                        button.addClass('in-wishlist');
                    } else if (response.status === "info") {
                        showNotification(response.message, 'info');
                    } else {
                        showNotification(response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Wishlist Error:', xhr.responseText);
                    showNotification("Error adding to wishlist", 'error');
                }
            });
        });

        // Helper function to update cart count
        function updateCartCount(count) {
            var cartCountElements = $('#cart_count, .cart-count, [data-cart-count]');
            cartCountElements.text(count);
            
            // Animate the count update
            cartCountElements.animate({
                fontSize: '1.2em'
            }, 200).animate({
                fontSize: '1em'
            }, 200);
        }

        // Helper function to update wishlist count
        function updateWishlistCount(count) {
            var wishlistCountElements = $('#wishlist_count, .wishlist-count, [data-wishlist-count]');
            wishlistCountElements.text(count);
            
            // Animate the count update
            wishlistCountElements.animate({
                fontSize: '1.2em'
            }, 200).animate({
                fontSize: '1em'
            }, 200);
        }

        // Notification system
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            $('.notification').remove();
            
            var notificationClass = 'alert-info';
            if (type === 'success') notificationClass = 'alert-success';
            if (type === 'error') notificationClass = 'alert-danger';
            if (type === 'warning') notificationClass = 'alert-warning';
            
            var notification = $(`
                <div class="notification alert ${notificationClass} alert-dismissible fade show" 
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            
            $('body').append(notification);
            
            // Auto hide after 4 seconds
            setTimeout(function() {
                notification.alert('close');
            }, 4000);
        }

        // Load initial counts on page load
        loadCartCount();
        loadWishlistCount();

        function loadCartCount() {
            $.get("{{ route('cart.count') }}", function(response) {
                updateCartCount(response.cart_count);
            }).fail(function() {
                console.log('Failed to load cart count');
            });
        }

        function loadWishlistCount() {
            $.get("{{ route('wishlist.count') }}", function(response) {
                updateWishlistCount(response.wishlist_count);
            }).fail(function() {
                console.log('Failed to load wishlist count');
            });
        }
    });
</script>

<!-- JS
============================================ -->

<!-- Plugins JS -->
<script src="{{ asset('assets/js/vendor/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.main.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice.select.js') }}"></script>
<script src="{{ asset('assets/js/scrollup.js') }}"></script>
<script src="{{ asset('assets/js/ajax.chimp.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.js') }}"></script>
<script src="{{ asset('assets/js/jquery.elevatezoom.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
<script src="{{ asset('assets/js/isotope.main.js') }}"></script>
<script src="{{ asset('assets/js/jqquery.ripples.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/js/bpopup.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>



</body>


<!-- Mirrored from htmldemo.net/monsta/monsta/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Feb 2025 10:35:11 GMT -->

</html>