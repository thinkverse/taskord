<div wire:init="loadFeaturedMakers">
    <ul class="list-group list-group-flush">
        @foreach ($users as $user)
            <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                <x:shared.user-label-big :user="$user" />
                <div>
                    <livewire:notification.follow :user="$user" />
                    @if ($user->sponsor)
                        <a class="btn btn-sm btn-outline-primary rounded-pill mt-2" href="{{ $user->sponsor }}"
                            target="_blank" rel="noreferrer">
                            <img loading=lazy class="rounded sponsor-icon me-1" rel="preload"
                                src="https://favicon.splitbee.io/?url={{ parse_url($user->sponsor)['host'] }}" />
                            <span>Sponsor <span class="fw-bold">{{ '@' . $user->username }}</span></span>
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>
