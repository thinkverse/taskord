<div>
    <div class="card mt-3 mb-2 w-75">
        <img src="{{ $oembed->thumbnail_url }}" class="card-img-top" alt="{{ $oembed->title }}">
        <div class="card-body">
            <div class="fw-bold">
                {{ $oembed->title }}
            </div>
            <div class="mt-1">
                {{ $oembed->description }}
            </div>
            <div class="mt-1 d-flex align-items-center">
                <img src="{{ $oembed->favicon }}" height="15" width="15" />
                <a class="ms-2 text-secondary" href="{{ $oembed->provider_url }}" target="_blank">
                    {{ $oembed->provider_name }}
                </a>
            </div>
        </div>
    </div>
</div>
