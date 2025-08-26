@extends('restaurant-menu::layouts.master')
@section('content')
    @php
        $cart = session()->get($workspace->slug);
    @endphp
    @if (!empty($cart['products']) || ($cart['products'] = []))
        <section class="cart-page-sec pt pb">
            <div class="container">

                <a href="{{ route('restaurant-qr-reader', ['workspace' => $workspace, 'table_id' => $diningTable->id]) }}"
                    class="back-btn">{{ __('Back To Home') }}</a>
                <div class="cart-list-wrp d-flex">
                    <div class="cart-list-left">
                        <div class="cart-box">
                        <div class="cart-title">
                            <h2>{{ __('My Order') }}</h2>
                        </div>
                        <div class="cart-body">
                            @if (!empty($products))
                                <table class="cart-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                            <th scope="col">{{ __('Price') }}</th>
                                            <th scope="col">{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products['products'] as $key => $product)
                                            <tr data-id="{{ $key }}" id="product-id-{{ $product['id'] }}">
                                                <td data-label="Product">
                                                    <a href="index.html" class="pro-img-cart" tabindex="0">
                                                        <img src="{{ isset($product['item_image']) ? get_file($product['item_image']) : '' }}"
                                                            loading="lazy">
                                                    </a>
                                                </td>
                                                <td data-label="Name" class="cart-details">
                                                    <div class="details">
                                                        <h3>
                                                            <a href="index.html" tabindex="0">{{ $product['item_name'] }}</a>
                                                        </h3>
                                                        <div class="product-option">
                                                            <dt>{{ $product['item_attribute'] . ':' }}</dt>
                                                            <dd>{{ $product['varient'] }}</dd>
                                                        </div>
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['restaurant-add-to-cart-destroy', [$workspace, $diningTable->id,$product['id']]],
                                                            'id' => 'delete-product-cart-' . $product['id'],
                                                        ]) !!}
                                                        <a href="javascript:void(0)"
                                                            class="wishlist-btn remove_from_wishlist show_confirm remove-btn"
                                                            data-confirm-yes="document.getElementById('delete-product-cart-{{ $product['id'] }}').submit();">
                                                            {{ __('Remove') }}</a>
                                                        {!! Form::close() !!}
                                                    </div>  
                                                </td>
                                                <td data-label="Quantity">
                                                    <div class="qty-spinner" data-id="{{ $key }}">
                                                        <button type="button" class="quantity-decrement product_qty qty-minus"
                                                            tabindex="0">
                                                            <svg width="12" height="2" viewBox="0 0 12 2" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0 0.251343V1.74871H12V0.251343H0Z" fill="#61AFB3">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <input type="number" class="quantity product_qty_input bx-cart-qty"
                                                            data-cke-saved-name="quantity" name="quantity"
                                                            data-id="{{ $product['id'] }}" value="{{ $product['quantity'] }}"
                                                            id="product_qty">
                                                        <button type="button" class="quantity-increment product_qty qty-plus"
                                                            tabindex="0">
                                                            <svg width="12" height="12" viewBox="0 0 12 12"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.74868 5.25132V0H5.25132V5.25132H0V6.74868H5.25132V12H6.74868V6.74868H12V5.25132H6.74868Z"
                                                                    fill="#61AFB3"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td data-label="Price">
                                                    <p>{{ currency_format_with_sym($product['sales_price'], $company_id, $workspace_id) }}
                                                    </p>
                                                </td>
                                                <td data-label="Subtotal" class="subtotal" id="totalPrice">
                                                    <p>{{ currency_format_with_sym($product['total_price'], $company_id, $workspace_id) }}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            
                        </div>
                        </div>
                    </div>
                    <div class="cart-list-right">
                    <div class="total-box">
                                @php
                                    $total = 0;
                                    $sub_total = 0;
                                @endphp
                                @if (!empty($cart['products']))
                                    @foreach ($cart['products'] as $k => $value)
                                        @php
                                            $total += $value['total_price'];
                                            $sub_total += $value['total_price'];
                                        @endphp
                                    @endforeach
                                @endif
                                <div class="total-body">
                                    <div class="total d-flex align-items-center justify-content-between">
                                        <p>{{ __('Total:') }}</p>
                                        <span
                                            id="displaytotal">{{ currency_format_with_sym($total, $company_id, $workspace_id) }}</span>
                                    </div>
                                    <a href="{{ route('restaurant-check-out', ['workspace' => $workspace, 'table_id' => $diningTable->id, 'total' => $total]) }}"
                                        class="btn checkout-btn">{{ __('Checkout') }}</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    @else
    <section class="cart-page-sec pt pb">
        <!-- SVG background -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="empty-detail-wrap">
                        <div class="empty-image">
                            <svg width="280" height="500" viewBox="0 0 180 180" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="M173.583 56.4165C176 58.8332 176 62.8332 173.583 65.2498C172.333 66.4998 170.75 67.0832 169.166 67.0832C167.583 67.0832 166 66.4998 164.75 65.2498L148.333 48.8332L131.917 65.2498C130.667 66.4998 129.083 67.0832 127.5 67.0832C125.916 67.0832 124.333 66.4998 123.083 65.2498C120.666 62.8332 120.666 58.8332 123.083 56.4165L139.5 39.9998L123.083 23.5832C120.666 21.1665 120.666 17.1665 123.083 14.7498C125.5 12.3332 129.5 12.3332 131.917 14.7498L148.333 31.1665L164.75 14.7498C167.166 12.3332 171.167 12.3332 173.583 14.7498C176 17.1665 176 21.1665 173.583 23.5832L157.166 39.9998L173.583 56.4165ZM179.583 156.666C179.583 169.333 169.333 179.583 156.666 179.583C144 179.583 133.75 169.333 133.75 156.666C133.75 152.916 134.75 149.416 136.333 146.25H76.9998C78.5832 149.416 79.5832 152.916 79.5832 156.666C79.5832 169.333 69.3332 179.583 56.6665 179.583C43.9998 179.583 33.7498 169.333 33.7498 156.666C33.7498 147.166 39.5832 139 47.9165 135.5L35.1665 27.1665C34.6665 22.9165 31.4998 19.3332 27.3332 18.2498L5.1665 12.7498C1.83317 11.9165 -0.250164 8.49984 0.583169 5.1665C1.4165 1.83317 4.74984 -0.250164 8.1665 0.583169L30.3332 6.1665C39.4998 8.4165 46.4165 16.3332 47.5832 25.6665L48.4998 33.9165C48.4998 33.9165 49.1665 33.7498 49.4998 33.7498H103C102.75 35.8332 102.5 37.8332 102.5 39.9998C102.5 65.2498 123.083 85.8332 148.333 85.8332C158.75 85.8332 168.333 82.2498 176.083 76.4165L173 99.9998C172.083 106.75 166.5 112.083 159.666 112.583L58.6665 120.583L60.2498 133.75H156.666C169.333 133.75 179.583 144 179.583 156.666ZM67.0832 156.666C67.0832 150.916 62.4165 146.25 56.6665 146.25C50.9165 146.25 46.2498 150.916 46.2498 156.666C46.2498 162.416 50.9165 167.083 56.6665 167.083C62.4165 167.083 67.0832 162.416 67.0832 156.666ZM167.083 156.666C167.083 150.916 162.416 146.25 156.666 146.25C150.916 146.25 146.25 150.916 146.25 156.666C146.25 162.416 150.916 167.083 156.666 167.083C162.416 167.083 167.083 162.416 167.083 156.666Z"
                            fill="#0CAF60" />
                        </svg>
                    </div>
                    <div class="empty-content mt-2">
                        <div class="section-title">
                            <h2>{{ __('Your cart is empty') }}.</h6>
                        </div>
                        <a href="{{ route('restaurant-qr-reader', ['workspace' => $workspace, 'table_id' => $diningTable->id]) }}"
                                                class="back-btn">{{ __('Back To Home') }}</a>
                                            </a>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>

