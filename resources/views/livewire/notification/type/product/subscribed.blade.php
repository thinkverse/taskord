<div>
    @if ($product)
    <div class="mt-2 text-black-50">
        subscribed to your product
        <a class="fw-bold" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="20" width="20" />
            {{ $product->name }}
        </a>
    </div>
    @else
    <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
