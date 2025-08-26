@extends('layouts.main')

@section('page-title')
      {{ __('Show Sale for Return') }}
@endsection

@section('page-breadcrumb')
    {{ __('Purchase') }}
@endsection

@section('action-btn')
    
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <!--<link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/custom.css') }}">-->
    <style>
    .dataTables_filter input {
       padding: 0.575rem 1rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #293240;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
        
    }
    
    
     .dataTables_wrapper .dataTables_paginate .paginate_button {
    margin: 2px;
    border-radius: 0.4rem;
    background-color: #fff;
    color: #6c757d !important;
    border: 1px solid #dee2e6;
    transition: all 0.3s;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #6f42c1;
        color: #fff !important;
        border-color: #6f42c1;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #6f42c1;
        color: white !important;
        border-color: #6f42c1;
    }
    
    #expiry-table_filter{
            margin-top: -25px;
    margin-bottom: 20px;
    }
    


    </style>
@endpush

@push('scripts')
    @include('layouts.includes.datatable-js')
    <script>
        $(document).ready(function() {
            // ✅ Initialize DataTable only ONCE
            $('#expiry-table').DataTable({
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_ entries per page",
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                pageLength: 25,
                initComplete: function() {
                    $('#expiry-table_filter input').attr('placeholder', 'Search...');
                }
            });

            // ✅ Optional: initialize select2 if present
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2();
            }

            // ✅ Optional: Copy link functionality
            $('.copy_link').click(function(e) {
                e.preventDefault();
                var copyText = $(this).attr('href');

                document.addEventListener('copy', function(e) {
                    e.clipboardData.setData('text/plain', copyText);
                    e.preventDefault();
                }, true);

                document.execCommand('copy');
                show_toastr('Success', 'Url copied to clipboard', 'success');
            });
        });

        // ✅ Toggle custom date fields
        function toggleCustomDateFields() {
            if ($('#period').val() === 'custom') {
                $('.custom-date').removeClass('d-none');
            } else {
                $('.custom-date').addClass('d-none');
            }
        }
    </script>
    <script>
       
        function toggleCustomDateFields() {
            if ($('#period').val() === 'custom') {
                $('.custom-date').removeClass('d-none');
            } else {
                $('.custom-date').addClass('d-none');
            }
        }
    </script>
@endpush

@section('page-action')
      
    <!--<div class="float-end">-->
    <!--    <a href="#" onclick="window.print()" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Print') }}">-->
    <!--        <i class="ti ti-printer"></i>-->
    <!--    </a>-->
    <!--</div>-->
   <div class="float-end">
    <a href="#" id="print-content" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Print') }}">
        <i class="ti ti-printer"></i>
    </a>
