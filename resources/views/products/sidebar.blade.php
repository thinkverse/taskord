<div class="card mb-4">
    <div class="card-header">
        ✨ Active Products
    </div>
    <ul class="list-group list-group-flush">
        @foreach ($products as $product)
        <li class="list-group-item pb-2 pt-2">
            <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                <img class="rounded avatar-30 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
            </a>
            <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="ml-2 mr-2 align-text-top font-weight-bold text-dark">
                {{ $product->name }}
                @if ($product->launched)
                    <a href="{{ route('products.launched') }}" class="small" data-toggle="tooltip" data-placement="right" title="Launched">
                        {{ Emoji::rocket() }}
                    </a>
                @endif
            </a>
            <span class="small text-black-50 ml-3">
                <i class="fa fa-check text-success mr-1"></i>
                {{ $product->tasks->count('id') }}
                {{ $product->tasks->count('id') == 1 ? 'Task' : 'Tasks' }}
            </span>
            <span class="float-right">
                @foreach ($product->members()->limit(1)->get() as $user)
                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                    <img class="rounded-circle avatar-30 mr-1" src="{{ $user->avatar }}" />
                </a>
                @endforeach
                <a href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                    <img class="rounded-circle avatar-30 mr-0" src="{{ $product->owner->avatar }}" />
                </a>
                </a>
            </span>
        </li>
        @endforeach
    </ul>
</div>
