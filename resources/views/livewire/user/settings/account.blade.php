<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Account</span>
            <div>Change your username and email.</div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updateAccount">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon3">https://taskord.com/@</span>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}" wire:model="username">
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" wire:model="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Vacation mode</span>
            <div>
                When turned on, your streaks will remain intact even if you don't create a task.
                <x-beta />
            </div>
        </div>
        <div class="card-body">
            <div class="form-check">
                <input wire:click="toggleVacationMode" id="toggleVacationMode" class="form-check-input" type="checkbox" {{ $user->vacation_mode ? 'checked' : '' }}>
                <label for="toggleVacationMode" class="ms-1">Enable vacation mode</label>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Beta</span>
            <div>
                Get release earlier.
                <x-beta />
            </div>
        </div>
        <div class="card-body">
            <input wire:click="enrollBeta" id="enrollBeta" class="form-check-input" type="checkbox" {{ $user->isBeta ? 'checked' : '' }}>
            <label for="enrollBeta" class="ms-1">Enroll to Beta</label>
        </div>
    </div>
    <div class="card">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Private Tasks</span>
            <div>
                All your tasks will hidden from public.
                <x-beta />
            </div>
        </div>
        <div class="card-body">
            @if ($user->isPatron)
            <input wire:click="enrollPrivate" id="enrollPrivate" class="form-check-input" type="checkbox" {{ $user->isPrivate ? 'checked' : '' }}>
            <label for="enrollPrivate" class="ms-1">Hide all tasks from public</label>
            @else
            <a class="btn btn-success text-white" href={{ route('patron.home') }}>
                Support Taskord
            </a>
            @endif
        </div>
    </div>
</div>
