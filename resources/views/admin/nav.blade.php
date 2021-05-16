<ul class="nav nav-pills justify-content-center mb-3">
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.stats') active @endif" href="{{ route('admin.stats') }}">
            <x-heroicon-o-chart-bar class="heroicon heroicon heroicon-1x" />
            Stats
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.users') active @endif" href="{{ route('admin.users') }}">
            <x-heroicon-o-users class="heroicon heroicon heroicon-1x" />
            Users
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.tasks') active @endif" href="{{ route('admin.tasks') }}">
            <x-heroicon-o-check-circle class="heroicon heroicon-1x" />
            Tasks
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.activities') active @endif" href="{{ route('admin.activities') }}">
            <x-heroicon-o-fire class="heroicon heroicon-1x" />
            Activities
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.products') active @endif" href="{{ route('admin.products') }}">
            <x-heroicon-o-cube class="heroicon heroicon-1x" />
            Products
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.system') active @endif" href="{{ route('admin.system') }}">
            <x-heroicon-o-chip class="heroicon heroicon-1x" />
            System
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.features') active @endif" href="{{ route('admin.features') }}">
            <x-heroicon-o-adjustments class="heroicon heroicon-1x" />
            Features
        </a>
    </li>
</ul>
