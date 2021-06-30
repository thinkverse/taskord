@if (true)
    <div class="text-uppercase fw-bold text-secondary pb-2 d-flex align-items-center">
        <span>Announcement</span>
        <img src="https://ik.imagekit.io/taskordimg/gif/party-parrot.gif" class="avatar-15 ms-1" />
    </div>
    <div class="card border-success mb-4">
        <div class="card-body">
            <h5>
                <a class="text-dark" href="{{ route('badges.badges') }}">
                    <x-heroicon-o-tag class="heroicon heroicon-20px" />
                    Profile badges public beta
                </a>
            </h5>
            <p class="mb-0">
                <a href="{{ route('badges.badges') }}">Badges</a> are now available public beta 🎉
            </p>
            <img class="border container mt-3 p-0 rounded shadow w-75"
                src="https://ik.imagekit.io/taskordimg/ad/Screenshot_2021-06-30_at_5.49.21_PM.png">
        </div>
    </div>
@endif
