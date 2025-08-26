@extends('layouts.main')
@section('page-title')
    {{ __('Manage Cases') }}
@endsection
@section('title')
   {{ __('Common Cases') }}
@endsection
@section('page-breadcrumb')
    {{__('Case')}}
@endsection
@push('scripts')
<script src="{{ asset('js/letter.avatar.js') }}"></script>
@endpush
@section('page-action')
<div class="d-flex">
    <a href="{{ route('commoncases.index') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip"
    title="{{ __('List View') }}">
    <i class="ti ti-list text-white"></i>
    </a>

    @permission('case create')
    <a href="#" data-size="lg" data-url="{{ route('commoncases.create', ['commoncases', 0]) }}" data-ajax-popup="true"
    data-bs-toggle="tooltip" data-title="{{ __('Create New Case') }}"title="{{ __('Create') }}" class="btn btn-sm btn-primary btn-icon">
    <i class="ti ti-plus"></i>
    </a>
    @endpermission
</div>
@endsection
@section('filter')
@endsection
@section('content')
<div class="row">
    @foreach ($commonCases as $commonCase)
        <div class="col-md-3 d-flex">
            <div class="card w-100">
                <div class="card-header border-0 pb-0">
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="feather icon-more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if (Laratrust::hasPermission('case show') || Laratrust::hasPermission('case edit') || Laratrust::hasPermission('case delete'))

                                @permission('case edit')
                                    <a href="{{ route('commoncases.edit', $commonCase->id) }}"
                                        class="dropdown-item" data-bs-whatever="{{ __('Edit Common case') }}"
                                        data-bs-toggle="tooltip" data-title="{{ __('Edit Common case') }}"><i class="ti ti-pencil"></i>
                                        {{ __('Edit') }}</a>
                                @endpermission
                                @permission('case show')
                                    <a href="#" data-url="{{ route('commoncases.show', $commonCase->id) }}"
                                        data-ajax-popup="true" data-size="md"class="dropdown-item"
                                        data-bs-whatever="{{ __('Common case Details') }}"
                                        data-bs-toggle="tooltip" data-title="{{ __('Cases Details') }}"><i class="ti ti-eye"></i>
                                        {{ __('Details') }}</a>
                                @endpermission

                                @permission('case delete')
                                {!! Form::open(['method' => 'DELETE', 'route' => ['commoncases.destroy', $commonCase->id]]) !!}
                                <a href="#!" class="dropdown-item  show_confirm" data-bs-toggle="tooltip" data-confirm="{{ __('Are You Sure?') }}"
                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}">
                                    <i class="ti ti-trash"></i> {{ __('Delete') }}
                                </a>
                                {!! Form::close() !!}

                                @endpermission
                                 @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-2 justify-content-between">
                        <div class="col-12">
                            <div class="text-center client-box">
                                <div class="avatar-parent-child">
                                    <img alt="user-image" class="rounded border-2 border border-primary" width="120" height="120" @if (!empty($commonCase->attachments)) src="{{ check_file($commonCase->attachments) ? get_file($commonCase->attachments) : get_file('uploads/users-avatar/avatar.png')}}" @else  src="{{ get_file('uploads/users-avatar/avatar.png')}}" @endif>
                                </div>
                                <h5 class="h6 mt-4 mb-1 text-primary">{{ $commonCase->name }}</h5>
                                <div class="mb-1"><a href="#" class="text-sm small text-muted" data-toggle="tooltip" data-placement="right"
                                    title="Account Name">{{ !empty($commonCase->accounts) ? $commonCase->accounts->name : '-' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @permission('case create')
        <div class="col-md-3">
            <a href="#" class="btn-addnew-project border-primary"  data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Common case') }}" data-url="{{ route('commoncases.create', ['commoncases', 0]) }}" style="padding: 75px 10px;">
                <div class="badge bg-primary proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">{{__('New Common case')}}</h6>
                <p class="text-muted text-center">{{__('Click here to add New Common case')}}</p>
            </a>
        </div>
     @endpermission
</div>




@endsection
