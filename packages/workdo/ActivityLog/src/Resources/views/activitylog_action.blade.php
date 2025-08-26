@permission('activitylog delete')
    <div class="action-btn">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['activitylog.destroy', $activity->id],
            'id' => 'delete-form-' . $activity->id,
        ]) !!}
        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger" data-bs-toggle="tooltip"
            title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') }}"
            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"><i class="ti ti-trash text-white text-white"></i></a>
        {!! Form::close() !!}
    </div>
@endpermission
