@extends('restaurant-menu::layouts.master')
@section('content')
    <section class="invoice-page-sec pt pb">
        <div class="container">
            <a href="{{ route('restaurant-qr-reader', ['workspace' => $workspace, 'table_id' => $diningTable->id]) }}"
                class="back-btn">{{ __('Back To Home') }}</a>
            <div class="invoice-box cart-list-wrp d-flex">
                <div class="cart-list-left">
                    <div class="cart-box">
                        <div class="cart-title">
                            <h2>{{ __('Invoice') }}</h2>
                        </div>
                        <div class="cart-body">
                           
                                    <div class="invoice-left">
                                        <div class="order-details d-flex justify-content-between">
                                            <ul class="details-left">
                                                <li> {{ __('Order ID:') }} <span>{{ $orders->order_id }}</span></li>
                                            </ul>
                                        </div>
                                        @php
                                            $cart = $orders['product'];
                                            $productData = json_decode($cart, true);
                                            $products = $productData['products'];
                                        @endphp
                                        <div class="success-order d-flex align-items-center justify-content-center">
                                            <div class="success-order-inner d-flex align-items-center">
                                                <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/success-order.png') }}"
                                                    alt="success-order">
                                                <h3>{{ __('Successfully Order') }}</h3>
                                            </div>
                                        </div>
                                        <div class="order-progress">
                                            <div class="progress-box active">
                                                <div class="order-number">
                                                    <span>1</span>
                                                </div>
                                                <div class="order-info">
                                                    <p>{{ __('Order Placed') }}</p>
                                                </div>
                                            </div>
                                            <div class="progress-box">
                                                <div class="order-number">
                                                    <span>2</span>
                                                </div>
                                                <div class="order-info">
                                                    <p>{{ __('Order Accept') }}</p>
                                                </div>
                                            </div>
                                            <div class="progress-box">
                                                <div class="order-number">
                                                    <span>3</span>
                                                </div>
                                                <div class="order-info">
                                                    <p>{{ __('Order Procesing') }}</p>
                                                </div>
                                            </div>
                                            <div class="progress-box">
                                                <div class="order-number">
                                                    <span>4</span>
                                                </div>
                                                <div class="order-info">
                                                    <p>{{ __('Order Delivered') }}</p>
                                                </div>
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
                                            @foreach ($products as $productId => $product)
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
                                                                <dd>{{ isset($product['varient']) ? $product['varient'] : '' }}
                                                                </dd>
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
                                                            <span>{{ currency_format_with_sym($orders->total, $company_id, $workspace_id) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                             </div>
        </div>
    </section>
@endsection
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var orderStatus = "{{ $orders->status }}";
        console.log(orderStatus);
        if (orderStatus == 0) {
            $('.progress-box').eq(0).addClass('active');
        }
        if (orderStatus == 1) {
            $('.progress-box').eq(0).addClass('active');
            $('.progress-box').eq(1).addClass('active');
        }
        if (orderStatus == 2) {
            $('.progress-box').eq(0).addClass('active');
            $('.progress-box').eq(1).addClass('active');
            $('.progress-box').eq(2).addClass('active');
        }
        if (orderStatus == 3) {
            $('.progress-box').eq(0).addClass('active');
            $('.progress-box').eq(1).addClass('active');
            $('.progress-box').eq(2).addClass('active');
            $('.progress-box').eq(3).addClass('active');
        }
    });
</script>
