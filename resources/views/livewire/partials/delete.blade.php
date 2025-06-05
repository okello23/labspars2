
@if ($model)
<div class="modal-backdrop fade show"></div>
<div class="modal d-block">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" wire:click="close()">Cancel</button>
                <button class="btn btn-danger" wire:click="deleteRecord">Delete</button>
            </div>
        </div>
    </div>
</div>
@endif