<div>
    <span>
        removed you from the product
        <a class="fw-bold" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="20" width="20" />
            {{ $product->name }}
        </a>
    </span>
</div>
