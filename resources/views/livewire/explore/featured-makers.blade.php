<div wire:init="loadFeaturedMakers">
    @foreach ($users as $user)
        <div>
            <x:shared.user-label-big :user="$user" />
        </div>
    @endforeach
</div>
