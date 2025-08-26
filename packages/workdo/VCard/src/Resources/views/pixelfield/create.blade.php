{{Form::open(array('route'=>'pixel.store','method'=>'post','class'=>'needs-validation','novalidate'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group col-md-12">
                {{ Form::label('platform', __('Platform'),['class'=>'form-label']) }}<x-required></x-required>
                {!! Form::select('platform', $pixals_platforms, null,array('class' => 'form-control select2','required'=>'required')) !!}
                @error('platform')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group col-md-12">
                {{Form::label('pixel_id',__('Pixel ID'))}}<x-required></x-required>
                {{Form::text('pixel_id',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Pixel ID')))}}
                @error('pixel_id')
                <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        </div>
        <input type="hidden" name="business_id" value="{{ $business_id }}">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}

