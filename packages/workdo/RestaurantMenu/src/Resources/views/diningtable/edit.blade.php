{{ Form::model($diningTable, array('route' => array('restaurant-dining-table.update', $diningTable->id), 'method' => 'PUT','enctype'=>'multipart/form-data', 'class'=>'needs-validation','novalidate')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6 col-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Name')]) }}
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="form-group">
                {{ Form::label('size', __('Size'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('size',null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => __('Enter Size')]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <div class="d-flex radio-check">
                    <div class="form-check form-check-inline">
                        <input type="radio" id="active" value="active" {{isset($diningTable->status) && $diningTable->status == 'active' ? 'checked' : ''}} name="status" class="form-check-input code" checked="checked">
                        <label class="custom-control-label" for="active">{{ __('Active') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="in_active" value="Inactive" {{isset($diningTable->status) && $diningTable->status == 'Inactive' ? 'checked' : ''}} name="status" class="form-check-input code">
                        <label class="custom-control-label" for="in_active">{{ __('InActive') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Update'),array('class'=>'btn btn-primary '))}}
    {{Form::close()}}
</div>
{{ Form::close() }}
