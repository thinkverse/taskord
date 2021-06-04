<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-cube class="heroicon heroicon-20px" />
        <span class="ms-1">Verify domain</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                {{ $txt_code }}
                <button type="submit" class="btn btn-outline-success rounded-pill">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
