<div wire:ignore.self class="modal" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    @include('components.alert')
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Name of the product</label>
                        <input type="text" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Simply the name of the product" wire:model="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Slug</label>
                        <input type="text" value="{{ $slug }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Product Slug (/taskord)" wire:model="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Some words about your awesome product" wire:model="description">{{ $description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Logo</label>
                        <div class="form-file w-50">
                            <input type="file" wire:model="avatar" class="form-file-input">
                            <label class="form-file-label">
                                <span class="form-file-text">Choose file...</span>
                                <span class="form-file-button">Browse</span>
                            </label>
                        </div>
                    </div>
                    <div wire:loading wire:target="avatar">
                        <div class="spinner-border spinner-border-sm" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @error('avatar')
                    <div class="text-danger font-weight-bold mt-3">{{ $message }}</div>
                    @else
                    @if ($avatar)
                    <div>
                        <img class="avatar-100 rounded mb-3" src="{{ $avatar->temporaryUrl() }}">
                    </div>
                    @else
                    @if ($product->avatar)
                    <div>
                        <img class="avatar-100 rounded mb-3" src="{{ $product->avatar }}" />
                    </div>
                    @endif
                    @endif
                    @enderror
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-link"></i>
                        </span>
                        <input type="text" value="{{ $website }}" class="form-control @error('website') is-invalid @enderror" placeholder="Website" wire:model.defer="website">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-twitter"></i>
                        </span>
                        <input type="text" value="{{ $twitter }}" class="form-control @error('twitter') is-invalid @enderror" placeholder="Twitter" wire:model.defer="twitter">
                        @error('twitter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-github"></i>
                        </span>
                        <input type="text" value="{{ $github }}" class="form-control @error('github') is-invalid @enderror" placeholder="GitHub" wire:model.defer="github">
                        @error('github')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-product-hunt"></i>
                        </span>
                        <input type="text" value="{{ $producthunt }}" class="form-control @error('producthunt') is-invalid @enderror" placeholder="Product Hunt" wire:model.defer="producthunt">
                        @error('producthunt')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Status</div>
                        <input id="launched" class="form-check-input" type="checkbox" wire:model.defer="launched">
                        <label for="launched" class="ml-1">This product is launched</label>
                    </div>
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Deprecated</div>
                        <input id="deprecated" class="form-check-input" type="checkbox" wire:model.defer="deprecated">
                        <label for="deprecated" class="ml-1">This product is no longer available</label>
                    </div>
                </div>
                <div class="modal-footer">
                    @if ($confirming === $product->id)
                    <button type="button" wire:click="deleteProduct" class="btn btn-danger">
                        <span class="font-weight-bold">Are you sure?</span>
                        <span wire:target="deleteProduct" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                    @else
                    <button type="button" wire:click="confirmDelete" class="btn btn-danger">
                        <span class="font-weight-bold">Delete</span> {{ $slug }}
                    </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Update
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
