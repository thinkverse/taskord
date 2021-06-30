<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-tag class="heroicon heroicon-20px" />
        <span class="ms-1">Create new badge</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name of the badge</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        placeholder="Digital nomad" wire:model.defer="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Color HEX</label>
                    <input type="text" class="form-control @error('color') is-invalid @enderror" placeholder="#6a63ec"
                        wire:model.defer="color">
                    @error('color')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Icon URL</label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror"
                        placeholder="https://example.com/icon.svg" wire:model.defer="icon">
                    @error('icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Create Badge
                </button>
            </div>
        </form>
    </div>
</div>
