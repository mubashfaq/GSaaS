@extends('layouts.main')

@section('page-title')
     {{ __('Create Purchase Return') }}
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
        // $(document).ready(function() {
        //     // Initialize DataTable
        //     $('#expiry-table').DataTable({
        //         dom: '<"top"lf>rt<"bottom"ip><"clear">',
        //         language: {
        //             search: "",
        //             lengthMenu: "_MENU_ entries per page"
        //         },
        //         pageLength: 25,
        //         initComplete: function() {
        //             $('#expiry-table_filter input').attr('placeholder', 'Search...');
        //         }
        //     });

        //     // If you have select2 anywhere
        //     if (typeof $.fn.select2 !== 'undefined') {
        //         $('.select2').select2();
        //     }

        //     // Copy link functionality (optional)
        //     $('.copy_link').click(function(e) {
        //         e.preventDefault();
        //         var copyText = $(this).attr('href');

        //         document.addEventListener('copy', function(e) {
        //             e.clipboardData.setData('text/plain', copyText);
        //             e.preventDefault();
        //         }, true);

        //         document.execCommand('copy');
        //         show_toastr('Success', 'Url copied to clipboard', 'success');
        //     });
        // });

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

       
    <div class="d-flex">
       <x-back-button  route="{{ url('/purchase/returns') }}" />
    </div>
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['url' => 'purchase/returns', 'method' => 'post']) }}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('purchase_id', __('Purchase'), ['class' => 'form-label']) }}
                                {{ Form::select('purchase_id', $purchases, !empty($selectedPurchase) ? $selectedPurchase->id : '', ['class' => 'form-control select', 'id' => 'purchases', 'required' => 'required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('return_date', __('Return Date'), ['class' => 'form-label']) }}
                                {{ Form::date('return_date', date('Y-m-d'), ['class' => 'form-control', 'required' => 'required']) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('return_number', __('Return Number'), ['class' => 'form-label']) }}
                                {{ Form::text('return_number', $return_number, ['class' => 'form-control', 'readonly' => 'true']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('return_reason', __('Return Reason'), ['class' => 'form-label']) }}
                                {{ Form::textarea('return_reason', null, ['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="product-list-container">
            @if(!empty($selectedPurchase) && !empty($purchaseProducts))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Product Items') }}</h5>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                           <tr>
                                                <th>{{ __('Product') }}</th>
                                                <th>{{ __('Batch No.') }}</th>
                                                <th>{{ __('Total Quantity') }}</th>
                                                <th>{{ __('Remaining Quantity') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Tax') }}</th>
                                                <th>{{ __('Return Quantity') }}</th>
                                                <th>{{ __('Subtotal') }}</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($purchaseProducts as $key => $product)
                                            <tr>
                                                <td>
                                                    {{ !empty($product->product) ? $product->product->name : '' }}
                                                    <input type="hidden" name="items[{{ $key }}][id]" value="{{ $product->id }}">
                                                </td>
                                                <td>{{ $product->batch_no }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->remaining_qty }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->tax_name }} ({{ $product->tax_rate }}%)</td>
                                                <td>
                                                   <input type="number" class="form-control return-qty" name="items[{{ $key }}][return_qty]" 
                                                        min="0" max="{{ $product->remaining_qty }}" value="0"
                                                        {{ $product->remaining_qty <= 0 ? 'disabled' : '' }}>
                                                </td>
                                                <td class="text-end product-subtotal" data-price="{{ $product->price }}" data-tax="{{ $product->tax_rate }}">
                                                    {{ 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-end"><strong>{{ __('Subtotal') }}:</strong></td>
                                            <td class="text-end" id="return-subtotal">{{ 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-end"><strong>{{ __('Tax') }}:</strong></td>
                                            <td class="text-end" id="return-tax">{{ 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td class="text-end"><strong>{{ __('Total') }}:</strong></td>
                                            <td class="text-end" id="return-total">{{ 0 }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-12 text-end">
            <div class="d-flex justify-content-end mt-2">
                <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
                <a href="{{ route('purchase.returns.index') }}" class="btn btn-danger ms-2">{{ __('Cancel') }}</a>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <script>
    // Make sure this is placed at the bottom of your blade file or after jQuery is loaded
$(document).ready(function() {
    // Debug to verify jQuery is loaded
    console.log("Document ready! jQuery version:", $.fn.jquery);
    /////////
    $(document).ready(function() {
        // Update calculations when return quantity changes
        $('.return-qty').on('input', function() {
            calculateProductSubtotals();
        });
        
        function calculateProductSubtotals() {
            let subtotal = 0;
            let totalTax = 0;
            
            $('.return-qty').each(function() {
                const row = $(this).closest('tr');
                const qty = parseFloat($(this).val()) || 0;
                const price = parseFloat(row.find('.product-subtotal').data('price')) || 0;
                const taxRate = parseFloat(row.find('.product-subtotal').data('tax')) || 0;
                
                const linePrice = price * qty;
                const lineTax = (linePrice * taxRate) / 100;
                
                const lineSubtotal = linePrice;
                
                // Update subtotal display
                row.find('.product-subtotal').text(formatPrice(lineSubtotal));
                
                // Add to totals
                subtotal += lineSubtotal;
                totalTax += lineTax;
            });
            
            // Update footer
            $('#return-subtotal').text(formatPrice(subtotal));
            $('#return-tax').text(formatPrice(totalTax));
            $('#return-total').text(formatPrice(subtotal + totalTax));
        }
        
        function formatPrice(amount) {
            // Use the same price format as your priceFormat() function
            // This is a simple implementation - adjust as needed to match your system
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }
    });
    
    
    
    
    
    
    
    
    
    
    // Check if the purchases dropdown exists
    if ($('#purchases').length) {
        console.log("Found purchases dropdown");
        
        // Add an event listener for select change
        $('#purchases').on('change', function() {
            console.log("Purchase select changed!");
            var purchase_id = $(this).val();
            console.log("Selected purchase ID:", purchase_id);
            
            if (purchase_id) {
                $.ajax({
                    url: "{{ route('purchase.returns.get.products', '') }}/" + purchase_id,
                    type: "GET",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        console.log("AJAX request sending to:", "{{ route('purchase.returns.get.products', '') }}/" + purchase_id);
                    },
                    success: function(data) {
                        console.log("AJAX success:", data);
                        $('#product-list-container').html(data.html);
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error);
                        console.log('Response Text:', xhr.responseText);
                    }
                });
            } else {
                $('#product-list-container').html('');
            }
        });
    } else {
        console.log("ERROR: Purchases dropdown not found in DOM!");
    }
});
    </script>
@endsection


