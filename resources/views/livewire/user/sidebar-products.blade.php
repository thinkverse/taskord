<div>
    <div class="pt-2 pb-2">
        @if (count($user->ownedProducts->merge($user->products)) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-cube class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No products made
                </div>
            </div>
        @endif
        @foreach ($user->ownedProducts->merge($user->products)->take(5) as $product)
            <div class="py-2 px-3">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="product-popover"
                    data-id="{{ $product->id }}">
                    <img loading=lazy class="rounded avatar-30 ms-2"
                        src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="30" width="30"
                        alt="{{ $product->slug }}'s avatar" />
                </a>
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}"
                    class="ms-2 me-2 align-text-top fw-bold text-dark product-popover"
                    data-id="{{ $product->id }}">
                    {{ $product->name }}
                </a>
            </div>
        @endforeach
    </div>
    @if (count($user->ownedProducts->merge($user->products)) > 5)
        <div class="card-footer">
            <a class="fw-bold" href="{{ route('user.products', ['username' => $user->username]) }}">
                {{ count($user->ownedProducts) + count($user->products) - 5 }} more Products
            </a>
        </div>
    @endif
</div>
