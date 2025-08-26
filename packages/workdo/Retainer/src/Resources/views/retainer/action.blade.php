@if($retainer->is_convert==0 && $retainer->status != 4)

        @permission('retainer convert invoice')
            <div class="action-btn me-2">
                {!! Form::open([
                    'method' => 'get',
                    'route' => ['retainer.convert_invoice', $retainer->id],
                    'id' => 'retainer-form-' . $retainer->id,
                ]) !!}
                <a href="#"
                   class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-success"
                   data-bs-toggle="tooltip" title=""
                   data-bs-original-title="{{ __('Convert To Invoice') }}"
                   aria-label="Delete"
                   data-text="{{ __('You want to confirm convert to Invoice. Press Yes to continue or No to go back') }}"
                   data-confirm-yes="proposal-form-{{ $retainer->id }}">
                    <i class="ti ti-exchange text-white"></i>
                </a>
                {{ Form::close() }}
            </div>
        @endpermission
    @else
        @permission('convert invoice')
            <div class="action-btn me-2">
                <a href="{{ route('invoice.show',\Crypt::encrypt($retainer->converted_invoice_id)) }}"
                   class="mx-3 btn btn-sm  align-items-center bg-success" data-bs-toggle="tooltip" title="{{__('Already Convert To Invoice')}}"
                   data-original-title="{{__('Already convert To Invoice')}}" data-original-title="{{__('Delete')}}">
                    <i class="ti ti-eye text-white"></i>
                </a>
            </div>
        @endpermission
    @endif

    @permission('retainer duplicate')
        <div class="action-btn me-2">
            {!! Form::open([
                'method' => 'get',
                'route' => ['retainer.duplicate', $retainer->id],
                'id' => 'duplicate-form-' . $retainer->id,
            ]) !!}
            <a href="#"
               class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-secondary"
               data-bs-toggle="tooltip" title=""
               data-bs-original-title="{{ __('Duplicate') }}"
               aria-label="Delete"
               data-text="{{ __('You want to confirm duplicate this retainer. Press Yes to continue or Cancel to go back') }}"
               data-confirm-yes="duplicate-form-{{ $retainer->id }}">
                <i class="ti ti-copy text-white text-white"></i>
            </a>
            {{ Form::close() }}
        </div>
    @endpermission

    @permission('retainer show')
        <div class="action-btn  me-2">
            <a href="{{ route('retainer.show',\Crypt::encrypt($retainer->id)) }}" class="mx-3 btn btn-sm  align-items-center bg-warning" data-bs-toggle="tooltip" title="{{__('Show')}}" data-original-title="{{__('Detail')}}">
                <i class="ti ti-eye text-white text-white"></i>
            </a>
        </div>
    @endpermission
    @if (module_is_active('ProductService') && ( ($retainer->retainer_module == 'taskly') ? module_is_active('Taskly') :  module_is_active('Account')))
        @permission('retainer edit')
            <div class="action-btn  me-2">
                <a href="{{ route('retainer.edit',\Crypt::encrypt($retainer->id)) }}" class="mx-3 btn btn-sm  align-items-center bg-info" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                    <i class="ti ti-pencil text-white"></i>
                </a>
            </div>
        @endpermission
    @endif
    @permission('retainer delete')
        <div class="action-btn">
            {{ Form::open(['route' => ['retainer.destroy', $retainer->id], 'class' => 'm-0']) }}
            @method('DELETE')
            <a href="#"
               class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm bg-danger"
               data-bs-toggle="tooltip" title=""
               data-bs-original-title="Delete" aria-label="Delete"
               data-confirm="{{ __('Are You Sure?') }}"
               data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
               data-confirm-yes="delete-form-{{ $retainer->id }}"><i
                    class="ti ti-trash text-white text-white"></i></a>
            {{ Form::close() }}
        </div>
    @endpermission
