@extends('layouts.main')

@section('page-title')
    {{__('Shopify Order')}}
@endsection

@section('page-breadcrumb')
{{ __('Order') }},
{{ __('show') }}
@endsection

@section('content')
    <div class="mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-fluid">
                    <div class="card-header ">
                        <h6 class="mb-0">{{__('Order')}} {{$shopify_order['name']}}</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-4">{{__('Shipping Information')}}</h6>
                                <address class="mb-0 text-sm">
                                    <dl class="row mt-4 align-items-center">
                                        <dt class="col-sm-3 h6 text-sm">{{__('Name')}}</dt>
                                        <dd class="col-sm-9 text-sm"> {{ !empty($shopify_order['shipping_address']['name']) ? $shopify_order['shipping_address']['name'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Company')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['company']) ? $shopify_order['shipping_address']['company'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('City')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['city']) ? $shopify_order['shipping_address']['city'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('state')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['province']) ? $shopify_order['shipping_address']['province'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Country')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['country']) ? $shopify_order['shipping_address']['country'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Postal Code')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['country_code']) ? $shopify_order['shipping_address']['country_code'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Phone')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['shipping_address']['phone']) ? $shopify_order['shipping_address']['phone'] : '-'}}</dd>
                                    </dl>
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-4">{{__('Billing Information')}}</h6>
                                <address class="mb-0 text-sm">
                                    <dl class="row mt-4 align-items-center">
                                        <dt class="col-sm-3 h6 text-sm">{{__('Name')}}</dt>
                                        <dd class="col-sm-9 text-sm"> {{ !empty($shopify_order['billing_address']['name']) ? $shopify_order['billing_address']['name'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Company')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['company']) ? $shopify_order['billing_address']['company'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('City')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['city']) ? $shopify_order['billing_address']['city'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('state')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['province']) ? $shopify_order['billing_address']['province'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Country')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['country']) ? $shopify_order['billing_address']['country'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Postal Code')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['country_code']) ? $shopify_order['billing_address']['country_code'] : '-'}}</dd>
                                        <dt class="col-sm-3 h6 text-sm">{{__('Phone')}}</dt>
                                        <dd class="col-sm-9 text-sm">{{ !empty($shopify_order['billing_address']['phone']) ? $shopify_order['billing_address']['phone'] : '-'}}</dd>
                                    </dl>
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr class="border-top-0">
                                        <th>{{__('Item')}}</th>
                                        <th>{{__('Quantity')}}</th>
                                        <th>{{__('Price')}}</th>
                                        <th>{{__('Total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shopify_order['line_items'] as $key=>$product)
                                        <tr>
                                            @php
                                                $product_total = $product['price']*$product['quantity'];
                                            @endphp
                                            <td class="total">
                                            <span class="h6 text-sm">
                                                    {{$product['name']}}
                                            </span>
                                            </td>
                                            <td>
                                                {{ $product['quantity'] }}
                                            </td>
                                            <td>
                                                {{ currency_format_with_sym($product['price'])}}
                                            </td>
                                            <td>
                                                {{ currency_format_with_sym($product_total)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-fluid">
                    <div class="card-header border-0">
                        <h6 class="mb-0">{{__('Items from Order ').$shopify_order['name']}}</h6>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{__('Description')}}</th>
                                        <th>{{__('Price')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{__('Grand Total')}} :</td>
                                        <td>{{ currency_format_with_sym($shopify_order['total_line_items_price'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Discount')}} :</td>
                                        <td>{{(!empty($shopify_order['total_discounts']))?$shopify_order['total_discounts']: currency_format_with_sym(0)}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Tax')}} :</td>
                                        <td>{{(!empty($shopify_order['total_tax']))?$shopify_order['total_tax']: currency_format_with_sym(0)}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{__('Total')}} :</td>
                                        <td>{{ currency_format_with_sym($shopify_order['current_total_price']) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
