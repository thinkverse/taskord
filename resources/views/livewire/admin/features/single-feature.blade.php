<div class="card mb-3">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div>
            <h3>{{ $feature->name }}</h3>
            <code>{{ $feature->slug }}</code>
            <div class="mt-2">{{ $feature->description }}</div>
        </div>
        <div>
        <div class="form-check form-switch">
            <input class="form-check-input h3" type="checkbox" wire:click="toggleFeature" wire:model="status">
        </div>
        </div>
    </div>
</div>
