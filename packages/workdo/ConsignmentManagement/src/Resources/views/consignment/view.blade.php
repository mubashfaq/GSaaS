@extends('layouts.main')
@section('page-title')
    {{ __('Consignment Detail') }}
@endsection
@section('page-breadcrumb')
    {{ __('Consignment') }}
@endsection

@section('page-action')
    <div>
        @permission('consignment edit')
            <div class="action-btn me-2">
                <a class="btn btn-sm btn-primary" href="{{ route('consignment.edit', $consignment->id) }}" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Edit') }}">
                    <i class="ti ti-pencil"></i>
                </a>
            </div>
        @endpermission
        <div class="action-btn">
            <a type="button" href="{{ route('consignment.index') }}" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Back') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-arrow-back-up"></i>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script>
        var selector = "body";
        if ($(selector + " .repeater").length) {
            var $dragAndDrop = $("body .repeater tbody").sortable({
                handle: '.sort-handler'
            });
            var $repeater = $(selector + ' .repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'status': 1
                },
                show: function() {
                    $(this).slideDown();
                    var file_uploads = $(this).find('input.multi');
                    if (file_uploads.length) {
                        $(this).find('input.multi').MultiFile({
                            max: 3,
                            accept: 'png|jpg|jpeg',
                            max_size: 2048
                        });
                    }
                    // for item SearchBox ( this function is  custom Js )
                    JsSearchBox();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalAmount').html(subTotal.toFixed(2));
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });
            var value = $(selector + " .repeater").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.product_select').trigger('change');
        })
    </script>
    <script>
        $(document).on('click', '#remove', function() {
            $('#customer-box').removeClass('d-none');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })
    </script>


    <script>
        $(document).on('click', '[data-repeater-delete]', function() {
            $(".price").change();
            $(".discount").change();
        });
    </script>

    <script>
        $('body').on('change', '.product_select', function() {

            var selectedOption = $(this).val();
            var itemSelect = $(this).parent().parent();
            var el = $(this);

            $.ajax({
                url: '{{ route('get.product.data') }}',
                type: 'POST',
                data: {
                    "product_id": selectedOption,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    var quantity = response.data.quantity
                    var unit_price = response.data.unit_price

                    itemSelect.find('.quantity').val(quantity)
                    itemSelect.find('.price').val(unit_price)

                    changeItem(el, quantity, unit_price);
                }
            });

        });

        $(document).on('keyup', '.quantity', function() {

            changeItem($(this).parent(), $(this).val(), $(this).parent().parent().parent().find('.price').val());
        });
        $(document).on('keyup', '.price', function() {
            changeItem($(this).parent(), $(this).parent().parent().parent().find('.quantity').val(), $(this).val());
        });

        function changeItem(el, quantity, unit_price) {

            el.parent().parent().find('.amount').html(parseFloat(quantity * unit_price).toFixed(2))

            var priceInput = $('.price');
            var inputs_quantity = $(".quantity");
            var totalItemPrice = 0;

            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            var commission = (parseFloat(subTotal) * $('#commission').val() / 100).toFixed(2)
            subTotal += parseFloat(commission)

            $('.add-consignment').html(commission)
            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));

            $('#totalamount').val((parseFloat(subTotal)).toFixed(2));
            $('#subtotal').val(totalItemPrice.toFixed(2));
        }
    </script>
@endpush

@section('content')
    <div class="row">
        {{ Form::model($consignment, ['route' => ['consignment.update', $consignment->id], 'method' => 'put', 'class' => 'w-100']) }}
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <div class="row" id="customer-box">
                                <div class="form-group col-md-4">
                                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                                    <p>{{ $consignment->title }}</p>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <div class="form-group ">
                                            <label class="require form-label">{{ __('Consignment') }} : </label>
                                            <p>{{ $consignment->commission }} (%)</p>
                                            {{ Form::hidden('commission', null, ['class' => 'form-control', 'id' => 'commission', 'required' => 'required', 'step' => 'any', 'placeholder' => 'Please Enter Consignment']) }}

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
                                        <div class="form-icon-user">
                                            <p>{{ company_date_formate($consignment->date) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 section_div">
            <h5 class="h4 d-inline-block font-weight-400 mb-4">{{ __('Items') }}</h5>
            <div class="card repeater">

                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Price') }} </th>
                                    <th>{{ __('Tax') }} (%) </th>
                                    <th class="text-end">{{ __('Amount') }} </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="ui-sortable">
                                @foreach ($consignmentItems as $consignmentItem)
                                    <tr>
                                        <td style="width:25%;">{{ $consignmentItem->product->name }}</td>
                                        <td style="width:20%;">{{ $consignmentItem->quantity }}</td>
                                        <td style="width:20%;">{{ currency_format_with_sym($consignmentItem->price) }}</td>
                                        <td>
                                            @php
                                                if (!empty($consignmentItem->tax)) {
                                                    $taxes = \App\Models\Invoice::tax($consignmentItem->tax);
                                                    $totalTaxPrice = 0;
                                                    $data = 0;
                                                }
                                            @endphp
                                            @if (!empty($consignmentItem->tax))
                                                @foreach ($taxes as $tax)
                                                    @php
                                                        $taxPrice = \App\Models\Invoice::taxRate(
                                                            $tax->rate,
                                                            $consignmentItem->price,
                                                            $consignmentItem->quantity,
                                                            // $consignment->commission,
                                                        );
                                                        $totalTaxPrice += $taxPrice;
                                                        $data += $taxPrice;
                                                    @endphp
                                                    <span class="badge bg-primary p-2 px-3 mt-1 me-2 mb-2">{{ $tax->name . ' (' . $tax->rate . '%)' }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-end amount">
                                            {{ $consignmentItem->quantity * $consignmentItem->price }}
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Sub Total') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end subTotal">{{ $consignment->subtotal }}
                                    </td>
                                    <input type="hidden" name="subtotal" id="subtotal">
                                </tr>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Consignment') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end add-consignment">
                                        {{ ($consignment->subtotal * $consignment->commission) / 100 }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Tax') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end totalTax">{{ $consignment->taxamount }}
                                    </td>
                                    <input type="hidden" name="totalTax" id="totalTax">
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text border-none"><strong>{{ __('Total Amount') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end totalAmount blue-text border-none">
                                        {{ $consignment->totalamount }}</td>
                                    <input type="hidden" name="totalamount" id="totalamount">

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{ Form::close() }}
    </div>
@endsection
