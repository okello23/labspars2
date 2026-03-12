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
            <label for="facility_id" class="form-label">Institution<small class="text-danger">*</small></label>
            <select class="form-control" id="facility_id" wire:model.lazy="facility_id">
              <option selected value="">Select...</option>
              @foreach ($facilities as $value)
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
</div>