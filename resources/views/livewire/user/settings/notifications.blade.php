<div class="col-lg-8">
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Notifications</span>
            <div>Choose how you receive notifications.</div>
        </div>
        <div class="card-body">
            <div>
                <div class="mb-2">Get all notifications via email</div>
                <input wire:click="mentionsEmail" id="mentionsEmail" class="form-check-input" type="checkbox" {{ $user->taskMentionedEmail ? 'checked' : '' }}>
                <label for="mentionsEmail" class="ms-1">Email</label>
            </div>
            <div>
                <div class="mb-2 mt-3">Get all notifications via web</div>
                <input wire:click="mentionsWeb" id="mentionsWeb" class="form-check-input" type="checkbox" {{ $user->taskMentionedWeb ? 'checked' : '' }}>
                <label for="mentionsWeb" class="ms-1">Web</label>
            </div>
        </div>
    </div>
</div>
