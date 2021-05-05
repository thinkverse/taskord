<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                @if (!auth()->user()->isFlagged)
                    @livewire('create-task', [
                        'showNewTasks' => true
                    ])
                @endif
            </div>
        </div>
    </div>
</div>
