@extends('layouts.main')

@section('page-title')
    {{__('Manage Coupon')}}
@endsection

@section('page-breadcrumb')
   {{__('Coupon')}}
@endsection
@section('page-action')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="shopify_coupon">
                            <thead>
                                <tr>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Code')}}</th>
                                    <th>{{__('Discount')}}</th>
                                    <th>{{__('Coupon type')}}</th>
                                    <th>{{__('Limit')}}</th>
                                    <th>{{__('Expiry date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopify_coupons['price_rules'] as $shopify_coupon)
                                    <tr>
                                        <td>{{ $shopify_coupon['title'] }}</td>
                                        <td>{{ $shopify_coupon['title'] }}</td>
                                        <td>{{ abs($shopify_coupon['value']) }}</td>
                                        <td>{{ str_replace('_', ' ', ucfirst($shopify_coupon['value_type'])) }}</td>
                                        <td>{{ !empty($shopify_coupon['usage_limit'])?$shopify_coupon['usage_limit']:'-1' }}</td>
                                        <td>{{ company_date_formate($shopify_coupon['ends_at']) }}</td>
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
