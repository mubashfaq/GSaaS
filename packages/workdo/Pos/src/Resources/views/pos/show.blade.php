@if (!empty($sales) && count($sales) > 0)

    <div class="container">
        <div class="row align-items-center mb-4 invoice mt-2">
            <div class="col invoice-details">
                <h1 class="invoice-id h6">{{ $details['pos_id'] }}</h1>
                <div class="date"><b>{{ __('Date') }}: </b>{{ $details['date'] }}</div>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="text-dark mb-0 mt-2"><b>{{ __('Warehouse Name') }}: </b>{!! $details['warehouse']['details'] !!}</div>
            </div>
        </div>
        <div class="row invoice mt-2">
            <div class="col contacts d-flex justify-content-between pb-4">
                <div class="invoice-to">
                    <div class="text-dark h6"><b>{{ __('Billed To :') }}</b></div>
                    {!! $details['customer']['details'] !!}
                </div>
                @if (!empty($details['customer']['shippdetails']))
                    <div class="invoice-to">
                        <div class="text-dark h6"><b>{{ __('Shipped To :') }}</div>
                        {!! $details['customer']['shippdetails'] !!}
                    </div>
                @endif
                <div class="company-details">
                    <div class="text-dark h6"><b>{{ __('From:') }}</b></div>
                    {!! $details['user']['details'] !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="invoice-table" data-repeater-list="items">
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">{{ __('Items') }}</th>
                            <th>{{ __('Quantity') }}</th>
                             
                            <th class="text-right">{{ __('Price') }}</th>
                            <th class="text-right">{{ __('Discount') }}</th>
                            <th class="text-right">{{ __('Tax') }}</th>
                            <th class="text-right">{{ __('Tax Amount') }}</th>
                            <th class="text-right">{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (array_key_exists('data', $sales))
                            @foreach ($sales['data'] as $key => $value)
                                <tr>
                                    <td class="cart-summary-table text-left">
                                        {{ $value['name'] }}
                                    </td>
                                    <td class="cart-summary-table">
                                        {{ $value['quantity'] }}
                                    </td>
                                   
                                    <td class="text-right cart-summary-table">
                                        {{ $value['price'] }}
                                    </td>
                                     <td class="cart-summary-table">
                                        {{ $value['discount'] }}
                                      
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {!! $value['product_tax'] !!}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['tax_amount'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['subtotal'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="">{{ __('Sub Total') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                             <td></td>
                            <td class="text-right">{{ $sales['sub_total'] }}</td>
                        </tr>

                        <!--<tr>-->
                        <!--    <td class="">{{ __('Discount') }}</td>-->
                        <!--    <td></td>-->
                        <!--    <td></td>-->
                        <!--    <td></td>-->
                        <!--    <td></td>-->
                        <!--     <td></td>-->
                        <!--    <td class="text-right">{{ $sales['discount'] }}</td>-->
                        <!--</tr>-->
                        <tr>
                            <td class="text-left font-weight-bold">{{ __('Total') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                             <td></td>
                            <td class="text-right font-weight-bold">{{ $sales['total'] }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>
            
            @if ($details['pay'] == 'show')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('FBR Integration') }}</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="fbr_integration" id="fbr_yes" value="1" >
                                <label class="form-check-label" for="fbr_yes">
                                    {{ __('Yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="fbr_integration" id="fbr_no" value="0" checked>
                                <label class="form-check-label" for="fbr_no">
                                    {{ __('No') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_type" class="form-label">{{ __('Payment Method') }}</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="cash">{{ __('Cash') }}</option>
                                <option value="bank">{{ __('Bank Transfer') }}</option>
                                <option value="card">{{ __('Card') }}</option>
                                <option value="jazzcash">{{ __('JazzCash') }}</option>
                                <option value="easypaisa">{{ __('Easy Paisa') }}</option>
                                <option value="other">{{ __('Other') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-success payment-done-btn rounded mb-3 float-right"
                        data-url="{{ route('pos.printview') }}" 
                        data-ajax-popup="true" 
                        data-size="sm"
                        data-bs-toggle="tooltip" 
                        data-title="{{ __('POS Invoice Daleep') }}">
                        {{ __('Complete Payment') }}
                </button>
            @endif
        </div>

    </div>

@endif

<!-- Common Modal for Print View -->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ isset($company_settings['pos_logo']) ? $company_settings['pos_logo'] : 'https://dev.gsaas.com.au/uploads/logo/logo_dark_1753348639.png?1753348654' }}" style="width:130px;margin:auto;" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="reload_page" aria-label="Close" style="margin:0px !important;position:absolute;top:10px;right:10px;"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
    <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"> </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Required CSS and JS Dependencies -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/dash.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/custom.js') }}"></script>
<script>
    var filename = $('#filename').val()

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: filename,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A2'
            }
        };
        html2pdf().set(opt).from(element).save();
    }

    $(document).on('click', '.payment-done-btn', function(e) {
        e.preventDefault();
        var ele = $(this);
        var printUrl = ele.data('url');
        var ajaxPopup = ele.data('ajax-popup');
        var popupSize = ele.data('size');
        var popupTitle = ele.data('title');
        
        // Store button attributes before removing
        localStorage.setItem("payment_type", $('#payment_type').val());
        
        $.ajax({
            url: "{{ route('pos.data.store') }}",
            method: 'GET',
            data: {
                vc_name: $('#vc_name_hidden').val(),
                warehouse_name: $('#warehouse_name_hidden').val(),
                discount: $('#discount_hidden').val(),
                quotation_id : $('#quotation_id').val(),
                payment_type: $('#payment_type').val(),
                fbr_integration: $('input[name="fbr_integration"]:checked').val(),
            },
            beforeSend: function() {
                ele.prop('disabled', true).text('{{ __('Processing...') }}');
            },
            success: function(data) {
                if (data.code == 200) {
                    // Removed cart reload to prevent interference with modal content
                    // $('#carthtml').load(document.URL + ' #carthtml');
                    console.log(localStorage.getItem("payment_type"));
                    show_toastr('success', data.success, 'success');
                    
                    // After successful store, trigger the print view
                    if (printUrl && ajaxPopup) {
                        // Call the printview API with the same data to get updated FBR number
                        var printData = {
                            vc_name: $('#vc_name_hidden').val(),
                            warehouse_name: $('#warehouse_name_hidden').val(),
                            discount: $('#discount_hidden').val(),
                            quotation_id: $('#quotation_id').val(),
                            payment_type: $('#payment_type').val(),
                            fbr_integration: $('input[name="fbr_integration"]:checked').val(),
                            cart_data: data.cart_data, // Pass cart data from store API response
                        };
                        
                        $.ajax({
                            url: printUrl,
                            method: 'GET',
                            data: printData,
                            success: function(printResponse) {
                                // Load the response into the modal
                                $('#commonModal .modal-title').html(popupTitle);
                                $('#commonModal .modal-dialog').removeClass('modal-sm modal-md modal-lg');
                                $('#commonModal .modal-dialog').addClass('modal-' + popupSize);
                                $('#commonModal .body').html(printResponse);
                                $("#commonModal").modal('show');
                                
                                // Initialize any required scripts
                                taskCheckbox();
                                common_bind("#commonModal");
                                commonLoader();
                            },
                            error: function(printError) {
                                console.error('Error loading print view:', printError);
                                show_toastr('{{ __('Error') }}', 'Failed to load print view', 'error');
                            }
                        });
                    } else if (printUrl) {
                        // Simple redirect to print view
                        window.open(printUrl, '_blank');
                    }
                    
                    // Remove the button after successful completion
                    ele.remove();
                } else {
                    ele.prop('disabled', false).text('{{ __('Complete Payment') }}');
                    show_toastr('{{ __('Error') }}', data.message || 'Something went wrong', 'error');
                }
            },
            error: function(data) {
                data = data.responseJSON;
                show_toastr('{{ __('Error') }}', data.error, 'error');
                ele.prop('disabled', false).text('{{ __('Complete Payment') }}');
            }
        });
    });


</script>