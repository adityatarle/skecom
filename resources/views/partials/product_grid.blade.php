<!-- partials/product_grid.blade.php  29-3-25 -->
@foreach($products as $product)
<div class="col">
    <div class="jewelry-product">
        <div class="product-thumb">
            <a href="{{ route('product.details', $product->id) }}">
                <img src="{{ $product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png') }}" alt="{{ $product->name }}" class="primary-img">
                <img src="{{ $product->images->count() > 1 ? asset($product->images[1]->image_path) : ($product->images->first() ? asset($product->images->first()->image_path) : asset('images/no-image.png')) }}" alt="{{ $product->name }}" class="hover-img">
            </a>
            <div class="quick-view">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_box">Quick View</a>
            </div>
            <div class="shine-effect"></div>
        </div>
        <div class="product-info">
            <h3><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h3>
            <div class="price-box">
                @if($product->old_price)
                <span class="old-price">₹{{ number_format($product->old_price, 2) }}</span>
                @endif
                <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
            </div>
            <div class="action-links">
                <a href="{{ route('wishlist.add', $product->id) }}" class="add_to_wishlist" data-id="{{ $product->id }}" title="Add to Wishlist"><i class="icon ion-ios-heart-outline"></i></a>
                <a href="{{ route('cart.add', $product->id) }}" class="add_to_cart1" data-id="{{ $product->id }}" title="Add to Cart"><i class="icon ion-bag"></i></a>
            </div>
        </div>
    </div>
</div>
@endforeach