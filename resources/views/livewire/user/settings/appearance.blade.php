<div class="col-lg-8">
    <div class="card">
        <div class="card-header py-3">
            <span class="h5">Theme preferences</span>
            <div>Choose how Taskord looks to you.</div>
        </div>
        <div class="card-body d-flex">
            <div class="me-3 card {{ $user->darkMode ? '' : 'border-primary'  }}">
                <img class="rounded-top" src="https://github.githubassets.com/images/modules/settings/color_modes/light_preview.svg" />
                <div class="card-footer">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="lightMode" id="lightMode" wire:click="toggleMode('light')" {{ $user->darkMode ? '' : 'checked'  }}>
                        <label class="form-check-label" for="lightMode">
                            Default light
                        </label>
                    </div>
                </div>
            </div>
            <div class="card {{ $user->darkMode ? 'border-primary' : ''  }}">
                <img class="rounded-top" src="https://github.githubassets.com/images/modules/settings/color_modes/dark_preview.svg" />
                <div class="card-footer">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="darkMode" id="darkMode" wire:click="toggleMode('dark')" {{ $user->darkMode ? 'checked' : ''  }}>
                        <label class="form-check-label" for="darkMode">
                            Default dark
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
