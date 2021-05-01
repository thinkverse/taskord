<span class="float-end">
    <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ auth()->user()->onlyFollowingsTasks ? 'checked' : '' }}>
    <label for="onlyFollowingsTasks" class="ms-1">
        Only following
    </label>
    <div wire:loading class="spinner-border taskord-spinner spinner-border-sm ms-1"></div>
</span>
