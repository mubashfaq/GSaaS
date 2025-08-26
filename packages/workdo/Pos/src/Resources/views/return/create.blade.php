@extends('layouts.main')

@section('page-title')
      {{ __('Sale for Return') }}
@endsection

@section('page-breadcrumb')
    {{ __('Purchase') }}
@endsection

@section('action-btn')
    
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <div class="float-end">
         <x-back-button  route="{{ url('/pos/return/select-sale') }}" />
    </div>
@endsection

@section('content')
   <!-- Replace the entire @section('content') with this updated version -->
@section('content')
    <!--<div class="row">-->
    <!--    <div class="col-12">-->
    <!--        <div class="card">-->
    <!--            <div class="card-header">-->
    <!--                <h5>{{ __('Return Details') }}</h5>-->
    <!--            </div>-->
    <!--            <div class="card-body">-->
    <!--                <form method="post" action="{{ route('pos.return.store') }}">-->
    <!--                    @csrf-->
                        
    <!--                    <div class="row mb-4">-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Original Sale') }}</label>-->
    <!--                                <input type="text" class="form-control" value="{{ Workdo\Pos\Entities\Pos::posNumberFormat($pos->pos_id) }}" readonly>-->
    <!--                                <input type="hidden" name="pos_id" value="{{ $pos->id }}">-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Return Number') }}</label>-->
    <!--                                <input type="text" class="form-control" value="{{ $returnId }}" readonly>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Return Date') }}<span class="text-danger">*</span></label>-->
    <!--                                <input type="date" name="return_date" class="form-control" required value="{{ date('Y-m-d') }}">-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        
    <!--                    <div class="row mb-4">-->
    <!--                        <div class="col-md-6">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Customer') }}</label>-->
    <!--                                <input type="text" class="form-control" value="{{ !empty($customer) ? $customer->name : __('Walk-in Customer') }}" readonly>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="col-md-6">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Warehouse') }}</label>-->
    <!--                                <input type="text" class="form-control" value="{{ $warehouse->name }}" readonly>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        
    <!--                    <div class="row mb-4">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Note') }}</label>-->
    <!--                                <textarea name="note" class="form-control" rows="3">{{ __('Return note') }}</textarea>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        
    <!--                    <h5 class="mt-4 mb-3">{{ __('Return Products') }}</h5>-->
                        
    <!--                    <div class="table-responsive">-->
    <!--                        <table class="table table-bordered">-->
    <!--                            <thead>-->
    <!--                                <tr>-->
    <!--                                    <th>{{ __('Product') }}</th>-->
    <!--                                    <th>{{ __('Batch') }}</th>-->
    <!--                                    <th>{{ __('Price') }}</th>-->
    <!--                                    <th>{{ __('Sold Quantity') }}</th>-->
    <!--                                    <th>{{ __('Return Quantity') }}</th>-->
    <!--                                    <th>{{ __('Subtotal') }}</th>-->
    <!--                                </tr>-->
    <!--                            </thead>-->
    <!--                            <tbody>-->
    <!--                                @foreach($posProducts as $key => $product)-->
    <!--                                    <tr>-->
    <!--                                        <td>-->
    <!--                                            {{ \Workdo\ProductService\Entities\ProductService::find($product->product_id)->name }}-->
    <!--                                            <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">-->
    <!--                                        </td>-->
    <!--                                        <td>-->
    <!--                                            {{ $product->batch_no ?? '-' }}-->
    <!--                                            <input type="hidden" name="batch_no[]" value="{{ $product->batch_no }}">-->
    <!--                                        </td>-->
    <!--                                        <td>{{ currency_format_with_sym($product->price) }}</td>-->
    <!--                                        <td>{{ $product->quantity }}</td>-->
    <!--                                        <td>-->
    <!--                                            <input type="number" name="quantity[]" class="form-control return-qty" -->
    <!--                                           min="1" max="{{ $product->quantity }}" value="0" -->
    <!--                                           data-price="{{ $product->price }}" required-->
    <!--                                           onchange="calculateRowSimple(this)" oninput="calculateRowSimple(this)">-->
                                                
    <!--                                        </td>-->
    <!--                                        <td class="subtotal">{{ currency_format_with_sym(0) }}</td>-->
    <!--                                    </tr>-->
    <!--                                @endforeach-->
    <!--                            </tbody>-->
    <!--                            <tfoot>-->
    <!--                                <tr>-->
    <!--                                    <td colspan="5" class="text-end"><strong>{{ __('Total') }}</strong></td>-->
    <!--                                    <td id="return-total">{{ currency_format_with_sym(0) }}</td>-->
    <!--                                </tr>-->
    <!--                            </tfoot>-->
    <!--                        </table>-->
    <!--                    </div>-->
                        
    <!--                    <h5 class="mt-4 mb-3">{{ __('Payment Details') }}</h5>-->
                        
    <!--                    <div class="row mb-4">-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Payment Method') }}</label>-->
    <!--                                <select name="payment_method" class="form-control">-->
    <!--                                    <option value="Cash">{{ __('Cash') }}</option>-->
    <!--                                    <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>-->
    <!--                                    <option value="Credit Card">{{ __('Credit Card') }}</option>-->
    <!--                                </select>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Reference') }}</label>-->
    <!--                                <input type="text" name="reference" class="form-control">-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="col-md-4">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Discount Amount') }}</label>-->
    <!--                                <input type="number" name="discount_amount" class="form-control" value="0" min="0" step="0.01">-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        
    <!--                    <div class="row mb-4">-->
    <!--                        <div class="col-md-12">-->
    <!--                            <div class="form-group">-->
    <!--                                <label class="form-label">{{ __('Payment Note') }}</label>-->
    <!--                                <textarea name="payment_note" class="form-control" rows="3"></textarea>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
                        
    <!--                    <div class="row mt-4">-->
    <!--                        <div class="col-md-12 text-end">-->
    <!--                            <button type="submit" class="btn btn-primary">{{ __('Create Return') }}</button>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Return Details') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('pos.return.store') }}">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Original Sale') }}</label>
                                <input type="text" class="form-control" value="{{ Workdo\Pos\Entities\Pos::posNumberFormat($pos->pos_id) }}" readonly>
                                <input type="hidden" name="pos_id" value="{{ $pos->id }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Return Number') }}</label>
                                <input type="text" class="form-control" value="{{ $returnId }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Return Date') }}<span class="text-danger">*</span></label>
                                <input type="date" name="return_date" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Customer') }}</label>
                                <input type="text" class="form-control" value="{{ !empty($customer) ? $customer->name : __('Walk-in Customer') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Warehouse') }}</label>
                                <input type="text" class="form-control" value="{{ $warehouse->name }}" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('Note') }}</label>
                                <textarea name="note" class="form-control" rows="3">{{ __('Return note') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="mt-4 mb-3">{{ __('Return Products') }}</h5>
                    
                    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Batch') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Tax Price') }}</th>
                <th>{{ __('Sold Quantity') }}</th>
                <th>{{ __('Already Returned') }}</th>
                <th>{{ __('Available to Return') }}</th>
                <th>{{ __('Return Quantity') }}</th>
                <th>{{ __('Subtotal') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posProducts as $key => $product)
                @php
                    $productKey = $product->product_id . '-' . ($product->batch_no ?? 'null');
                    $alreadyReturned = isset($returnedQuantities[$productKey]) ? $returnedQuantities[$productKey] : 0;
                    $availableToReturn = $product->quantity - $alreadyReturned;
                @endphp
                <tr>
                    <td>
                        {{ \Workdo\ProductService\Entities\ProductService::find($product->product_id)->name }}
                        <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                    </td>
                    <td>
                        {{ $product->batch_no ?? '-' }}
                        <input type="hidden" name="batch_no[]" value="{{ $product->batch_no }}">
                    </td>
                    <td>{{ currency_format_with_sym($product->price) }}</td>
                     <td>{{ currency_format_with_sym($product->tex_price) }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $alreadyReturned }}</td>
                    <td>{{ $availableToReturn }}</td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control return-qty" 
                           min="0" max="{{ $availableToReturn }}" value="0" 
                           data-price="{{ $product->price }}" data-tax-price="{{ $product->tex_price }}" data-quantity="{{ $product->quantity }}" required
                           onchange="calculateRowSimple(this)" oninput="calculateRowSimple(this)"
                           {{ $availableToReturn <= 0 ? 'disabled' : '' }}>
                    </td>
                    <td class="subtotal">{{ currency_format_with_sym(0) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="text-end"><strong>{{ __('Total') }}</strong></td>
                <td id="return-total">{{ currency_format_with_sym(0) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
                    
                    <h5 class="mt-4 mb-3">{{ __('Payment Details') }}</h5>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Payment Method') }}</label>
                                <select name="payment_method" class="form-control">
                                    <option value="Cash">{{ __('Cash') }}</option>
                                    <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                                    <option value="Credit Card">{{ __('Credit Card') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Reference') }}</label>
                                <input type="text" name="reference" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Discount Amount') }}</label>
                                <input type="number" name="discount_amount" class="form-control" value="0" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">{{ __('Payment Note') }}</label>
                                <textarea name="payment_note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary" id="submit-return">{{ __('Create Return') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Updated JavaScript for better return calculation

// Function to calculate row subtotal
// function calculateRowSimple(element) {
//     var qtyInput = element;
//     var qty = parseFloat(qtyInput.value) || 0;
//     var price = parseFloat(qtyInput.getAttribute('data-price')) || 0;
//     var Taxprice = parseFloat(qtyInput.getAttribute('data-tax-price')) || 0;
//     var soldQuantity = parseFloat(qtyInput.getAttribute('data-quantity')) || 0;
//     var maxQty = parseFloat(qtyInput.getAttribute('max')) || 0;
//       var texPreProduct = Taxprice / soldQuantity ;
    
//     // Ensure quantity doesn't exceed max available
//     if (qty > maxQty) {
//         qtyInput.value = maxQty;
//         qty = maxQty;
//     }
   
//     // Calculate row subtotal
//     var subtotal = (qty * price) + texPreProduct;
    
//     // Update the subtotal display
//     var subtotalElement = qtyInput.closest('tr').querySelector('.subtotal');
//     // Use the existing currency formatting function from your system
//     subtotalElement.innerHTML = subtotal;
    
//     // Recalculate total
//     calculateTotal();
// }

// // Calculate the total amount
// function calculateTotal() {
//     var total = 0;
//     var qtyInputs = document.querySelectorAll('.return-qty');
//     var hasReturnItems = false;
    
//     qtyInputs.forEach(function(input) {
//         var qty = parseFloat(input.value) || 0;
//         var price = parseFloat(input.getAttribute('data-price')) || 0;
       
//          var Taxprice = parseFloat(input.getAttribute('data-tax-price')) || 0;
//           var texPreProduct = Taxprice / qty ;
//         total += (qty * price) +texPreProduct;
        
//         if (qty > 0) {
//             hasReturnItems = true;
//         }
//     });
    
//     // Update total display using the existing currency formatting function
//     document.getElementById('return-total').innerHTML = total;
    
//     // Enable/disable submit button based on whether any items are being returned
//     document.getElementById('submit-return').disabled = !hasReturnItems;
// }



function calculateRowSimple(element) {
    var qtyInput = element;
    var qty = parseFloat(qtyInput.value) || 0;
    var price = parseFloat(qtyInput.getAttribute('data-price')) || 0;
    var Taxprice = parseFloat(qtyInput.getAttribute('data-tax-price')) || 0;
    var soldQuantity = parseFloat(qtyInput.getAttribute('data-quantity')) || 0;
    var maxQty = parseFloat(qtyInput.getAttribute('max')) || 0;
    
    // Ensure quantity doesn't exceed max available
    if (qty > maxQty) {
        qtyInput.value = maxQty;
        qty = maxQty;
    }
   
    // Calculate tax per product - ensure we don't divide by zero
    var taxPerProduct = 0;
    if (soldQuantity > 0) {
        taxPerProduct = Taxprice / soldQuantity;
    }
    
    // Calculate row subtotal - tax is applied to the quantity being returned
    var subtotal = (qty * price) + (qty * taxPerProduct);
    
    // Update the subtotal display
    var subtotalElement = qtyInput.closest('tr').querySelector('.subtotal');
    subtotalElement.innerHTML = subtotal.toFixed(2); // Format to 2 decimal places
    
    // Recalculate total
    calculateTotal();
}

// Calculate the total amount
function calculateTotal() {
    var total = 0;
    var qtyInputs = document.querySelectorAll('.return-qty');
    var hasReturnItems = false;
    
    qtyInputs.forEach(function(input) {
        var qty = parseFloat(input.value) || 0;
        var price = parseFloat(input.getAttribute('data-price')) || 0;
        var Taxprice = parseFloat(input.getAttribute('data-tax-price')) || 0;
        var soldQuantity = parseFloat(input.getAttribute('data-quantity')) || 0;
        
        if (qty > 0) {
            hasReturnItems = true;
            
            // Calculate tax per product - ensure we don't divide by zero
            var taxPerProduct = 0;
            if (soldQuantity > 0) {
                taxPerProduct = Taxprice / soldQuantity;
            }
            
            // Add to total with proper tax calculation
            total += (qty * price) + (qty * taxPerProduct);
        }
    });
    
    // Update total display with proper formatting
    document.getElementById('return-total').innerHTML = total.toFixed(2);
    
    // Enable/disable submit button based on whether any items are being returned
    document.getElementById('submit-return').disabled = !hasReturnItems;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Calculate initial totals
    calculateTotal();
    
    // Form validation before submission
    document.querySelector('form').addEventListener('submit', function(event) {
        var hasReturnItems = false;
        var qtyInputs = document.querySelectorAll('.return-qty');
        
        qtyInputs.forEach(function(input) {
            if ((parseFloat(input.value) || 0) > 0) {
                hasReturnItems = true;
            }
        });
        
        if (!hasReturnItems) {
            event.preventDefault();
            alert('Please select at least one product to return.');
            return false;
        }
        
        return true;
    });
});
</script>
    
   
<!--<script>-->
<!--    // Wait for document to be fully loaded-->
<!--    document.addEventListener('DOMContentLoaded', function() {-->
<!--        // Add event listeners to all return-qty inputs-->
<!--        var qtyInputs = document.querySelectorAll('.return-qty');-->
<!--        qtyInputs.forEach(function(input) {-->
<!--            input.addEventListener('input', function() {-->
<!--                validateAndCalculate(this);-->
<!--            });-->
<!--            input.addEventListener('change', function() {-->
<!--                validateAndCalculate(this);-->
<!--            });-->
<!--        });-->
        
<!--        // Initial calculation-->
<!--        calculateTotalSimple();-->
<!--    });-->

<!--    // Validate quantity and then calculate-->
<!--    function validateAndCalculate(input) {-->
<!--        try {-->
<!--            // Get max quantity from the max attribute-->
<!--            var maxQty = parseInt(input.getAttribute('max')) || 0;-->
<!--            var currentQty = parseInt(input.value) || 0;-->
            
<!--            // Get product name for better message-->
<!--            var row = input.closest('tr');-->
<!--            var productName = row.querySelector('td:first-child').textContent.trim();-->
            
<!--            // Validate: Don't allow more than max-->
<!--            if (currentQty > maxQty) {-->
<!--                // Use SweetAlert for a nicer alert-->
<!--                Swal.fire({-->
<!--                    title: 'Invalid Quantity',-->
<!--                    text: 'You cannot return more than ' + maxQty + ' items for ' + productName,-->
<!--                    icon: 'warning',-->
<!--                    confirmButtonText: 'OK',-->
<!--                    confirmButtonColor: '#6f42c1' // Matches your UI color-->
<!--                });-->
                
<!--                input.value = maxQty; // Reset to maximum allowed-->
<!--            }-->
            
<!--            // Also don't allow negative values-->
<!--            if (currentQty < 0) {-->
<!--                input.value = 0;-->
<!--            }-->
            
<!--            // Now calculate-->
<!--            calculateRowSimple(input);-->
<!--        } catch (e) {-->
<!--            console.error('Error in validation:', e);-->
<!--        }-->
<!--    }-->

<!--    // Simple calculation function that avoids any JSON parsing-->
<!--    function calculateRowSimple(input) {-->
<!--        try {-->
<!--            // Basic calculations without any complex formatting-->
<!--            var qty = parseFloat(input.value) || 0;-->
<!--            var price = parseFloat(input.getAttribute('data-price')) || 0;-->
<!--            var subtotal = qty * price;-->
            
<!--            // Find the subtotal cell and update it with basic formatting-->
<!--            var row = input.closest('tr');-->
<!--            var subtotalCell = row.querySelector('.subtotal');-->
            
<!--            // Use your currency symbol here (you may need to adjust this)-->
<!--            subtotalCell.textContent = '$' + subtotal.toFixed(2);-->
            
<!--            // Recalculate the total-->
<!--            calculateTotalSimple();-->
<!--        } catch (e) {-->
<!--            console.error('Error in calculation:', e);-->
<!--        }-->
<!--    }-->
    
<!--    // Simple total calculation that avoids any JSON parsing-->
<!--    function calculateTotalSimple() {-->
<!--        try {-->
<!--            var total = 0;-->
<!--            var qtyInputs = document.querySelectorAll('.return-qty');-->
            
<!--            qtyInputs.forEach(function(input) {-->
<!--                var qty = parseFloat(input.value) || 0;-->
<!--                var price = parseFloat(input.getAttribute('data-price')) || 0;-->
<!--                total += qty * price;-->
<!--            });-->
            
<!--            // Update the total cell with basic formatting-->
<!--            var totalCell = document.getElementById('return-total');-->
<!--            totalCell.textContent = '$' + total.toFixed(2);-->
<!--        } catch (e) {-->
<!--            console.error('Error in total calculation:', e);-->
<!--        }-->
<!--    }-->
<!--</script>-->
@endsection



