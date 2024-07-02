<div>
    <div class="modal fade" id="confirmModal_{{ $editRowId }}" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content cnf-mdl" style="background-color: #f8fcff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Update Unit(s) for row {{ $editRowId }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="font-size:30px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with existing Unit(s) (<strong>{{ $existingQty }}</strong>)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft-secondary" id="confirmCancelButton"
                        data-bs-dismiss="modal" wire:click="confirmAction(2)">No</button>
                    <button type="button" class="btn btn-soft-primary" id="confirmYesButton"
                        wire:click="confirmAction(1)">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#confirmModal_' + @json($editRowId)).modal({
            // backdrop: "static",
            keyboard: false
        }).modal('show');
    });
</script>