<script>
    var site_currency_symbol_position = "{{ $company_settings['site_currency_symbol_position'] }}";
    var site_currency_symbol = "{{ $company_settings['defult_currancy_symbol'] }}";
</script>

<script>
    $(document).on('click', '.product_qty', function(e) {
        e.preventDefault();
        var currEle = $(this);
        var product_id = $(this).siblings(".bx-cart-qty").attr('data-id');
        var arrkey = $(this).parents('tr').attr('data-id');
        var sum = 0;

        setTimeout(function() {
            if (currEle.hasClass('qty-minus') == true) {
                qty_id = currEle.next().val()
            } else {
                qty_id = currEle.prev().val();
            }

            if (qty_id == 0 || qty_id == '' || qty_id < 0) {
                location.reload();
                return false;
            }

            $.ajax({
                url: "{{ route('restaurant-product_qty.product_qty', ['__product_id', $workspace->slug, $diningTable->id, 'arrkeys']) }}"
                    .replace('__product_id', product_id).replace('arrkeys', arrkey),
                type: "post",
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "product_qty": qty_id,
                },
                success: function(response) {
                    if (response.status == "Error") {
                        show_toastr('Error', response.error, 'error');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $.each(response.product, function(key, value) {
                            sum += parseInt(value.subtotal);
                        });

                        var number = parseFloat(sum).toFixed(2).replace(
                            /(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        var total = ((site_currency_symbol_position == "pre") ?
                            site_currency_symbol : '') + number + ((
                                site_currency_symbol_position == "post") ?
                            site_currency_symbol : '');

                        $('#displaytotal').text(total);

                        $.each(response.product, function(key, value) {
                            var subtotal = parseFloat(value.subtotal).toFixed(2)
                                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                            $('#product-id-' + value.id + ' .subtotal p').text(
                                subtotal);
                        });
                    }
                },
                error: function(result) {
                    console.log('error12');
                }
            });
        }, 100);
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.show_confirm', function() {
            var form = $(this).closest("form");
            var title = $(this).attr("data-confirm");
            var text = $(this).attr("data-text");
            if (title == '' || title == undefined) {
                title = "Are you sure?";
            }
            if (text == '' || text == undefined) {
                text = "This action can not be undone. Do you want to continue?";
            }
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
