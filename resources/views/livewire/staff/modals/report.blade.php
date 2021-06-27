<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="reportModal" tabindex="-1"
    aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="reportModalLabel">Report an Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill"
                    data-bs-dismiss="modal">Close</button>
                <button class="btn btn-outline-primary rounded-pill" wire:loading.attr="disabled" wire:click="report"
                    data-bs-dismiss="modal">
                    Report
                </button>
            </div>
        </div>
    </div>
</div>
