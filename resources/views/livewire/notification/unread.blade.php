<div wire:init="loadUnreadNotifications">
    @if (!$readyToLoad)
        <x:loaders.notification-skeleton count="3" />
    @else
        @if (count($notifications) === 0)
            <div class="card-body text-center mt-5">
                <x-heroicon-o-bell class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    Inbox zero
                </div>
                <p class="text-secondary">
                    Congratulations, you have read all your notifications.
                </p>
            </div>
        @endif
        @foreach ($notifications as $notification)
            <div>
                @livewire('notification.single-notification', [
                'notificationId' => $notification->id,
                'type' => $notification->type,
                'data' => $notification->data,
                'createdAt' => $notification->created_at,
                'pageType' => 'unread',
                ], key($notification->id))
            </div>
        @endforeach
        @if ($notifications->hasMorePages())
            <livewire:notification.load-more type="unread" :page="$page" :perPage="$perPage" />
        @endif
    @endif
</div>
