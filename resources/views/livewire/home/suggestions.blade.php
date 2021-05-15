<div wire:init="loadSuggestions">
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Who to follow <x-new />
    </div>
    <div class="card mb-4">
        @if (!$readyToLoad)
        <div class="card-body text-center">
            <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
        </div>
        @endif
        @if ($readyToLoad and count($users) === 0)
        <div class="card-body text-center fw-bold text-secondary">
            <x-heroicon-o-user class="heroicon-2x text-primary" />
            Nothing to suggest!
        </div>
        @endif
        <ul class="list-group list-group-flush">
            @foreach ($users as $user)
            <li class="list-group-item d-flex align-items-center justify-content-between py-2" wire:key="{{ $user->id }}">
                <x:shared.user :user="$user" />
                <span>
                    <livewire:home.follow :user="$user" :showText="$showText" :wire:key="$user->id" />
                </span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
