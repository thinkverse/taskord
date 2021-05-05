<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="newTaskModalLabel">
                    <span class="me-1">New task</span>
                    <x-beta />
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!auth()->user()->isFlagged)
                    @livewire('create-task')
                @endif
            </div>
        </div>
    </div>
</div>
