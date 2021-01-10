<ul class="nav nav-pills justify-content-center explore-nav bg-white py-3">
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'explore') active @endif" href="{{ route('explore') }}">Popular Tasks</a>
    </li>
    @auth
    @if (auth()->user()->staffShip)
    <li class="nav-item">
        <a class="nav-link" href="#">Makers</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Products</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Tasks</a>
    </li>
    @endif
    @endauth
</ul>
