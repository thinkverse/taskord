<div class="card mb-2">
    <div class="card-body d-flex align-items-center">
        <span class="card d-inline-block" style="background: {{ $badge->color }}">
            <div class="p-4">
                <img class="avatar-40" src="{{ $badge->icon }}" />
            </div>
        </span>
        <div class="ms-3">
            <div class="h5">{{ $badge->title }}</div>
            <div class="text-secondary small mb-2">Created by {{ '@' . $badge->user->username }}</div>
            <div class="text-secondary">
                <span class="fw-bold">{{ $badge->subscribersCount() }}</span> people have this badge
            </div>
        </div>
    </div>
</div>
