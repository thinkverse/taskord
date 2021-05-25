<ul class="nav nav-pills justify-content-center mb-3">
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.stats') active @endif" href="{{ route('staff.stats') }}">
            <x-heroicon-o-chart-bar class="heroicon heroicon heroicon-18px" />
            Stats
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.users') active @endif" href="{{ route('staff.users') }}">
            <x-heroicon-o-users class="heroicon heroicon heroicon-18px" />
            Users
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.tasks') active @endif" href="{{ route('staff.tasks') }}">
            <x-heroicon-o-check-circle class="heroicon heroicon-18px" />
            Tasks
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.activities') active @endif" href="{{ route('staff.activities') }}">
            <x-heroicon-o-fire class="heroicon heroicon-18px" />
            Activities
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.products') active @endif" href="{{ route('staff.products') }}">
            <x-heroicon-o-cube class="heroicon heroicon-18px" />
            Products
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.system') active @endif" href="{{ route('staff.system') }}">
            <x-heroicon-o-chip class="heroicon heroicon-18px" />
            System
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.features') active @endif" href="{{ route('staff.features') }}">
            <x-heroicon-o-adjustments class="heroicon heroicon-18px" />
            Features
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'staff.jobs') active @endif" href="{{ route('staff.jobs') }}">
            <x-heroicon-o-collection class="heroicon heroicon-18px" />
            Jobs
        </a>
    </li>
</ul>
