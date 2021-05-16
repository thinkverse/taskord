<div wire:init="loadLaunchedToday">
    @if (count($launched_today) > 0)
        <div class="pb-2 h5">
            <x-heroicon-o-lightning-bolt class="heroicon heroicon-20px ms-1 text-secondary" />
            Launched Today
        </div>
        <div class="card mb-4">
            <ul class="list-group list-group-flush">
                @foreach ($launched_today->take(5) as $product)
                    <li class="list-group-item p-3">
                        <livewire:product.single-product :product="$product" />
                    </li>
                @endforeach
            </ul>
            @if (count($launched_today) > 5)
                <div class="card-footer">
                    <a class="fw-bold" href="{{ route('products.newest') }}">More Products...</a>
                </div>
            @endif
        </div>
    @endif
</div>
