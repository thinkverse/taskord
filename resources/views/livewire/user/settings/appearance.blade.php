<div class="col-lg-8">
    <div class="card">
        <div class="card-header py-3">
            <span class="h5">Theme preferences</span>
            <div>Choose how Taskord looks to you.</div>
        </div>
        <div class="card-body">
            <div>
                <div class="form-check">
                    <input wire:click="notificationsEmail" id="notificationsEmail" class="form-check-input" type="checkbox" {{ $user->notifications_email ? 'checked' : '' }}>
                    <label for="notificationsEmail" class="form-check-label">Email</label>
                </div>
            </div>
            <div>
                <div class="form-check">
                    <input wire:click="notificationsWeb" id="notificationsWeb" class="form-check-input" type="checkbox" {{ $user->notifications_web ? 'checked' : '' }}>
                    <label for="notificationsWeb" class="form-check-label">Web</label>
                </div>
            </div>
        </div>
    </div>
</div>
