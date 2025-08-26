@extends('layouts.main')

@section('page-title')
    {{__('Manage Category')}}
@endsection

@section('page-breadcrumb')
   {{__('Category')}}
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
                        <table class="table mb-0 pc-dt-simple" id="shopify_category">
                            <thead>
                                <tr>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopify_categorys['custom_collections'] as $shopify_category)
                                    <tr>
                                        <td>
                                                @if (!empty($shopify_category['image']))
                                                    <a href="{{$shopify_category['image']['src']}}" target="_blank" class ="image-fixsize">
                                                        <img alt="Image placeholder" src="{{$shopify_category['image']['src']}}" class="rounded border-2 border border-primary" >
                                                    </a>
                                                @else
                                                    <a href="{{asset('packages/workdo/ShopifySync/src/Resources/assets/image/woocommerce.png')}}" target="_blank" class ="image-fixsize">
                                                        <img alt="Image placeholder" src="{{asset('packages/workdo/ShopifySync/src/Resources/assets/image/woocommerce.png')}}" class="rounded border-2 border border-primary" >
                                                    </a>
                                                @endif
                                        </td>
                                        <td>{{ $shopify_category['title'] }}</td>
                                        <td>
                                            @if($active == true)
                                                @if(in_array($shopify_category['id'],$shopify_conection))
                                                    @permission('shopify category create')
                                                        <a href="{{route('shopify-category.edit', $shopify_category['id'])}}" class="btn btn-sm btn-primary" data-title="Sync Again">
                                                            <i class="ti ti-refresh " data-bs-toggle="tooltip" title="" data-bs-original-title="Sync Again" aria-label="Sync Again"></i>
                                                        </a>
                                                    @endpermission
                                                @else
                                                    @permission('shopify category edit')
                                                        <a href="{{route('shopify-category.show',  $shopify_category['id'])}}" class="btn btn-sm btn-primary" data-title="Add Category">
                                                            <i class="ti ti-plus" data-bs-toggle="tooltip" title="" data-bs-original-title="Add Category" aria-label="Add Category"></i>
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