</div>
    
     <div class="d-flex">
         <x-back-button  route="{{ url('pos/returns') }}" />
    </div>
   
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row invoice-title mt-2">
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                            <h2>{{ __('RETURN') }}</h2>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                            <h3 class="invoice-number">{{ $return->return_id }}</h3>
                          
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="invoice-info">
                                <h5 class="mb-2">{{ __('From') }}</h5>
                                <h6>{{ company_setting('company_name') }}</h6>
                                <p>
                                    {{ company_setting('company_address') }}<br>
                                    {{ company_setting('company_city') }}{{ !empty(company_setting('company_state')) ? ', ' . company_setting('company_state') : '' }}<br>
                                    {{ company_setting('company_zipcode') }}<br>
                                    {{ company_setting('company_country') }}
                                </p>
                                <p>
                                    {{ __('Phone') }}: {{ company_setting('company_telephone') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="invoice-info">
                                <h5 class="mb-2">{{ __('To') }}</h5>
                                <h6>{{ !empty($customer) ? $customer->name : __('Walk-in Customer') }}</h6>
                                @if(!empty($customer) && isset($customer->billing_address))
                                <p>
                                    {{ $customer->billing_address }}<br>
                                    {{ $customer->billing_city }}{{ !empty($customer->billing_state) ? ', ' . $customer->billing_state : '' }}<br>
                                    {{ $customer->billing_zip }}<br>
                                    {{ $customer->billing_country }}
                                </p>
                                @endif
                            </div>
                            <div class="invoice-info mt-4">
                                <h5 class="mb-2">{{ __('Return Details') }}</h5>
                                <p>
                                    {{ __('Return Number') }}: {{ $return->return_id }}<br>
                                    {{ __('Original Sale') }}: {{ \Workdo\Pos\Entities\Pos::posNumberFormat($return->pos->pos_id) }}<br>
                                    {{ __('Return Date') }}: {{ $return->return_date }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Batch') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Tax') }}</th>
                                            <th class="text-end">{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach($returnProducts as $product)
                                       
                                        @php
                                            $price = floatval($product->price);
                                            $tax = floatval($product->tax);
                                            $quantity = floatval($product->quantity);
                                            $tquantity = floatval($product->t_quantity);
                                            
                                            // Prevent division by zero
                                            if ($tquantity > 0) {
                                                $tex_price = ($tax / $tquantity) * $quantity;
                                            } else {
                                                $tex_price = 0; // Default to zero if t_quantity is zero
                                            }
                                            
                                            $subtotal = $price + $tex_price;
                                            $totalAmount += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ \Workdo\ProductService\Entities\ProductService::find($product->product_id)->name }}</td>
                                            <td>{{ $product->batch_no ?? '-' }}</td>
                                            <td>{{ currency_format_with_sym($product->price) }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                @if($product->t_quantity > 0)
                                                    {{ currency_format_with_sym(($product->tax / $product->t_quantity) * $product->quantity) }}
                                                @else
                                                    {{ currency_format_with_sym(0) }}
                                                @endif
                                            </td>
                                            <td class="text-end">{{ currency_format_with_sym($subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>{{ __('Total') }}</strong></td>
                                            <td class="text-end">{{ currency_format_with_sym($totalAmount) }}</td>
                                        </tr>
                                        @if($returnPayment && $returnPayment->discount > 0)
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>{{ __('Discount') }}</strong></td>
                                            <td class="text-end">{{ currency_format_with_sym($returnPayment->discount) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-end"><strong>{{ __('Grand Total') }}</strong></td>
                                            <td class="text-end">{{ currency_format_with_sym($returnPayment->discount_amount) }}</td>
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    @if($return->note)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>{{ __('Note') }}</h5>
                            <p>{{ $return->note }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>{{ __('Payment Information') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Payment Method') }}</th>
                                            <th>{{ __('Reference') }}</th>
                                            <th class="text-end">{{ __('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $returnPayment->date }}</td>
                                            <td>{{ $returnPayment->payment_method ?? __('Cash') }}</td>
                                            <td>{{ $returnPayment->reference ?? '-' }}</td>
                                            <td class="text-end">{{ $returnPayment->amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <script>
    // Function to print the complete row content
    function printCompleteContent() {
        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        
        // Get the complete card content (the entire row with all the return details)
        const contentToPrint = document.querySelector('.row .col-12 .card .card-body');
        
        // Create HTML content for the print window
        let printContent = `
            <html>
            <head>
                <title>Return Details</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        padding: 20px; 
                    }
                    table { 
                        width: 100%; 
                        border-collapse: collapse; 
                        margin-bottom: 20px; 
                    }
                    table, th, td { 
                        border: 1px solid #ddd; 
                    }
                    th, td { 
                        padding: 8px; 
                        text-align: left; 
                    }
                    th { 
                        background-color: #f2f2f2; 
                    }
                    .text-end { 
                        text-align: right; 
                    }
                    .invoice-title {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 20px;
                    }
                    .row {
                        display: flex;
                        flex-wrap: wrap;
                        margin-bottom: 20px;
                    }
                    .col-md-6 {
                        width: 50%;
                        box-sizing: border-box;
                    }
                    .invoice-info {
                        margin-bottom: 15px;
                    }
                    @media print {
                        @page { 
                            margin: 0.5cm; 
                        }
                    }
                </style>
            </head>
            <body>
        `;
        
        // Add the content to print
        if (contentToPrint) {
            printContent += contentToPrint.innerHTML;
        } else {
            printContent += '<p>No content found to print.</p>';
        }
        
        // Close the HTML
        printContent += `
            </body>
            </html>
        `;
        
        // Write to the new window and print
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.focus();
        
        // Print after the content is loaded
        printWindow.onload = function() {
            printWindow.print();
            // Uncomment the following line if you want the print window to close after printing
            // printWindow.close();
        };
    }

    // Add event listener to the print button
    $(document).ready(function() {
        $('#print-content').on('click', function(e) {
            e.preventDefault();
            printCompleteContent();
        });
    });
</script>
@endsection