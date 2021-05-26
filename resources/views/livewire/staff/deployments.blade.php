<div class="card" wire:init="loadUsers">
    <div class="card-header h6 py-3">
        <div class="h5">Deployments</div>
        Deployments happend on Taskord
    </div>
    <div class="px-3">
        @if (!$readyToLoad)
            <div class="card-body text-center mt-3">
                <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                <div class="h6">
                    Loading users...
                </div>
            </div>
        @else
            {{ $deployments }}
            {{-- @foreach ($users as $user)
                <div class="card mt-3">
                    Hi
                </div>
            @endforeach --}}
        @endif
    </div>
</div>
