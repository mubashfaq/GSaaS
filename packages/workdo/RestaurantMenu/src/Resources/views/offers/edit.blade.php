{{ Form::model($offers, array('route' => array('restaurant-offers.update', $offers->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'class'=>'needs-validation','novalidate')) }}
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
                {{ Form::date('start_date', isset($offers->start_date) ? $offers->start_date : '', ['class' => 'form-control ','required' => 'required', 'placeholder' => 'Select Date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}<x-required></x-required>
                {{ Form::date('end_date', isset($offers->end_date) ? $offers->end_date : '', ['class' => 'form-control ','required' => 'required', 'placeholder' => 'Select Date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('items', __('Items'), ['class' => 'col-form-label']) }}
                {!! Form::select('items',$items,isset($offers->items) ? $offers->items : '', ['class' => 'form-control','placeholder' => __('Select Items')]) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
                <div class="d-flex radio-check">
                    <div class="form-check form-check-inline form-group col-md-3">
                        <input type="radio" id="active" value="active" {{isset($offers->status) && $offers->status == 'active' ? 'checked' : ''}} name="status" class="form-check-input code" checked="checked">
                        <label class="custom-control-label" for="active">{{ __('Active') }}</label>
                    </div>
                    <div class="form-check form-check-inline form-group col-md-3">
                        <input type="radio" id="in_active" value="Inactive" {{isset($offers->status) && $offers->status == 'Inactive' ? 'checked' : ''}} name="status" class="form-check-input code">
                        <label class="custom-control-label" for="in_active">{{ __('InActive') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary '))}}
    {{Form::close()}}
</div>
{{ Form::close() }}
