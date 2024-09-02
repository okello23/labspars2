<div>

  @section('title', 'Users')
  @include('livewire.layouts.partials.inc.create-resource')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">
          <div class="row mb-2">
            <div class="col-sm-12 mt-3">
              <div class="d-sm-flex align-items-center">
                <h5 class="mb-2 mb-sm-0">
                  @if (!$toggleForm)
                  System Users (<span class="text-danger fw-bold">{{ $users->total() }}</span>)
                  @include('livewire.layouts.partials.inc.filter-toggle')
                  @else
                  Edit User
                  @endif

                </h5>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">

          <form
          @if (!$toggleForm) wire:submit.prevent="storeUser"
          @else
          wire:submit.prevent="updateUser" @endif
          @if (!$createNew) hidden @endif>
          <div class="row">

            <!-- <div class="mb-3 col-md-3">
            <label for="emp_id" class="form-label">Emp-No</label>
            <input type="text" style="text-transform: uppercase" id="emp_id"
            class="form-control" wire:model.lazy="emp_id">
            @error('emp_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div> -->

          <div class="mb-3 col-md-3">
            <label for="title" class="form-label">Title<small class="text-danger">*</small></label>
            <select class="form-control select2" id="title" wire:model.lazy="title">
              <option value="" selected>Select</option>
              <option value="Mr">Mr</option>
              <option value="Mrs">Mrs</option>
              <option value="Ms">Ms</option>
              <option value="Miss">Miss</option>
              <option value="Dr">Dr</option>
              <option value="Eng">Eng</option>
              <option value="Prof">Prof</option>
            </select>
            @error('title')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="surname" class="form-label">Surname<small class="text-danger">*</small></label>
            <input type="text" id="surname" class="form-control" wire:model.defer="surname">
            @error('surname')
            <div class="text-danger text-small">{{ __($message) }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="first_name" class="form-label">First Name<small class="text-danger">*</small></label>
            <input type="text" id="first_name" class="form-control"
            wire:model.defer="first_name">
            @error('first_name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="other_name" class="form-label">Other Name</label>
            <input type="text" id="other_name" class="form-control"
            wire:model.defer="other_name">
            @error('other_name')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="usercontact" class="form-label">Contact<small class="text-danger">*</small></label>
            <input type="text" id="usercontact" class="form-control" wire:model.defer="contact">
            @error('contact')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="userEmail" class="form-label">Email<small class="text-danger">*</small></label>
            <input type="email" id="userEmail" class="form-control" wire:model.defer="email">
            @error('email')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="signature" class="form-label">Signature</label>
            <input type="file" id="signature" class="form-control" wire:model="signature">
            <div class="text-success text-small" wire:loading wire:target="signature">Uploading signature</div>
            @error('signature')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="is_active" class="form-label">Status<small class="text-danger">*</small></label>
            <select class="form-control select2" id="is_active" wire:model.lazy="is_active">
              <option selected value="">Select</option>
              <option value='1'>Active</option>
              <option value='0'>Inactive</option>
            </select>
            @error('is_active')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3 col-md-3">
            <label for="category" class="form-label">User Category<small class="text-danger">*</small></label>
            <select class="form-control" id="category" wire:model.lazy="category">
              <option selected value="">Select...</option>
              <option value='Internal'>Internal</option>
              <option value='Institution'>Institution</option>
            </select>
            @error('category')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">

            @if($category == 'Institution')
            <label for="institution_id" class="form-label">Institution<small class="text-danger">*</small></label>
            <select class="form-control" id="institution_id" wire:model.lazy="institution_id">
              <option selected value="">Select...</option>
              @foreach ($institutions as $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('institution_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror

            @else

            </select>

            @error('department_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
            @endif
          </div>

          @if (!$toggleForm)
          <div class="mb-3 col-md-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" id="password" class="form-control"
            placeholder="Auto-Generated" wire:model="password" readonly>
            @error('password')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>
          @endif
        </div>
        <div class="modal-footer">
          @if (!$toggleForm)
          <x-button class="btn-success">{{ __('Save') }}</x-button>
          @else
          <x-button class="btn-success">{{ __('Update') }}</x-button>
          @endif
        </div>
        <hr>
      </form>

      <div class="tab-content">
        <div class="row mb-0" @if (!$filter) hidden @endif>
          <h6>Filter Users</h6>

          <div class="mb-3 col-md-3">
            <label for="user_status" class="form-label">Status</label>
            <select wire:model="user_status" class="form-control select2" id="user_status">
              <option value="">Select</option>
              <option value="1">Active</option>
              <option value="0">Suspended</option>
            </select>
          </div>

        </div>
        <div class="row mb-0">


          <div class="mb-3 col-md-2">
            <label for="from_date" class="form-label">From Date</label>
            <input id="from_date" type="date" class="form-control"
            wire:model.lazy="from_date">
          </div>

          <div class="mb-3 col-md-2">
            <label for="to_date" class="form-label">To Date</label>
            <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
          </div>

          <div class="mb-3 col-md-2">
            <label for="perPage" class="form-label">Per Page</label>
            <select wire:model="perPage" class="form-control" id="perPage">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>

          <div class="mb-3 col-md-2">
            <label for="orderBy" class="form-label">OrderBy</label>
            <select wire:model="orderBy" class="form-control">
              <option value="name">Name</option>
              <option value="contact">Contact</option>
              <option value="email">Email</option>
              <option value="id">Latest</option>
              <option value="is_active">Status</option>
            </select>
          </div>

          <div class="mb-3 col-md-1">
            <label for="orderAsc" class="form-label">Order</label>
            <select wire:model="orderAsc" class="form-control" id="orderAsc">
              <option value="1">Asc</option>
              <option value="0">Desc</option>
            </select>
          </div>

          <div class="mb-3 col-md-3">
            <label for="search" class="form-label">Search</label>
            <input id="search" type="text" class="form-control"
            wire:model.debounce.300ms="search" placeholder="search">
          </div>
          <hr>
        </div>

        <div class="table-responsive">
          <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
            <thead>
              <tr>
                <th>No.</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>User Category</th>
                <th>Institution</th>
                <!-- <th>Department</th> -->
                <th>Status</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $key => $user)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user->fullName }}</td>
                <td>{{ $user->email ?? 'N/A' }}</td>
                <td>{{ $user->contact ?? 'N/A' }}</td>
                <td>{{ $user->category ?? 'N/A' }}</td>
                <td>{{ $user->institution?->name ?? 'CPHL' }}</td>
                <!-- <td>{{ $user->department?->name ?? '-' }}</td> -->
                @if ($user->is_active == 0)
                <td><span class="badge bg-danger">Suspended</span></td>
                @else
                <td><span class="badge bg-success">Active</span></td>
                @endif
                <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
                <td class="table-action">
                  <button class="action-ico btn btn-sm btn-success mx-1">
                    <i class="fa fa-edit"
                    wire:click="editdata({{ $user->id }})"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div> <!-- end preview-->
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="btn-group float-end">
                {{ $users->links('vendor.livewire.bootstrap') }}
              </div>
            </div>
          </div>
        </div> <!-- end tab-content-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
@push('scripts')
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
  window.addEventListener('livewire:load', () => {
    initializeSelect2();
  });

  $('#user_status').on('select2:select', function(e) {
    var data = e.params.data;
    @this.set('user_status', data.id);
  });

  $('#title').on('select2:select', function(e) {
    var data = e.params.data;
    @this.set('title', data.id);
  });

  $('#is_active').on('select2:select', function(e) {
    var data = e.params.data;
    @this.set('is_active', data.id);
  });

  window.addEventListener('livewire:update', () => {
    $('.select2').select2('destroy'); //destroy the previous instances of select2
    initializeSelect2();
  });

  function initializeSelect2() {

    $('.select2').each(function() {
      $(this).select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
        '100%' : 'style',
        placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : 'Select',
        allowClear: Boolean($(this).data('allow-clear')),
      });
    });
  }
</script>
@endpush
</div>
