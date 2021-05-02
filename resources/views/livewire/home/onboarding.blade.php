<div>
    @if ($task_count === 0 || $praise_count === 0 || $product_count === 0 || strlen($has_name) === 0)
    <div class="text-uppercase fw-bold text-secondary pb-2">
        👋 Getting Started
    </div>
    <div class="card border-success mb-4">
        <div class="card-body">
            <div class="progress mb-3" style="height: 25px;">
                <div
                    class="progress-bar progress-bar-striped"
                    role="progressbar"
                    @if ($completed === 0)
                        style="width:0%"
                    @elseif ($completed === 1)
                        style="width:25%"
                    @elseif ($completed === 2)
                        style="width:50%"
                    @elseif ($completed === 3)
                        style="width:75%"
                    @elseif ($completed === 4)
                        style="width:100%"
                    @endif
                ></div>
            </div>
            <div class="mb-3 text-secondary">
                Welcome to Taskord, here are some onboarding steps!
            </div>
            <a class="btn btn-blurple fw-bold mb-3 me-2" href="https://discord.gg/9M4Q65b" target="_blank" rel="noreferrer">
                <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/discord_tIPeQf-mNx.svg" />
                Join Taskord's Discord
            </a>
            <a class="btn btn-telegram fw-bold mb-3" href="https://t.me/taskordbot" target="_blank" rel="noreferrer">
                <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/telegram-white_aoBbjHlRg.svg" />
                Add Taskord bot
            </a>
            @if (preg_match('/^[a-f0-9]{32}$/', auth()->user()->username))
            <div class="mb-2">
                <input class="form-check-input" type="checkbox" disabled {{ $changed_username ? '' : 'checked' }}>
                <span class="ms-1">Change your username</span>
            </div>
            @endif
            <div class="mb-2">
                <input class="form-check-input" type="checkbox" disabled {{ strlen($has_name) === 0 ? '' : 'checked' }}>
                <span class="ms-1">Add your name</span>
            </div>
            <div class="mb-2">
                <input class="form-check-input" type="checkbox" disabled {{ $task_count === 0 ? '' : 'checked' }}>
                <span class="ms-1">Add a new task</span>
            </div>
            <div class="mb-2">
                <input class="form-check-input" type="checkbox" disabled {{ $praise_count === 0 ? '' : 'checked' }}>
                <span class="ms-1">Praise one task</span>
            </div>
            <div>
                <input class="form-check-input" type="checkbox" disabled {{ $product_count === 0 ? '' : 'checked' }}>
                <span class="ms-1">Add your product</span>
            </div>
        </div>
    </div>
    @endif
</div>
