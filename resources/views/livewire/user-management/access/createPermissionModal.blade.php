 <!-- ADD NEW Role Modal -->

 <div class="modal fade" id="addPermission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Create New Permission</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
             </div> <!-- end modal header -->
             <div class="modal-body">
                 <form method="POST" action="{{ route('user-permissions.store') }}">
                     @csrf

                     <div class="row">
                         <div class="mb-3 col-md-6">
                             <label for="name" class="form-label">Name/Code</label>
                             <input type="text" id="name" class="form-control" name="name"
                                 placeholder="this-will-be-the-code-name" required>
                         </div>
                         <div class="mb-3 col-md-6">
                             <label for="display_name" class="form-label">Display Name</label>
                             <input type="text" id="display_name" class="form-control" name="display_name"
                                 placeholder="Edit user profile" required>
                         </div>
                         <div class="mb-3 col-md-12">
                             <label for="description" class="form-label">Description</label>
                             <textarea type="email" id="description" class="form-control" name="description"
                                 placeholder="Some description for the permission"></textarea>
                         </div>
                     </div>
                     <!-- end row-->
                     <div class="modal-footer">
                         <x-button>{{ __('Save') }}</x-button>
                         <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('Close') }}
                         </x-button>
                     </div>
                 </form>
             </div>
         </div> <!-- end modal content-->
     </div> <!-- end modal dialog-->
 </div> <!-- end modal-->
