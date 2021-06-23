<div wire:init="loadTrendingMakers">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Trending Makers
        <x:labels.beta />
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (!$readyToLoad)
                <div class="card-body">
                    <x:loaders.user-skeleton count="5" />
                </div>
            @else
                @foreach ($users as $user)
                    <div class="d-flex align-items-center py-2 px-3">
                        <x:shared.user-label-with-bio :user="$user" />
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
