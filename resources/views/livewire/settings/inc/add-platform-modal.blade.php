<div wire:ignore.self class="modal fade" id="addEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    @if ($createNew)
                        New Platform
                    @else
                        Update Platform
                    @endif
                </h5>
                <button type="button" class="btn-close" wire:click="close" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form
                    @if (!$toggleForm) wire:submit.prevent="store"
                      @else
                      wire:submit.prevent="update" @endif>

                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label required">Platform
                                Name:</label>
                            <input type="text" wire:model="name" id="name"
                                class="form-control">
                            @error('name')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="type" class="form-label required">Platform
                                Type:</label>
                            <select wire:model="type" id="type"
                                class="form-control">
                                <option value="">Choose Type</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Hematology">Hematology</option>
                                <option value="CD4">CD4</option>
                            </select>
                            @error('type')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="manufacturer"
                                class="form-label required">Manufacturer:</label>
                            <input type="text" wire:model="manufacturer" id="manufacturer"
                                class="form-control">
                                @error('manufacturer')
                                <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                        </div>                      
                        <div class="mb-4 col-md-6">
                            <label for="is_active" class="form-label required">Status:</label>
                            <select wire:model="is_active" id="is_active"
                                class="form-control">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            @error('is_active')
                            <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        <div class="modal-footer">
                            @if ($createNew)
                                <x-button class="btn-success">Save</x-button>
                            @else
                                <x-button class="btn-success">Update</x-button>
                            @endif
                            <x-button type="button" class="btn btn-danger" wire:click="close">Close</x-button>

                        </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
