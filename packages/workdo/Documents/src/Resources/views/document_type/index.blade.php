@extends('layouts.main')

@section('page-title')
    {{ __('Manage Document Type') }}
@endsection

@section('page-breadcrumb')
    {{ __('Document Type') }}
@endsection

@section('page-action')
    <div>
        @permission('documents type create')
            <a data-url="{{ route('documents-type.create') }}" data-size="md" data-ajax-popup="true"
                data-bs-toggle="tooltip"data-title="{{ __('Create Document Type') }}" title="{{ __('Create') }}"
                class="btn btn-sm btn-primary"><i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('page-breadcrumb')
    {{ __('Document Type') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Document Type') }}</th>
                                    @if (Laratrust::hasPermission('documents type edit') || Laratrust::hasPermission('documents type delete'))
                                        <th width="250px">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documentTypes as $document_type)
                                    <tr>
                                        <td>{{ $document_type->name }}</td>
                                        @if (Laratrust::hasPermission('documents type edit') || Laratrust::hasPermission('documents type delete'))
                                            <td class="Action">
                                                <span>
                                                    @permission('documents type edit')
                                                        <div class="action-btn me-2">
                                                            <a data-size="md" data-ajax-popup="true"
                                                                data-url="{{ route('documents-type.edit', $document_type->id) }}"
                                                                data-title="{{ __('Edit Document Type') }}"
                                                                class="bg-info btn btn-sm align-items-center"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Edit') }}">
                                                                <is class="ti ti-pencil text-white"></is>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('documents type delete')
                                                        <div class="action-btn">
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['documents-type.destroy', $document_type->id]]) !!}
                                                            <a href="#!"
                                                                class="bg-danger btn btn-sm d-inline-flex align-items-center show_confirm"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Delete') }}">
                                                                <span class="text-white"> <i class="ti ti-trash"></i></span></a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endpermission
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    @include('layouts.nodatafound')
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
