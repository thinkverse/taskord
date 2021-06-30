<div class="mb-3">
    <h5>
        Badges
    </h5>
    @auth
        <a type="button" class="mb-2 btn btn-outline-success rounded-pill float-md-end"
            href="{{ route('products.new') }}">
            <x-heroicon-o-plus class="heroicon" />
            Add new badge
        </a>
    @endauth
</div>
