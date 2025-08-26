@php($taskly = module_is_active('Taskly'))

{{ Form::model($documents, ['method' => 'patch', 'route' => ['documents.update', $documents->id], 'enctype' => 'multipart/form-data', 'class' => 'needs-validation novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 form-group">
            {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label']) }}<x-required />
            {{ Form::text('subject', $documents->subject, ['class' => 'form-control', 'required' => 'required']) }}
        </div>

        @if ($taskly)
            @if ($project_id != null)
                {{ Form::hidden('project_id', $project_id ?? '') }}
            @endif
            <div class="col-md-6 form-group">
                {{ Form::label('project_id', __('Project'), ['class' => 'col-form-label']) }}
                {{ Form::select('project_id', $projects, $documents->project_id ?? $project_id, ['class' => 'form-control', 'id' => 'project_id', 'placeholder' => 'Select Project', 'disabled' => $project_id != null ? true : false]) }}
            </div>
            <div class="col-md-6">
            @else
                <div class="col-md-12">
        @endif
        <div class="form-group">
            {{ Form::label('type', __('Type'), ['class' => 'col-form-label']) }}<x-required />
            {{ Form::select('type', $documentType, null, ['class' => 'form-control ', 'required' => 'required']) }}
            @if (count($documentType) <= 0)
                <div class="text-muted text-xs">
                    {{ __('Please create new contract type') }}
                    <a href="{{ route('contract_type.index') }}">{{ __('here') }}</a>.
                </div>
            @endif
        </div>
    </div>


    @if (\Auth::user()->type == 'company')
        <div class="col-md-12 form-group">
            {{ Form::label('user_id', __('User'), ['class' => 'col-form-label']) }}<x-required />
            {{ Form::select('user_id', $user, null, ['class' => 'form-control', 'id' => 'user_id', 'required' => 'required', 'placeholder' => 'Select User']) }}
        </div>
    @else
        {{ Form::hidden('user_id', \Auth::user()->id, null) }}
    @endif


    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('notes', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('notes', $documents->notes, ['class' => 'form-control']) }}
        </div>
    </div>
</div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Update') }}</button>
</div>
{{ Form::close() }}
