<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-cube class="heroicon heroicon-20px" />
        <span class="ms-1">Verify domain</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div>
                    <h5>Add a DNS TXT record</h5>
                    <p>
                       1. Create a TXT record in your DNS configuration for the following hostname:
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="personal-access-token" class="form-control @error('token') is-invalid @enderror" value="{{ $txt_code }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary js-clipboard" type="button" title="Copy" data-bs-toggle="tooltip" data-for="#personal-access-token">
                                <x-heroicon-o-clipboard-copy class="heroicon heroicon-18px"></x-heroicon-o-clipboard-copy>
                            </button>
                        </div>
                    </div>
                    <p>
                        2. Use this code as the value for the TXT record:
                    </p>
                    <div class="input-group mb-3">
                        <input type="text" id="personal-access-token" class="form-control @error('token') is-invalid @enderror" value="{{ $txt_code }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary js-clipboard" type="button" title="Copy" data-bs-toggle="tooltip" data-for="#personal-access-token">
                                <x-heroicon-o-clipboard-copy class="heroicon heroicon-18px"></x-heroicon-o-clipboard-copy>
                            </button>
                        </div>
                    </div>
                    <p>
                        3. Wait until your DNS configuration changes. This could take up to 72 hours.
                    </p>
                </div>
                <button type="submit" class="btn btn-outline-success rounded-pill">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
