<div wire:init="loadFeaturedMakers">
    @foreach ($users as $user)
        <li>{{ $user->username }} {{ $user->featured_at }}</li>
    @endforeach
</div>
