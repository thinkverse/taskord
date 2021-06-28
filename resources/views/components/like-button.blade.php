<span>
    @php
        $liked = auth()
            ->user()
            ->hasLiked($entity);
    @endphp
    <button type="button" class="btn btn-action {{ $liked ? 'btn-like' : 'btn-outline-like' }}"
        wire:click="toggleLike" wire:loading.attr="disabled" wire:key="{{ $entity->id }}" aria-label="Likes">
        @if ($liked)
            <x-heroicon-s-heart class="heroicon heroicon-15px me-0" />
        @else
            <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
        @endif
        @if ($entity->likerscount() !== 0)
            <span class="small fw-bold">
                {{ number_format($entity->likerscount()) }}
            </span>
        @endif
    </button>
</span>
