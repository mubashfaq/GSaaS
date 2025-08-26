{{ Form::open(['route' => 'restaurant-offers.store', 'method' => 'post', 'class'=>'needs-validation','novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('name', __('Offer Name'), ['class' => 'col-form-label']) }}<x-required></x-required>
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Name')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('discount', __('Discount Percentage'), ['class' => 'col-form-label']) }}<x-required></x-required>
                {{ Form::text('discount',null, ['class' => 'form-control ', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}<x-required></x-required>
                {{ Form::date('start_date', date('Y-m-d'), ['class' => 'form-control ','required' => 'required', 'placeholder' => 'Select Date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}<x-required></x-required>
                {{ Form::date('end_date', date('Y-m-d'), ['class' => 'form-control ','required' => 'required', 'placeholder' => 'Select Date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('items', __('Items'), ['class' => 'col-form-label']) }}
                {!! Form::select('items',$items,null, ['class' => 'form-control','placeholder' => __('Select Items')]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
                <div class="d-flex radio-check">
                    <div class="form-check form-check-inline form-group col-md-3">
                        <input type="radio" id="active" value="active" name="status" class="form-check-input code" checked="checked">
                        <label class="custom-control-label" for="active">{{ __('Active') }}</label>
                    </div>
                    <div class="form-check form-check-inline form-group col-md-3">
                        <input type="radio" id="in_active" value="Inactive" name="status" class="form-check-input code">
                        <label class="custom-control-label" for="in_active">{{ __('InActive') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}
