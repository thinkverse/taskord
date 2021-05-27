<div class="card">
    <div class="card-body d-flex align-items-center">
        <a href="{{ $product->avatar }}" target="_blank">
            <img loading=lazy class="rounded avatar-120" src="{{ Helper::getCDNImage($product->avatar, 240) }}" height="120" width="120" alt="{{ $product->slug }}'s avatar" />
        </a>
        <div class="ms-4">
            <div class="h5 mb-0">
                {{ $product->name }}
                @if ($product->launched)
                    <span class="ms-1 small" title="Launched">
                        🚀
                    </span>
                @endif
                @if ($product->deprecated)
                    <span class="staff" class="ms-1 small" title="Deprecated">
                        <x-heroicon-o-shield-exclamation class="heroicon text-danger" />
                    </span>
                @endif
                @can('staff_mode')
                    <span class="ms-1 text-secondary small">#{{ $product->id }}</span>
                @endcan
            </div>
            <div class="text-secondary mb-2">
                {{ "#" . $product->slug }}
            </div>
            @livewire('product.subscribe', [
                'product' => $product
            ])
            @if ($product->description)
                <div class="mt-3">
                    {{ $product->description }}
                </div>
            @endif
            <div class="small mt-3">
                <span>
                    <x-heroicon-o-calendar class="heroicon heroicon-15px text-secondary" />
                    @if ($product->launched)
                    <span>Launched at {{ carbon($product->launched_at)->format("F Y") }}</span>
                    @else
                    <span>Created at {{ $product->created_at->format("F Y") }}</span>
                    @endif
                </span>
                @if ($product->website)
                    <span class="ms-3">
                        <a class="text-dark" target="_blank" href="{{ $product->website }}" rel="noreferrer">
                            <img loading=lazy class="rounded sponsor-icon me-1" rel="preload" src="https://favicon.splitbee.io/?url={{ parse_url($product->website)['host'] }}" />
                            {{ $product->website }}
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a class="text-dark fw-bold me-4" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.done') text-primary @endif me-1">Done</span>
            <span class="small fw-normal text-secondary">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('product.pending', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.pending') text-primary @endif me-1">Pending</span>
            <span class="small fw-normal text-secondary">{{ number_format($pending_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4"href="{{ route('product.updates', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.updates') text-primary @endif me-1">Updates</span>
            <span class="small fw-normal text-secondary">{{ number_format($updates_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('feed.product', ['slug' => $product->slug]) }}" target="_blank">
            <span>
                <x-heroicon-o-rss class="heroicon text-secondary" />
                Feed
            </span>
        </a>
    </div>
</div>
