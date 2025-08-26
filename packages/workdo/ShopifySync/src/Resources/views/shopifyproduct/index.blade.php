@extends('layouts.main')

@section('page-title')
    {{ __('Manage Product') }}
@endsection

@section('page-breadcrumb')
    {{ __('Product') }}
@endsection
@section('page-action')
@endsection
@php
    $active = module_is_active('ProductService');
@endphp
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="shopify_product">
                            <thead>
                                <tr>
                                    <th>{{ __('Product Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopify_products['products'] as $shopify_product)
                                    <tr>
                                        <td>
                                            <div>
                                                @if ($shopify_product['image'])
                                                    <a href="{{ $shopify_product['image']['src'] }}" class="image-fixsize" target="_blank">
                                                        <img alt="Image placeholder"
                                                            src="{{ $shopify_product['image']['src'] }}"
                                                             class="rounded border-2 border border-primary">
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $shopify_product['title'] }}</td>
                                        <td>{{ $shopify_product['status'] }}</td>
                                        <td>{{ !empty($shopify_product['product_type']) ? $shopify_product['product_type'] : '-' }}
                                        </td>
                                        <td>
                                            @if ($active == true)
                                                @if (in_array($shopify_product['id'], $shopify_conection))
                                                    @permission('shopify product create')
                                                        <a href="#" data-ajax-popup="true"
                                                            data-url="{{ route('shopify-product.edit', $shopify_product['id']) }}"
                                                                class="btn btn-sm btn-primary" data-title="Sync Again">
                                                                <i class="ti ti-refresh " data-bs-toggle="tooltip" title=""
                                                                    data-bs-original-title="Sync Again" aria-label="Sync Again"></i>
                                                        </a>
                                                    @endpermission
                                                @else
                                                    @permission('shopify product edit')
                                                        <a href="#" class="btn btn-sm btn-primary" data-ajax-popup="true"
                                                            data-title="{{ __('Product Create') }}"
                                                            data-url="{{ route('product.shopify.create', $shopify_product['id']) }}"
                                                            data-toggle="tooltip" title="{{ __('create') }}"><i
                                                                class="ti ti-plus"></i>
                                                        </a>
                                                    @endpermission

                                                @endif
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
