<div class="card mt-3 mb-2 w-75">
    <div class="{{ $oembed->type !== 'summary_large_image' ? 'd-flex align-items-center' : '' }}">
        <div class="card-body d-flex align-items-center">
            <div class="me-4">
                <a href="{{ $oembed->url }}">
                    <div class="fw-bold text-dark">
                        {{ $oembed->title }}
                    </div>
                    <div class="mt-1 text-dark">
                        {{ $oembed->description }}
                    </div>
                </a>
                <div class="mt-1 d-flex align-items-center">
                    <img src="{{ Helper::getCDNImage($oembed->favicon, 20) }}" height="15" width="15" />
                    <a class="ms-2 text-secondary" href="{{ $oembed->provider_url }}" target="_blank">
                        {{ $oembed->provider_name }}
                    </a>
                </div>
            </div>
            @if ($oembed->thumbnail_url)
                @if ($oembed->type === 'summary_large_image')
                    <img class="card-img-top border-bottom" src="{{ Helper::getCDNImage($oembed->thumbnail_url) }}" alt="{{ $oembed->title }}">
                @else
                    <img class="rounded w-20" src="{{ Helper::getCDNImage($oembed->thumbnail_url) }}" alt="{{ $oembed->title }}">
                @endif
            @endif
        </div>
    </div>
</div>
