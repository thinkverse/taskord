<div wire:init="loadProducts">
    @if (!$readyToLoad)
        <div>
            <x:loaders.product-big-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.product-big-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.product-big-skeleton count="1" />
        </div>
    @endif
    @if ($readyToLoad and count($products) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-cube class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No products made
            </div>
        </div>
    @endif
    @foreach ($products as $product)
        <div class="card mb-2">
            <div class="card-body">
                <livewire:product.single-product :product="$product" :wire-key="$product->id" />
            </div>
        </div>
    @endforeach

    {{ $readyToLoad ? $products->links() : '' }}
</div>
