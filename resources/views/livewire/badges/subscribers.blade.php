<div wire:init="loadSubscribers">
    @if (!$readyToLoad)
        <x:loaders.featured-makers-skeleton count="3" />
    @else
        <ul class="list-group list-group-flush">
            @foreach ($subscribers as $user)
                <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                    <x:shared.user-label-big :user="$user" />
                    <div class="d-flex">
                        @auth
                            <livewire:notification.follow :user="$user" />
                        @endauth
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
