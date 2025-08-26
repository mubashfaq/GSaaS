@extends('layouts.main')
@section('page-title')
    {{ __('Manage RFx') }}
@endsection

@section('page-breadcrumb')
    {{ __('RFx') }}
@endsection
@section('page-action')
<div class="d-flex">
        <a href="{{ route('rfx.index') }}"  class="btn btn-sm btn-primary me-2"
            data-bs-toggle="tooltip"title="{{ __('List View') }}">
            <i class="ti ti-list text-white"></i>
        </a>
        @permission('rfx create')
            <a href="{{ route('rfx.create') }}" data-size="md" data-title="{{ __('Create New RFx') }}" data-bs-toggle="tooltip"
                title="" class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/letter.avatar.js') }}"></script>
@endpush
@section('filter')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="badge theme-avtar bg-primary">
                                    <i class="ti ti-briefcase"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('RFx') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $data['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="badge theme-avtar bg-info">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Active') }}</small>
                                    <h6 class="m-0">{{ __('RFxs') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $data['active'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="badge theme-avtar bg-warning">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Inactive') }}</small>
                                    <h6 class="m-0">{{ __('Rfxs') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0">{{ $data['in_active'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($rfxs as $rfx)
            <div class="col-md-3 d-flex">
                <div class="card w-100">
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center">
                            @if ($rfx->status == 'active')
                                <span
                                    class="badge bg-success p-2 px-3">{{ Workdo\Procurement\Entities\Rfx::$status[$rfx->status] }}</span>
                            @else
                                <span
                                    class="badge bg-danger p-2 px-3">{{ Workdo\Procurement\Entities\Rfx::$status[$rfx->status] }}</span>
                            @endif
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @if (Laratrust::hasPermission('rfx show') ||
                                            Laratrust::hasPermission('rfx edit') ||
                                            Laratrust::hasPermission('rfx delete'))
                                        @permission('rfx edit')
                                            <a href="{{ route('rfx.edit', $rfx->id) }}" data-size="md" class="dropdown-item"
                                                data-bs-whatever="{{ __('Edit Rfx') }}" data-bs-toggle="tooltip"
                                                data-title="{{ __('Edit Rfx') }}"><i class="ti ti-pencil"></i>
                                                {{ __('Edit') }}</a>
                                        @endpermission
                                        @permission('rfx show')
                                            <a href="{{ route('rfx.show', $rfx->id) }}" class="dropdown-item"
                                                data-bs-whatever="{{ __('Rfx Details') }}" data-bs-toggle="tooltip"
                                                data-title="{{ __('Rfx Details') }}"><i class="ti ti-eye"></i>
                                                {{ __('Details') }}</a>
                                        @endpermission

                                        @permission('rfx delete')
                                            {{ Form::open(['route' => ['rfx.destroy', $rfx->id], 'class' => 'm-0']) }}
                                            @method('DELETE')
                                            <a href="#!" class="dropdown-item bs-pass-para show_confirm"
                                                aria-label="Delete" data-confirm="{{ __('Are You Sure?') }}"
                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="delete-form-{{ $rfx->id }}">
                                                <i class="ti ti-trash"></i>
                                                <span>{{ __('Delete') }}</span>
                                            </a>
                                            {{ Form::close() }}
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
                                    <div class="avatar-parent-child mb-3">
                                        <img alt="user-image" class="img-fluid rounded-circle"
                                            avatar="{{ $rfx->title }}">
                                    </div>
                                    <div class="h6 mt-2 mb-1 ">
                                        <a class=" text-primary"
                                            href="{{ route('rfx.show', $rfx->id) }}">{{ ucfirst($rfx->title) }}</a>
                                    </div>
                                    <div class="mb-1"><a class="text-sm small text-muted">{{ $rfx->location }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-3">
            <a href="{{ route('rfx.create') }}" class="btn-addnew-project border border-primary" data-title="{{ __('Create New RFx') }}"
                style="padding: 62px 10px;">
                <div class="badge bg-primary proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">{{ __('New RFx') }}</h6>
                <p class="text-muted text-center">{{ __('Click here to add New rfx') }}</p>
            </a>
        </div>
    </div>
@endsection
