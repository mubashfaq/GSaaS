@extends('layouts.main')
@section('page-title')
    {{ __('Consignment Create') }}
@endsection
@section('page-breadcrumb')
    {{ __('Consignment') }}
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

                        var commissionRate = parseFloat($('#commission').val()) || 0;
                        var commission = (subTotal * commissionRate / 100).toFixed(2);

                        var totalItemTaxPrice = 0;
                        var itemTaxPriceInput = $('.itemTaxPrice');
                        for (var j = 0; j < itemTaxPriceInput.length; j++) {
                            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                        }

                        var totalAmount = subTotal + parseFloat(commission) + totalItemTaxPrice;

                        $('.add-consignment').html(commission);
                        $('.subTotal').html(subTotal.toFixed(2));
                        $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                        $('.totalAmount').html(totalAmount.toFixed(2));

                        $('#subtotal').val(subTotal.toFixed(2));
                        $('#totalTax').val(totalItemTaxPrice.toFixed(2));
                        $('#totalamount').html(totalAmount.toFixed(2));
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
            var itemSelect = $(this).parent().parent().parent();
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
                    var unit_price = response.data.sale_price
                    itemSelect.find('.quantity').val(quantity)
                    itemSelect.find('.price').val(unit_price)
                    changeItem(el, quantity, unit_price);
                }
            });
            Items($(this));
        });

        function Items(data) {
            var iteams_id = data.val();
            var url = data.data('id');
            var el = data;
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'product_id': iteams_id
                },
                cache: false,
                success: function(data) {
                    var item = JSON.parse(data);
                    var taxes = '';
                    var tax = [];
                    var totalItemTaxRate = 0;
                    if (item.taxes == 0) {
                        taxes += '-';
                    } else {                       
                        for (var i = 0; i < item.taxes.length; i++) {                            
                            taxes += '<span class="badge bg-primary p-2 px-3 mt-1 me-2">' + item.taxes[
                                i].name + ' ' + '(' + item.taxes[i].rate + '%)' + '</span>';
                            tax.push(item.taxes[i].id);
                            totalItemTaxRate += parseFloat(item.taxes[i].rate);
                        }
                        var itemTaxPrice = 0;
                        if (item.product != null) {
                            var quantity = $(el.parent().parent().parent().find('.quantity')).val();
                            var price = $(el.parent().parent().parent().find('.price')).val();
                            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product.sale_price *
                                quantity));
                            }

                        $(el.parent().parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                        $(el.parent().parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));                        
                        $(el.parent().parent().parent().find('.taxes')).html(taxes);
                        $(el.parent().parent().parent().find('.tax')).val(tax);

                        var totalItemTaxPrice = 0;
                        var itemTaxPriceInput = $('.itemTaxPrice');

                        for (var j = 0; j < itemTaxPriceInput.length; j++) {
                            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                        }
                        $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                        $('#totalTax').val(totalItemTaxPrice.toFixed(2));
                    }
                }
            });
        }

        $(document).on('keyup', '.quantity', function() {

            changeItem($(this).parent(), $(this).val(), $(this).parent().parent().parent().parent().find('.price').val());
        });
        $(document).on('keyup', '.price', function() {
            changeItem($(this).parent(), $(this).parent().parent().parent().parent().find('.quantity').val(), $(this).val());
        });


        $(document).on('keyup', '#commission', function() {
            var inputs = $(".amount");
            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }
            var commission = (parseFloat(subTotal) * $('#commission').val() / 100).toFixed(2)
            subTotal += parseFloat(commission)

            $('.add-consignment').html(commission)
            $('.totalAmount').html((parseFloat(subTotal) + parseFloat($('.totalTax').html())).toFixed(2));
            $('#totalamount').val((parseFloat(subTotal) + parseFloat($('.totalTax').html())).toFixed(2));
        });


        function changeItem(el, quantity, unit_price) {
            el.parent().parent().parent().find('.amount').html(parseFloat(quantity * unit_price).toFixed(2))

            var priceInput = $('.price');
            var inputs_quantity = $(".quantity");
            var totalItemPrice = 0;

            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            //Tax
            for (var j = 0; j < priceInput.length; j++) {
                // var ItemPrice = (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
                var ItemPrice = (parseFloat(quantity) * parseFloat(unit_price));
            }
            var totalItemTaxRate = $(el.parent().parent().parent().find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * ItemPrice);

            $(el.parent().parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                // el.parent().parent().parent().find('.amount').html(parseFloat(ItemPrice) + parseFloat(itemTaxPrice));
            }

            $('.totalTax').html(totalItemTaxPrice.toFixed(2));
            $('#totalTax').val(totalItemTaxPrice.toFixed(2));

            var inputs = $(".amount");
            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            var commission = (parseFloat(subTotal) * $('#commission').val() / 100).toFixed(2)
            subTotal += parseFloat(commission)

            $('.add-consignment').html(commission)
            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalAmount').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

            $('#totalamount').val((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));
            $('#subtotal').val(totalItemPrice.toFixed(2));
        }
    </script>
