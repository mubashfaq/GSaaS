@extends('restaurant-menu::layouts.master')
@section('content')
@php
$cart = session()->get($workspace->slug);
@endphp
{{ Form::open(['url' => route('restaurant-order', ['workspace' => $workspace, 'table_id' => $diningTable->id ]), 'method' => 'post']) }}
@if (!empty($cart['products']) || ($cart['products'] = []))
<section class="checkout-page-sec pt pb">
    <div class="container">
        <a href="{{ route('restaurant-qr-reader', ['workspace' => $workspace, 'table_id' => $diningTable->id]) }}" class="back-btn">{{ __('Back To Home') }}</a>
        <div class="checkout-box cart-list-wrp d-flex">
            <div class="cart-list-left">
                <div class="cart-box">
                    <div class="cart-title">
                        <h2>{{ __('Checkout') }}</h2>
                    </div>
                    <div class="cart-body">

                        <div class="checkout-details">
                            <div class="contact-info">
                                <h3>{{ __('1. Contact Information') }}</h3>
                                <div class="row">
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('first_name', __('First Name'), ['class' => 'form-label']) }}
                                            {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
                                            @error('name')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('last_name', __('Last Name'), ['class' => 'form-label']) }}
                                            {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
                                            @error('name')
                                            <small class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('mobile_no', __('Mobile No'), ['class' => 'form-label']) }}
                                            {{ Form::text('mobile_no', null, ['class' => 'form-control', 'placeholder' => __('Enter User Mobile No')]) }}
                                            @error('mobile_no')
                                            <small class="invalid-mobile" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="form-group">
                                            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
                                            @error('email')
                                            <small class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{ Form::hidden('total', $total) }}
                                    {{ Form::hidden('cart', json_encode($cart)) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart-list-right">
                <div class="summery-box">
                    <div class="summery-top">
                        <div class="summery-card-head">
                            <h4>{{ __('Order Summery') }}</h4>
                        </div>
                        <div class="summery-product-list">
                            @foreach ($cart['products'] as $key => $product)
                            <div class="summery-product d-flex align-items-center">
                                <div class="product-image">
                                    <img src="{{ isset($product['item_image']) ? get_file($product['item_image']) : '' }}"
                                        alt="product-image">
                                </div>
                                <div class="product-info d-flex justify-content-between">
                                    <div class="product-content">
                                        <h5>{{ isset($product['item_name']) ? $product['item_name'] : '' }}
                                        </h5>
                                        <div class="product-option d-flex">
                                            <dt>{{ isset($product['item_attribute']) ? $product['item_attribute'] . ':' : '' }}
                                            </dt>
                                            <dd>{{ isset($product['varient']) }}</dd>
                                        </div>
                                    </div>
                                    <div class="price">
                                        <p>{{ isset($product['total_price']) ? $product['total_price'] : '0' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="summery-card-footer">
                            <div class="total-box">
                                <div class="total-body">
                                    <div class="total d-flex align-items-center justify-content-between">
                                        <p>{{ __('Total:') }}</p>
                                        <span>{{ currency_format_with_sym($total,$company_id,$workspace_id) }}</span>
                                    </div>
                                    <button type="submit" class="btn checkout-btn">{{ __('Order -') }}
                                        <span>{{ currency_format_with_sym($total,$company_id,$workspace_id) }}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{ Form::close() }}
@endsection