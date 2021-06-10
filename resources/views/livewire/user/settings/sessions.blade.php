<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Sessions</span>
            <div>This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.</div>
        </div>
        @if (count($sessions) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-identification class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    Nothing has been logged!
                </div>
            </div>
        @endif
        <ul class="list-group list-group-flush">
            @foreach ($sessions as $session)
                @php
                    $isMobile = is_numeric(strpos(strtolower($session->user_agent), "mobile"));
                @endphp
                <li class="list-group-item py-3 d-flex align-items-center">
                    <div>
                        {{ $isMobile ? 'true' : 'false' }}
                        <div class="h6">
                            {{ $session->ip_address }}
                        </div>
                        <div class="small">
                            Last accessed on {{ carbon($session->last_activity)->format('M d, Y') }}
                        </div>
                        <div class="mt-2 small text-secondary" title="{{ $session->user_agent }}">
                            User agent: {{ Str::limit($session->user_agent, 50) }}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