@endpush
@section('content')
    <div class="row">
        {{ Form::open(['route' => 'consignment.store', 'method' => 'post', 'class' => 'w-100 needs-validation','novalidate']) }}
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <div class="row" id="customer-box">

                                <div class="form-group col-md-4">
                                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}<x-required></x-required>
                                    {{ Form::text('title', null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                        'placeholder' => __('Enter Title'),
                                    ]) }}
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">

                                        <div class="form-group">
                                            <label class="require form-label">{{ __('Consignment (%)') }}</label><x-required></x-required>
                                            {{ Form::number('commission', null, [
                                                'class' => 'form-control',
                                                'id' => 'commission',
                                                'required' => 'required',
                                                'step' => 'any',
                                                'placeholder' => __('Enter Consignment'),
                                            ]) }}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}<x-required></x-required>
                                        <div class="form-icon-user">
                                            {{ Form::date('date', date('Y-m-d'), [
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'placeholder' => __('Select Date'),
                                            ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="customer_detail" class="d-none">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 section_div">
            <h5 class="h4 d-inline-block font-weight-400 mb-4">{{ __('Items') }}</h5>
            <div class="card repeater">
                <div class="item-section py-4">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-md-end px-5">
                            <div class="all-button-box ">
                                <a href="#" data-repeater-create="" class="btn btn-primary mr-2" data-toggle="modal"
                                    data-target="#add-bank">
                                    <i class="ti ti-plus"></i> {{ __('Add item') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table mb-0" data-repeater-list="items" id="sortable-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Price') }} </th>
                                    <th>{{ __('Tax') }} (%)</th>
                                    <th class="text-end">{{ __('Amount') }} </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="ui-sortable" data-repeater-item>
                                <tr>
                                    <td>
                                        <div class="form-group pt-0">
                                            {{ Form::select('product', $products, null, [
                                                'class' => 'form-control product_select',
                                                'data-id' => route('proposal.product'),
                                                'required' => 'required',
                                                'placeholder' => __('Please Select'),
                                            ]) }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group price-input input-group search-form" style="width: 250px">
                                            {{ Form::text('quantity', '', [
                                                'class' => 'form-control quantity',
                                                'required' => 'required',
                                                'placeholder' => __('Qty'),
                                                'required' => 'required',
                                            ]) }}
                                            <span class="unit input-group-text bg-transparent"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input input-group search-form" style="width: 250px">
                                            {{ Form::text('price', '', [
                                                'class' => 'form-control price',
                                                'required' => 'required',
                                                'placeholder' => __('Price'),
                                                'required' => 'required',
                                            ]) }}
                                            <span
                                                class="input-group-text bg-transparent">{{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="taxes">-</div>
                                                {{ Form::hidden('tax', '', ['class' => 'form-control tax']) }}
                                                {{ Form::hidden('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice',]) }}
                                                {{ Form::hidden('itemTaxRate', '', ['class' => 'form-control itemTaxRate']) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end amount">
                                        0.00
                                    </td>
                                    <td>
                                        <div class="action-btn me-2 float-end" data-repeater-delete>
                                            <a href="#!"
                                               class="btn btn-sm align-items-center bg-danger" >
                                               <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                data-bs-original-title="{{ __('Delete') }}" ></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Sub Total') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end subTotal">0.00</td>
                                    <input type="hidden" name="subtotal" id="subtotal">
                                </tr>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Consignment') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end add-consignment">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="border-none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Tax') }}({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end totalTax">0.00</td>
                                    <input type="hidden" name="totalTax" id="totalTax">
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text border-none"><strong>{{ __('Total Amount') }}
                                            ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                                    </td>
                                    <td class="text-end totalAmount blue-text border-none">0.00</td>
                                    <input type="hidden" name="totalamount" id="totalamount">

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer mb-3">
            <input type="button" value="{{ __('Cancel') }}"
                onclick="location.href = '{{ route('consignment.index') }}';" class="btn btn-light mx-3">
            <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection
