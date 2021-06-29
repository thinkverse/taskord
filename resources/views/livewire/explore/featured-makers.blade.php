<div wire:init="loadFeaturedMakers">
    @foreach ($users as $user)
        <div class="d-flex align-items-center justify-content-between">
            <x:shared.user-label-big :user="$user" />
            <div>
                @livewire('notification.follow', [
                'user' => $user
                ])
            </div>
        </div>
    @endforeach
</div>
