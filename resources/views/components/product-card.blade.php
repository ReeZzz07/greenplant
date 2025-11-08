@props(['product'])

<div class="col-sm-12 col-md-6 col-lg-4 ftco-animate d-flex">
    <div class="product d-flex flex-column">
        <a href="{{ route('product', $product->slug) }}" class="img-prod">
            <img class="img-fluid" src="{{ $product->first_image_url }}" alt="{{ $product->name }}">
            @if($product->discount_percent > 0)
                <span class="status">-{{ $product->discount_percent }}%</span>
            @elseif($product->is_featured)
                <span class="status">Хит</span>
            @endif
            <div class="overlay"></div>
        </a>
        <div class="text py-3 pb-4 px-3">
            <div class="d-flex">
                <div class="cat">
                    <span>{{ $product->category->name }}</span>
                </div>
                <div class="rating">
                    <p class="text-right mb-0">
                        @for($i = 0; $i < 5; $i++)
                            <a href="#"><span class="ion-ios-star-outline"></span></a>
                        @endfor
                    </p>
                </div>
            </div>
            <h3><a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a></h3>
            <div class="pricing">
                @if($product->old_price)
                    <p class="price"><span class="mr-2 price-dc">{{ number_format($product->old_price, 0, ',', ' ') }} ₽</span><span class="price-sale">{{ number_format($product->price, 0, ',', ' ') }} ₽</span></p>
                @else
                    <p class="price"><span>{{ number_format($product->price, 0, ',', ' ') }} ₽</span></p>
                @endif
            </div>
            <p class="bottom-area d-flex px-3">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Кнопка "В корзину +" (показывается по умолчанию) -->
                    <div class="add-to-cart-btn-container" style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" class="btn btn-primary py-3 px-5 mr-2 show-quantity-btn">
                            В корзину +
                        </button>
                    </div>
                    
                    <!-- Поле quantity и кнопка подтверждения (скрыто по умолчанию) -->
                    <div class="quantity-selector-container" style="display: none; align-items: center; gap: 10px;">
                        <input type="number" name="quantity" class="quantity-input pr-2" value="1" min="1" max="100">
                        <button type="submit" class="btn btn-primary py-3 px-5 mr-2 confirm-quantity-btn">
                            ✓
                        </button>
                    </div>
                </form>
                <a href="{{ route('product', $product->slug) }}" class="buy-now text-center py-2" style="width: 50%;">Подробнее<span><i class="ion-ios-arrow-forward ml-1"></i></span></a>
            </p>
        </div>
    </div>
</div>

