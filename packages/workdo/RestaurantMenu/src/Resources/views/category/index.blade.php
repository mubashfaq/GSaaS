@extends('layouts.main')
@section('page-title')
    {{ __('Manage Category') }}
@endsection
@section('page-breadcrumb')
    {{ __('Category') }}
@endsection
@section('page-action')
    @permission('restaurant_category create')
        <div>
            <a data-url="{{ route('restaurant-category-create', ['type' => 0]) }}" data-ajax-popup="true" data-bs-toggle="tooltip"
                title="{{ __('Create') }}" title="{{ __('Create') }}" data-title="{{ __('Create Category') }}"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    @endpermission
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-lg-4 col-12">
            @include('restaurant-menu::layouts.system_setup')
        </div>
        <div class="col-xxl-9 col-lg-8 col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Color') }}</th>
                                    @if (Laratrust::hasPermission('restaurant_category edit') || Laratrust::hasPermission('restaurant_category delete'))
                                        <th class="text-end">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td width="200">
                                            <div class="image-fixsize">
                                                <a href="{{ get_file($category->food_image) }}" target="_blank">
                                                    <img src=" {{ get_file($category->food_image) }} "
                                                        class="wid-75 me-3 rounded border-2 border border-primary">
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ isset($category->name) ? $category->name : '-' }}</td>
                                        <td><span class="badge"
                                            style="background: {{ $category->color }}">&nbsp;&nbsp;&nbsp;</span></td>
                                        <td class="text-end">
                                            @if (Laratrust::hasPermission('restaurant_category edit') || Laratrust::hasPermission('restaurant_category delete'))
                                                @permission('restaurant_category edit')
                                                    <div class="action-btn me-2">
                                                        <a class="mx-3 btn btn-sm align-items-center bg-info"
                                                            data-url="{{ route('restaurant-category-edit', $category->category_id) }}"
                                                            data-ajax-popup="true"
                                                            data-title="{{ __('Edit Category') }}"
                                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                    @permission('restaurant_category delete')
                                                        <div class="action-btn">
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['restaurant-category-destroy', $category->category_id],
                                                                'id' => 'delete-form-' . $category->category_id,
                                                            ]) !!}
                                                            <a class="mx-3 btn btn-sm align-items-center bs-pass-para show_confirm bg-danger"
                                                                data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                                data-original-title="{{ __('Delete') }}"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="document.getElementById('delete-form-{{ $category->category_id }}').submit();">
                                                                <i class="ti ti-trash text-white"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    @endpermission
                                                @endif
                                            </td>
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
