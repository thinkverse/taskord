<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="h5 pt-3 pb-3 text-success card-header">
                <i class="fa fa-box-open mr-1"></i>
                Edit Product
            </div>
            <div class="card-body">
                @include('components.alert')
                <form wire:target="submit" wire:submit.prevent="submit">
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
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-link"></i>
                        </span>
                        <input type="text" value="{{ $website }}" class="form-control" placeholder="Website" wire:model.lazy="website">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-twitter"></i>
                        </span>
                        <input type="text" value="{{ $twitter }}" class="form-control" placeholder="Twitter" wire:model.lazy="twitter">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            @if (Auth::check() && Auth::user()->darkMode)
                            <i class="fa fa-github text-white"></i>
                            @else
                            <i class="fa fa-github"></i>
                            @endif
                        </span>
                        <input type="text" value="{{ $github }}" class="form-control" placeholder="GitHub" wire:model.lazy="github">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-product-hunt"></i>
                        </span>
                        <input type="text" value="{{ $producthunt }}" class="form-control" placeholder="Product Hunt" wire:model="producthunt">
                    </div>
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Status</div>
                        <input id="launched" class="form-check-input" type="checkbox" wire:model="launched" {{ $launched ? 'checked' : 'unchecked' }}>
                        <label for="launched" class="ml-1">This product is launched</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Save
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </form>
                <div class="h5 text-danger mt-3 mb-3">Danger Zone</div>
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
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card mb-4">
            <div class="card-header">
                Preview
            </div>
            <div class="d-flex list-group-item align-items-center p-3">
                <span class="rounded bg-secondary p-4 mt-1 ml-2" src="" height="50" width="50" /></span>
                <span class="ml-3">
                    <span class="mr-2 h5 align-text-top font-weight-bold text-dark">
                        {{ $name ? $name : 'Product Name' }}
                        <span class="small ml-2">{{ $launched ? '🚀' : '' }}</span>
                    </span>
                    <div>{{ $description ? $description : 'Product Description' }}</div>
                    <button class="btn btn-sm btn-primary mt-2">
                        <i class="fa fa-plus mr-1"></i>
                        Subscribe
                    </button>
                </span>
                <img class="ml-auto rounded-circle float-right avatar-30 mt-1 ml-2" src="@auth{{ Auth::user()->avatar }}@endauth" />
            </div>
        </div>
        @include('components.footer')
    </div>
</div>
