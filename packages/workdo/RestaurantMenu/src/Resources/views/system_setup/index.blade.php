@extends('layouts.main')
@section('page-title')
{{__('Manage Items Attributes')}}
@endsection
@section('page-breadcrumb')
{{ __('Items Attributes') }}
@endsection
@section('page-action')
<div>
    @permission('restaurant_items_attributes create')
    <a data-size="md" data-url="{{ route('restaurant-items-attribute.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Create Items Attribute') }}" title="{{ __('Create') }}" class="btn btn-sm btn-primary btn-icon">
        <i class="ti ti-plus"></i>
    </a>
    @endpermission
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-lg-4 col-12">
            @include('restaurant-menu::layouts.system_setup')
        </div>
        <div class="col-xxl-9 col-lg-8 col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive overflow_hidden">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    </th>
                                    @if (Laratrust::hasPermission('restaurant_items_attributes edit') || Laratrust::hasPermission('restaurant_items_attributes delete'))
                                        <th scope="col" class="text-end">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemAttributes as $itemAttribute)
                                    <tr>
                                        <td>{{ isset($itemAttribute->name) ? $itemAttribute->name : '' }}</td>
                                        <td>{{ isset($itemAttribute->status) ? $itemAttribute->status : ''}}</td>
                                        @if (Laratrust::hasPermission('restaurant_items_attributes edit') || Laratrust::hasPermission('restaurant_items_attributes delete'))
                                            <td class="text-end">
                                                @permission('restaurant_items_attributes edit')
                                                    <div class="action-btn me-2">
                                                        <a data-url="{{ route('restaurant-items-attribute.edit', $itemAttribute->id) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-info"
                                                            data-bs-toggle="tooltip" data-ajax-popup="true"
                                                            data-title="{{ __('Edit Items Attributes') }}"title="{{ __('Edit') }}"><i
                                                                class="ti ti-pencil text-white"></i></a>
                                                    </div>
                                                @endpermission
                                                @permission('restaurant_items_attributes delete')
                                                    <div class="action-btn">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['restaurant-items-attribute.destroy', $itemAttribute->id]]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm   align-items-center text-white show_confirm bg-danger"
                                                            data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endpermission
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
