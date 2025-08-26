{{ Form::open(['route' => 'restaurant-customer.store', 'method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6 col-12">
            <div class="form-group">
                {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('Enter First Name'), 'required' => 'required']) }}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="form-group">
                {{ Form::label('last_name', __('Last Name'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Last Name'), 'required' => 'required']) }}
                @error('name')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="form-group">
                {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
                @error('email')
                    <small class="invalid-email" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <x-mobile divClass="col-sm-6 col-12" type="number" name="mobile_no" class="form-control"
            label="{{ __('Mobile No') }}" placeholder="{{ __('Enter User Mobile No') }}" required></x-mobile>


    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
