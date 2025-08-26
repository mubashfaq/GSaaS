@php
    $company_settings = getCompanyAllSetting();
@endphp
<h5 class="h4 d-inline-block font-weight-400 mb-4">{{ __('Restaurant Menu') }}</h5>
<div class="card repeater" data-value='{!! json_encode($transformedData) !!}'>
    <div class="card-body table-border-style mt-2">
        <div class="table-responsive">
            <table class="table  mb-0 table-custom-style" data-repeater-list="items" id="sortable-table">
                <thead>
                    <tr>
                        <th>{{ __('Items') }}</th>
                        <th>{{ __('Price') }} </th>
                        <th>{{ __('Quantity') }} </th>
                        <th>{{ __('Discount') }}</th>
                        <th></th>
                        <th>{{ __('Tax') }} (%)</th>

                        <th class="text-end">{{ __('Amount') }} <br><small
                                class="text-danger font-weight-bold">{{ __('After discount & tax') }}</small>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="ui-sortable" data-repeater-item>
                    <tr>
                        {{ Form::hidden('id', null, ['class' => 'form-control id']) }}
                        {{ Form::hidden('item_id', null, ['class' => 'form-control item_id']) }}
                        <td width="25%" class="form-group pt-0 product_div">
                            {{ Form::text('item_name', null, ['class' => 'form-control ', 'required' => 'required']) }}
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form mb-0" style="width: 200px">
                                {{ Form::text('sales_price', '', ['class' => 'form-control price', 'required' => 'required', 'placeholder' => __('Price')]) }}
                                <span
                                class="input-group-text bg-transparent">{{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0" style="width: 160px">
                                {{ Form::number('quantity', 1, ['class' => 'form-control quantity', 'required' => 'required']) }}
                            </div>
                        </td>
                        <td>
                            <div class="form-group price-input input-group search-form mb-0" style="width: 160px">
                                {{ Form::text('discount', '', ['class' => 'form-control discount', 'required' => 'required', 'placeholder' => __('Discount')]) }}
                                <span
                                    class="input-group-text bg-transparent">{{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }}</span>
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="form-group mb-0">
                                <div class="input-group colorpickerinput">
                                    <div class="taxes"></div>
                                    {{ Form::hidden('tax', '', ['class' => 'form-control tax text-dark']) }}
                                    {{ Form::hidden('itemTaxPrice', '', ['class' => 'form-control itemTaxPrice']) }}
                                    {{ Form::hidden('itemTaxRate', '', ['class' => 'form-control itemTaxRate']) }}
                                    {{ Form::hidden('tax_data', '', ['class' => 'form-control tax_data']) }}
                                </div>
                            </div>
                        </td>

                        <td class="text-end amount">{{ __('0.00') }}</td>
                        <td>
                            <a href="#" class="action-btn ms-2 float-end" data-repeater-delete>
                                <div class="mx-3 btn btn-sm d-inline-flex align-items-center m-2 p-2 bg-danger">
                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip" data-bs-original-title="Delete"></i>
                                </div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="form-group mb-0">
                                {{ Form::textarea('description', null, ['class' => 'form-control pro_description', 'rows' => '2', 'placeholder' => __('Description')]) }}
                            </div>
                        </td>
                        <td colspan="5"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td><strong>{{ __('Sub Total') }}
                                ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end subTotal">{{ __('0.00') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>                    
                        <td></td>
                        <td><strong>{{ __('Discount') }}
                                ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end totalDiscount">{{ __('0.00') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                        <td><strong>{{ __('Tax') }}
                                ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end totalTax">{{ __('0.00') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="blue-text"><strong>{{ __('Total Amount') }}
                                ({{ isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '' }})</strong>
                        </td>
                        <td class="text-end totalAmount blue-text">{{ __('0.00') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        var value = $(selector + " .repeater").attr('data-value');
        if (typeof value != 'undefined' && value.length != 0) {
            value = JSON.parse(value);
            $repeater.setList(value);

            // Remove delete button for first row
            $('.repeater [data-repeater-item]').first().find('[data-repeater-delete]').remove();

            $('.product_div').parent().each(function(key, ele) {
                var price = $(ele).find('.price').val();
                $(ele).find('.amount').html(parseFloat(price).toFixed(2));
                var obj = jQuery.parseJSON($(ele).find('.tax_data').val());

                var taxes = '';

                $.each(obj, function(ind, ele) {

                    taxes += '<span class="badge bg-primary p-2 px-3 me-1">' +
                        this.name + ' ' + '(' + this.rate + '%)' +
                        '</span>';


                    $(ele).find(".tax").val(this.id);

                });
                $(ele).find('.taxes').html(taxes);

                var totalItemTaxPrice = 0;
                var itemTaxPriceInput = $('.itemTaxPrice');

                for (var j = 0; j < itemTaxPriceInput.length; j++) {
                    totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                }
                $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            });

            var totalItemPrice = 0;
            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += parseFloat(priceInput[j].value);
            }
            $('.subTotal').html(totalItemPrice.toFixed(2));

            var totalItemDiscountPrice = 0;
            var itemDiscountPriceInput = $('.discount');

            for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                if (itemDiscountPriceInput[k].value == '') {
                    itemDiscountPriceInput[k].value = parseFloat(0);
                }
                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
            }
            $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal += parseFloat($(inputs[i]).html());
            }
            subTotal = (subTotal - parseFloat(totalItemDiscountPrice.toFixed(2))) + parseFloat($('.totalTax').html());
            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));

        }
        const elementsToRemove = document.querySelectorAll('.bs-pass-para.repeater-action-btn');
        if (elementsToRemove.length > 0) {
            elementsToRemove[0].remove();
        }

        $( ".price" ).each(function( index ) {
            $(this).trigger("change");
        });
    });
</script>
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
                var $row = $(this); // The current row
                var id = $row.find('.id').val(); // Get the item ID
                // Call the global delete function
                deleteInvoiceItem($row, id, function() {

                    var totalItemTaxPrice = 0;
                    var itemTaxPriceInput = $('.itemTaxPrice');
                    for (var j = 0; j < itemTaxPriceInput.length; j++) {
                        totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                    }
                    var totalItemPrice = 0;
                    var inputs_quantity = $(".quantity");
                    var priceInput = $('.price');
                    for (var j = 0; j < priceInput.length; j++) {
                        totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
                    }
                    var inputs = $(".amount");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    var totalItemDiscountPrice = 0;
                    var itemDiscountPriceInput = $('.discount');
                    for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                        if (itemDiscountPriceInput[k].value == '') {
                            itemDiscountPriceInput[k].value = parseFloat(0);
                        }
                        totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                    }
                    $('.subTotal').html(totalItemPrice.toFixed(2));
                    $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                    $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
                    $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
                });
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
 
