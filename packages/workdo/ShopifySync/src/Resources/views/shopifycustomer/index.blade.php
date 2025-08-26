@extends('layouts.main')

@section('page-title')
    {{__('Manage Customer')}}
@endsection

@section('page-breadcrumb')
   {{__('Customer')}}
@endsection
@section('page-action')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="shopify_customer">
                            <thead>
                                <tr>
                                    <th>{{__('Avatar')}}</th>
                                    <th>{{__('First Name')}}</th>
                                    <th>{{__('Last Name')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Phone No')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shopify_customers['customers'] as $shopify_customer)
                                    @php
                                        $nameValues = array_column($shopify_customer['addresses'], 'phone');
                                        $phone_number = implode(',', $nameValues);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div>
                                                <a href="{{get_file('/uploads/users-avatar/avatar.png')}}" target="_blank" class="users-image">
                                                    <img alt="Image placeholder" src="{{get_file('/uploads/users-avatar/avatar.png')}}" class="rounded border-2 border border-primary" >
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ $shopify_customer['first_name'] }}</td>
                                        <td>{{ $shopify_customer['last_name'] }}</td>
                                        <td>{{ $shopify_customer['email'] }}</td>
                                        <td>{{!empty($phone_number)?$phone_number:'' }}</td>
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
