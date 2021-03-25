<ul class="nav nav-pills justify-content-center align-items-center explore-nav bg-white py-3">
    <li class="nav-item">
        <a class="nav-link px-2 py-1 @if (Route::currentRouteName() === 'explore.explore') active @endif" href="{{ route('explore.explore') }}">Popular Tasks</a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-2 py-1 @if (Route::currentRouteName() === 'explore.makers') active @endif" href="{{ route('explore.makers') }}">Makers <x-beta background="light" /></a>
    </li>
    @auth
    @if (auth()->user()->staffShip)
    <li class="nav-item">
        <a class="nav-link px-2 py-1" href="#">Products <x-staffship background="light" /></a>
    </li>
    <li class="nav-item">
        <a class="nav-link px-2 py-1" href="#">Tasks <x-staffship background="light" /></a>
    </li>
    @endif
    @endauth
</ul>
