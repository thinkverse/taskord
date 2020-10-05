<div class="text-black-50 d-block lh-lg sticky-footer">
    <span class="pr-2 font-weight-bold">
        © Taskord
    </span>
    @auth
    @if (Auth::user()->staffShip)
    <a class="pr-2" href="{{ route('about') }}">
        About
    </a>
    @endif
    @endauth
    <a class="pr-2" href="https://status.taskord.com" target="_blank">
        Status
    </a>
    <a class="pr-2" href="https://dev.to/taskord" target="_blank">
        Blog
    </a>
    <a class="pr-2" href="https://gitlab.com/taskord/taskord" target="_blank">
        GitLab
    </a>
    <a class="pr-2" href="{{ route('terms') }}">
        Terms
    </a>
    <a class="pr-2" href="{{ route('sponsors') }}">
        Sponsors
    </a>
    <a class="pr-2" href="https://forms.clickup.com/f/357rd-725/OL919ALCZ5V0ALREMH" target="_blank">
        Bug Report
    </a>
    @auth
    @if (Auth::user()->staffShip)
    <span class="pr-2 text-danger">
        Admin mode on
    </span>
    @endif
    @endauth
</div>
