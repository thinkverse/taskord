<div>
    @if ($product)
        <div class="mt-2 text-secondary">
            added you to the product
            <div class="card mt-3">
                <div class="card-body">
                    <livewire:product.single-product :product="$product" />
                </div>
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
