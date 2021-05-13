<div class="container my-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg d-flex justify-content-around">
            <span class="fw-bold">
                © {{ now()->year }} Taskord
            </span>
            <a href="{{ route('about') }}">
                About
            </a>
            <a href="https://status.taskord.com" target="_blank" rel="noreferrer">
                Status
            </a>
            <a href="https://dev.to/taskord" target="_blank" rel="noreferrer">
                Blog
            </a>
            <a href="/graphiql" target="_blank" rel="noreferrer">
                API
            </a>
            <a href="{{ route('contact') }}">
                Contact
            </a>
        </div>
        <div class="col-1 d-flex justify-content-around my-2">
            <img loading=lazy src="https://ik.imagekit.io/taskordimg/logo_8lLu9EPFa.svg" height="30" alt="Taskord Beta">
        </div>
        <div class="col-lg d-flex justify-content-around">
            <a href="{{ route('terms') }}">
                Terms
            </a>
            <a href="{{ route('privacy') }}">
                Privacy
            </a>
            <a href="{{ route('open') }}">
                Open
            </a>
            <a href="{{ route('sponsors') }}">
                Sponsors
            </a>
            <a href="/graphiql" target="_blank" rel="noreferrer">
                API
            </a>
            <a href="https://gitlab.com/yo/taskord" target="_blank" rel="noreferrer">
                GitLab
            </a>
            @auth
            @if (auth()->user()->staffShip)
            <span class="text-danger">
                Admin mode on
            </span>
            @endif
            @endauth
        </div>
    </div>
</div>
