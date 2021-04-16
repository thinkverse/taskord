<ul class="nav nav-pills justify-content-center mb-3">
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.users') active @endif" href="{{ route('admin.users') }}">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.tasks') active @endif" href="{{ route('admin.tasks') }}">Tasks</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.activities') active @endif" href="{{ route('admin.activities') }}">Activities</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.products') active @endif" href="{{ route('admin.products') }}">Products</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if (Route::currentRouteName() === 'admin.system') active @endif" href="{{ route('admin.system') }}">System</a>
    </li>
</ul>
