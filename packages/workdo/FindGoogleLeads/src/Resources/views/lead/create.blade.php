{{ Form::open(array('route' => 'find-google-leads.store','class'=>'needs-validation','novalidate')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('title', __('Title'),['class'=>'col-form-label']) }}<x-required></x-required>
            {{ Form::text('title', '', array('class' => 'form-control','placeholder'=> __('Enter Title') ,'required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('keyword', __('Keyword'),['class'=>'col-form-label']) }}<x-required></x-required>
            {{ Form::text('keyword', '', array('class' => 'form-control','placeholder'=> __('Enter Keyword') ,'required'=>'required')) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('address', __('Address'),['class'=>'col-form-label']) }}<x-required></x-required>
            {{ Form::text('address', '', array('class' => 'form-control','placeholder'=> __('Enter Address') ,'required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>
</div>

{{ Form::close() }}
