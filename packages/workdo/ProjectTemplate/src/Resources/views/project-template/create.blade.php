@php
    $button = ($type == 'template') ? __('Save as Template') : __('Convert to Project');
    $title = ($type == 'template') ? __('Template') : __('Project');
    $placeholder = ($type == 'template') ? __('Project Template') : __('Project');
@endphp
{{ Form::open(array('route' => 'project-template.store','enctype'=>'multipart/form-data','class'=>'needs-validation','novalidate')) }}
<div class="modal-body">
<div class="row">
    <div class="form-group col-md-12">
        {{ Form::label('name', __($title.' Name'),['class'=>'form-label']) }}<x-required></x-required>
        {{ Form::text('name', '', array('class' => 'form-control','required'=>'required','placeholder'=> __('Enter ').$placeholder.(' Name'))) }}
    </div>
    <input type="hidden" name="project_id" value="{{$projectId}}">
    <input type="hidden" name="type" value="{{$type}}">
</div>
</div>
<div class="modal-footer">
<input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{__($button)}}" class="btn  btn-primary" id="submit">
</div>
{{ Form::close() }}
