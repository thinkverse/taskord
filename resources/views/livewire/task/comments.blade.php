<div wire:init="loadComments" class="pt-3">
    <div class="card">
        <div class="card-body">
            @if ($readyToLoad)
                {{$comments}}
            @else
                Loading
            @endif
        </div>
    </div>
</div>
