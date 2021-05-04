<div wire:init="loadProducts">
    @if (!$readyToLoad)
    <div class="card-body text-center mt-3 mb-3">
        <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
        <div class="h6">
            Loading products...
        </div>
    </div>
    @endif
    @if ($readyToLoad and count($products) === 0)
    <div class="card-body text-center mt-3 mb-3">
        <x-heroicon-o-cube class="heroicon-4x text-primary mb-2" />
        <div class="h4">
            No products made
        </div>
    </div>
    @endif
    @foreach ($products as $product)
    <div class="card mb-2">
        <div class="card-body d-flex align-items-center">
            <img loading=lazy class="rounded avatar-50" src="{{ Helper::getCDNImage($product->avatar, 80) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
            <span class="ms-3">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="me-2 h5 align-text-top fw-bold text-dark">
                    {{ $product->name }}
                </a>
                <div class="pe-5">{{ $product->description }}</div>
            </span>
            <span class="d-flex ms-auto">
                @if ($product->members()->count() > 1)
                    <span class="me-2 text-secondary fw-bold">+{{ $product->members()->count() - 1 }} more</span>
                @endif
                @foreach ($product->members()->limit(1)->get() as $user)
                <a
                    href="{{ route('user.done', ['username' => $user->username]) }}"
                    class="user-popover"
                    data-id="{{ $user->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 me-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30" alt="{{ $user->username }}'s avatar" />
                </a>
                @endforeach
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="user-popover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30 me-0" src="{{ Helper::getCDNImage($product->owner->avatar, 80) }}" height="30" width="30" alt="{{ $product->owner->username }}'s avatar" />
                </a>
            </span>
        </div>
    </div>
    @endforeach

    {{ $readyToLoad ? $products->links() : '' }}
</div>
