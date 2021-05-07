<ul class="nav nav-pills justify-content-center align-items-center explore-nav bg-white py-3">
    <li class="nav-item px-1">
        <a class="nav-link @if (Route::currentRouteName() === 'explore.explore') active @endif" href="{{ route('explore.explore') }}">Popular Tasks</a>
    </li>
    @if (feature('explore_makers'))
    <li class="nav-item px-1">
        <a class="nav-link @if (Route::currentRouteName() === 'explore.makers') active @endif" href="{{ route('explore.makers') }}">Makers <x-beta /></a>
    </li>
    @endif
    @if (feature('explore_products'))
    <li class="nav-item px-1">
        <a class="nav-link" href="#">Products <x-staffship /></a>
    </li>
    @endif
</ul>
