<div wire:init="loadRecentlyJoined">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Recently Joined
    </div>
    <div class="card mb-4">
        @if (!$readyToLoad)
        <div class="card-body text-center">
            <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
        </div>
        @endif
        <div class="card-body">
            @foreach ($recently_joined as $user)
                <div class="py-2">
                    <x:shared.user-label-with-bio :user="$user" />
                </div>
            @endforeach
        </div>
    </div>
</div>
