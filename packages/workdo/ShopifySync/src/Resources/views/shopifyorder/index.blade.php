@extends('layouts.main')

@section('page-title')
    {{__('Manage Order')}}
@endsection

@section('page-breadcrumb')
   {{__('Order')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="shopify_order">
                            <thead>
                                <tr>
                                    <th>{{__('Order ID')}}</th>
                                    <th>{{__('Customer')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Total')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopify_orders['orders'] as $shopify_order)
                                    <tr>
                                        <td>
                                            @if(\Auth::user()->isAbleTo('shopify order show'))
                                                <a href="{{route('shopify-order.show',$shopify_order['id'])}}" class="btn btn-outline-primary">
                                                    <span class="btn-inner--text">{{$shopify_order['name']}}</span>
                                                </a>
                                            @else
                                                <span class="btn-inner--text">{{$shopify_order['name']}}</span>
                                            @endif
                                        </td>
                                        <td> {{ !empty($shopify_order['shopify_order'])?$customer['customer']:'No Customer' }}</td>
                                        <td>{{ company_date_formate($shopify_order['created_at']) }}</td>
                                        <td>{{ $shopify_order['financial_status'] }}</td>
                                        <td>{{ $shopify_order['total_price'] }}</td>
                                        <td>
                                            <div>
                                                <div class="actions">
                                                    @permission('shopify order show')
                                                        <div class="action-btn">
                                                            <a href="{{route('shopify-order.show',$shopify_order['id'])}}" class="btn btn-sm bg-warning align-items-center" data-bs-toggle="tooltip" title="{{ __('Details') }}"> <span class="text-white"> <i class="ti ti-eye"></i></span></a>
                                                        </div>
                                                    @endpermission
                                                </div>
                                            </div>
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
