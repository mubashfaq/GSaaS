@extends('layouts.main')
@section('page-title')
{{ __('View Table Orders') }}
@endsection
@section('page-breadcrumb')
{{ __('View Table Orders') }}
@endsection
<link rel="stylesheet" href="{{ asset('Workdo/RestaurantMenu/Resources/assets/css/main-style.css') }}">

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                            {!! Form::select('status', $statues, isset($order->status) ? $order->status : null, [
                            'class' => 'form-control',
                            'id' => 'status',
                            'required' => 'required',
                            'placeholder' => 'Select Status',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            @if (!empty($order))
            <div class="card-header">
                <h5 class="mb-1">{{ $order->table->name }}</h5>
                <span>{{ __('Order Details') }}</span>
            </div>
            <div class="card-body">
                @php
                $cart = $order['product'];
                $productData = json_decode($cart, true);
                $products = $productData['products'];
                @endphp
                <div class="row">
                    @foreach ($products as $productId => $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="card summery-product text-center p-3">
                            <div class="product-image mb-3">
                                <img src="{{ isset($product['item_image']) ? get_file($product['item_image']) : '' }}"
                                    alt="product-image" class="rounded border border-2 border-primary" style="width: 90px; height: 90px; object-fit: cover;">
                            </div>
                            <div class="product-info flex-1">
                                <div class="product-content">
                                    <h5 class="mb-1">{{ isset($product['item_name']) ? $product['item_name'] : '' }}</h5>
                                    <div class="product-option d-flex justify-content-center">
                                        <dt class="me-2 text-muted">{{ isset($product['item_attribute']) ? $product['item_attribute'] . ':' : '' }}
                                        </dt>
                                        <dd>{{ isset($product['varient']) ? $product['varient'] : '' }}</dd>
                                    </div>
                                    <div class="price">
                                        <h5 class="mb-0">{{ isset($product['total_price']) ? $product['total_price'] : '0' }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="total d-flex align-items-center justify-content-between pt-3 border-1 border-top">
                    <h4 class="mb-0">{{ __('Total:') }}</h4>
                    <h4 class="mb-0">{{ currency_format_with_sym($order->total) }}</h4>
                </div>
                @else
                <div class="card-body text-center text-muted">
                    <div class="text-center">{{ __('No data available') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @endsection
    @push('scripts')
    <script>
        $("#status").on('click', function() {
            var status = $(this).val();
            var data = {
                orderStatus: status,
            }
            $.ajax({
                url: "{{ route('restaurant-order.update', $order->id) }}",
                method: 'GET',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Success', data.success, 'success');
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });
    </script>
    @endpush