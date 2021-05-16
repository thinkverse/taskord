<div wire:init="loadUnreadNotifications">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading notifications...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($notifications) === 0)
        <div class="card-body text-center mt-5">
            <x-heroicon-o-bell class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                All caught up!
            </div>
        </div>
    @endif
    @foreach ($notifications as $notification)
        <div>
            @livewire('notification.single-notification', [
                'notification_id' => $notification->id,
                'type' => $notification->type,
                'data' => $notification->data,
                'created_at' => $notification->created_at,
                'page_type' => 'unread',
            ], key($notification->id))
        </div>
    @endforeach
    @if ($readyToLoad and $notifications->hasMorePages())
        @livewire('notification.load-more', [
            'type' => 'unread',
            'page' => $page,
            'perPage' => $perPage
        ])
    @endif
</div>
