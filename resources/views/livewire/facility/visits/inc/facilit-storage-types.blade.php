   <div wire:ignore.self class="modal fade" id="storageModal" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-storage_type_id" id="defaultModalLabel">
                       @if (!$toggleForm)
                           Add
                       @else 
                           Update
                       @endif a Storage Type
                   </h5>
               </div>
               <form
                   @if ($toggleForm) wire:submit.prevent="updateStorageType" @else wire:submit.prevent="storeStorageType" @endif>
                   <div class="modal-body">
                       <div class="row">
                           <div class="mb-3 col">
                               <label for="storage_type_id" class="form-label required">Store</label>
                               <select id="storage_type_id" class="form-control" name="storage_type_id" required
                                   wire:model="storage_type_id">
                                   <option value="">Select</option>
                                   @foreach ($storageTypes as $storageType)
                                       <option value="{{ $storageType->id }}">{{ $storageType->name }}</option>
                                   @endforeach
                               </select>
                               @error('storage_type_id')
                                   <div class="text-danger text-small">{{ $message }}</div>
                               @enderror
                           </div>
                           @if ($storage_type_id == 6)
                               <div class="mb-3 col-md-6">
                                   <label for="name" class="form-label required">Name</label>
                                   <input type="text" id="name" class="form-control" name="name" required
                                       wire:model.defer="name">
                                   @error('name')
                                       <div class="text-danger text-small">{{ $message }}</div>
                                   @enderror
                               </div>
                           @endif
                           <div class="mb-3 col-md-12">
                               <label for="comment" class="form-label required">Comment</label>
                               <textarea id="comment" class="form-control" name="comment" required
                                   wire:model.defer="comment"></textarea>
                               @error('comment')
                                   <div class="text-danger text-small">{{ $message }}</div>
                               @enderror
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                           wire:click="close()">{{ __('close') }}</button>
                       @if ($toggleForm)
                           <x-button type="submit" class="btn-success btn-sm">{{ __('Update') }}</x-button>
                       @else
                           <x-button type="submit" class="btn-success btn-sm">{{ __('Save') }}</x-button>
                       @endif
                   </div><!--end modal-footer-->
               </form>

           </div>
       </div>
   </div>
