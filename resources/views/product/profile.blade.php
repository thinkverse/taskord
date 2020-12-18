<div class="card">
    <div class="card-body d-flex align-items-center">
        <a href="{{ $product->avatar }}" data-lightbox="{{ $product->avatar }}" data-title="{{ $product->name }}'s Logo">
            <img class="rounded avatar-120" src="{{ $product->avatar }}" alt="{{ $product->slug }}'s avatar" />
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
                    <span class="ms-1 small" title="Deprecated">
                        <i class="fa fa-ghost text-danger"></i>
                    </span>
                @endif
                @auth
                @if (Auth::user()->staffShip)
                    <span class="ms-1 text-secondary small">#{{ $product->id }}</span>
                @endif
                @endauth
            </div>
            <div class="text-black-50 mb-2">
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
                    <i class="fa fa-calendar-alt me-1 text-black-50"></i>
                    @if ($product->launched)
                    <span>Launched at {{ Carbon::parse($product->launched_at)->format("F Y") }}</span>
                    @else
                    <span>Created at {{ Carbon::parse($product->created_at)->format("F Y") }}</span>
                    @endif
                </span>
                @if ($product->website)
                <span class="ms-3">
                    <a class="text-dark" target="_blank" href="{{ $product->website }}" rel="noreferrer">
                        <img class="rounded sponsor-icon me-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($product->website)['host'] }}.ico" />
                        {{ $product->website }}
                    </a>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a class="text-dark fw-bold me-4" href="{{ route('product.done', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.done') text-primary @endif">Done</span>
            <span class="small fw-normal text-black-50">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('product.pending', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.pending') text-primary @endif">Pending</span>
            <span class="small fw-normal text-black-50">{{ number_format($pending_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4"href="{{ route('product.updates', ['slug' => $product->slug]) }}">
            <span class="@if (Route::currentRouteName() === 'product.updates') text-primary @endif">Updates</span>
            <span class="small fw-normal text-black-50">{{ number_format($updates_count) }}</span>
        </a>
    </div>
</div>
