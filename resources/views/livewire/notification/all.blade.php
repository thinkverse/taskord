<div wire:init="loadAllNotifications">
    @if ($readyToLoad)
        <x:loaders.notification-skeleton count="3" />
    @else
        @if (count($notifications) === 0)
            <div class="card-body text-center mt-5">
                <x-heroicon-o-bell class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No notifications
                </div>
            </div>
        @endif
        @foreach ($notifications as $notification)
            <div>
                @livewire('notification.single-notification', [
                'notificationId' => $notification->id,
                'type' => $notification->type,
                'data' => $notification->data,
                'createdAt' => $notification->created_at,
                'pageType' => 'all',
                ], key($notification->id))
            </div>
        @endforeach

    @endif
</div>
