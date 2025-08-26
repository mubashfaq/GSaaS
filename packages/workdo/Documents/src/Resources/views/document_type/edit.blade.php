{{ Form::model($documentType, ['route' => ['documents-type.update', $documentType->id], 'method' => 'patch' , 'class' => 'needs-validation novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}<x-required />
            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Update') }}</button>
</div>
{{ Form::close() }}
