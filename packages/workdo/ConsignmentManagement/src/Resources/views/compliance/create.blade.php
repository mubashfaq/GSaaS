{{ Form::open(['route' => 'consignment-compliance.store', 'method' => 'post', 'enctype' => 'multipart/form-data' , 'class' => 'needs-validation','novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('related_entity', __('Related Entity'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('related_entity', null, ['class' => 'form-control', 'placeholder' => __('Enter Related Entity'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('compliance_type', __('Compliance Type'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('compliance_type', null , ['class' => 'form-control', 'required' => 'required' , 'placeholder' => __('Enter Compliance Type')]) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('status', $status , null, ['class' => 'form-control', 'required' => 'required' ,'placeholder' => __('Select Status')]) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('report_date', __('Report Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('report_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('remarks', __('Remarks'), ['class' => 'form-label']) }}
                {{ Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder' => __('Enter Remarks') , 'rows' => 3]) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancle') }}</button>
        {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary ']) }}{{ Form::close() }}
    </div>
</div>
{{ Form::close() }}
