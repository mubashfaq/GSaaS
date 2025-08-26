{{ Form::open(['route' => 'consignment-contract.store', 'method' => 'post', 'enctype' => 'multipart/form-data' , 'class' => 'needs-validation','novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('party_a', __('Customers'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('party_a', $customers ,  null, ['class' => 'form-control', 'placeholder' => __('Select Party A'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('party_b', __('Company'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::text('party_b', $company->name , ['class' => 'form-control', 'required' => 'required' , 'readonly' => 'readonly']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('contract_type', __('Contract Type'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::select('contract_type', $contractType , null, ['class' => 'form-control', 'placeholder' => __('Select Contract Type'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{ Form::label('terms_and_conditions', __('Terms and Conditions'), ['class' => 'form-label']) }}
                {{ Form::textarea('terms_and_conditions', null, ['class' => 'form-control', 'placeholder' => __('Enter Terms and Conditions') , 'rows' => 3]) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancle') }}</button>
        {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary ']) }}{{ Form::close() }}
    </div>
</div>
{{ Form::close() }}
