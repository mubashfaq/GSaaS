@extends('layouts.main')

@section('page-title')
    {{ __('Products Transfer') }}
@endsection

@section('page-breadcrumb')
    {{ __('Products Transfer') }}
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
    <!--<div class="d-flex">-->
    <!--    @stack('addButtonHook')-->
    <!--    <a href="{{ route('purchases.grid') }}" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip" title="{{ __('Grid View') }}">-->
    <!--        <i class="ti ti-layout-grid text-white"></i>-->
    <!--    </a>-->
    <!--</div>-->
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('Products Transfer') }}</h5>
                <div class="float-end">
                    @stack('addButtonHook')
                    <x-back-button  route="{{ url('/workspace-transfer') }}" />
                </div>
            </div>
        </div>
        <div style="padding: 20px;">
            {{ Form::open(array('url' => 'workspace-transfer/store','class' => 'needs-validation', 'novalidate')) }}
            <div class="modal-body">
            <!-- Fixed fields that don't repeat -->
                <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="from_warehouse">{{__('From Warehouse (Current Workspace)')}}</label>
                <select class="form-control" name="from_warehouse" id="from_warehouse" required>
                    @foreach($from_warehouses as $key => $warehouse)
                        <option value="{{$key}}">{{$warehouse}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="to_workspace">{{__('To Workspace (Optional)')}}</label>
                <select class="form-control" name="to_workspace" id="to_workspace">
                    @foreach($workspaces as $key => $workspace)
                        <option value="{{$key}}">{{$workspace}}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Leave empty for same workspace transfer</small>
            </div>
        </div>
    </div>

                <div class="row">
                    <!--<div class="col-md-6">-->
                    <!--    <div class="form-group">-->
                    <!--        <label for="to_warehouse">{{__('To Warehouse')}}</label>-->
                    <!--        <select class="form-control" name="to_warehouse" id="to_warehouse" required>-->
                    <!--            @foreach($to_warehouses as $key => $warehouse)-->
                    <!--                <option value="{{$key}}">{{$warehouse}}</option>-->
                    <!--            @endforeach-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">{{__('Date')}}</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>
                    </div>
                </div>

            <!-- Products section header with add button -->
                 <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>{{__('Products to Transfer')}}</h5>
                <button type="button" class="btn btn-success btn-sm" id="add-product-row">
                    <i class="fa fa-plus"></i> {{__('Add Product')}}
                </button>
            </div>
        </div>
    </div>

            <!-- Dynamic product rows container -->
                 <div id="products-container">
        <div class="product-row" data-row="0">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="product_id_0">{{__('Product')}}</label>
                        <select class="form-control product-select" name="products[0][product_id]" id="product_id_0" required>
                            <option value="">Select Product</option>
                            @foreach($ware_pro as $key => $product)
                                <option value="{{$key}}">{{$product}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="quantity_0">{{__('Quantity')}}</label>
                        <input type="number" class="form-control quantity-input" name="products[0][quantity]" id="quantity_0" min="1" required>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{__('Available')}}</label>
                        <div class="form-control-plaintext available-qty" id="available_0">-</div>
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm remove-product-row d-block" style="display: none;">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
            </div>
            <div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>
        </div>    
        

<script>
$(document).ready(function() {
    let rowIndex = 0;
    
    // When workspace changes, update the to_warehouse dropdown
    $('#to_workspace').on('change', function() {
        var workspace_id = $(this).val();
        if(workspace_id) {
            $.ajax({
                url: '{{ route("warehouses-transfer.getWarehousesByWorkspace") }}',
                type: 'POST',
                data: {
                    workspace_id: workspace_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#to_warehouse').empty();
                    $('#to_warehouse').append('<option value="">Select Warehouse</option>');
                    $.each(response, function(key, value) {
                        $('#to_warehouse').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            location.reload();
        }
    });
    
    // When from_warehouse changes, update all product dropdowns
    $('#from_warehouse').on('change', function() {
        var warehouse_id = $(this).val();
        $('.product-select').each(function() {
            updateProductDropdown($(this), warehouse_id);
        });
    });
    
    // Add new product row
    $('#add-product-row').on('click', function() {
        rowIndex++;
        var newRow = `
            <div class="product-row" data-row="${rowIndex}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="product_id_${rowIndex}">{{__('Product')}}</label>
                            <select class="form-control product-select" name="products[${rowIndex}][product_id]" id="product_id_${rowIndex}" required>
                                <option value="">Select Product</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="quantity_${rowIndex}">{{__('Quantity')}}</label>
                            <input type="number" class="form-control quantity-input" name="products[${rowIndex}][quantity]" id="quantity_${rowIndex}" min="1" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{__('Available')}}</label>
                            <div class="form-control-plaintext available-qty" id="available_${rowIndex}">-</div>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm remove-product-row d-block">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#products-container').append(newRow);
        
        // Update product dropdown for new row
        var warehouse_id = $('#from_warehouse').val();
        if(warehouse_id) {
            updateProductDropdown($(`#product_id_${rowIndex}`), warehouse_id);
        }
        
        // Show remove buttons if more than one row
        toggleRemoveButtons();
    });
    
    // Remove product row
    $(document).on('click', '.remove-product-row', function() {
        $(this).closest('.product-row').remove();
        toggleRemoveButtons();
    });
    
    // Handle product selection change
    $(document).on('change', '.product-select', function() {
        var product_id = $(this).val();
        var warehouse_id = $('#from_warehouse').val();
        console.log("from_warehouse===",warehouse_id);
        var rowIndex = $(this).closest('.product-row').data('row');
        if(product_id) {
            getQuantity(product_id, rowIndex ,warehouse_id);
        }
    });
    
    // Function to update product dropdown
    function updateProductDropdown(selectElement, warehouse_id) {
        $.ajax({
            url: '{{ route("warehouses-transfer.getproduct") }}',
            type: 'POST',
            data: {
                warehouse_id: warehouse_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                selectElement.empty();
                selectElement.append('<option value="">Select Product</option>');
                $.each(response.ware_products, function(key, value) {
                    selectElement.append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }
    
    // Function to get quantity for specific row
    function getQuantity(product_id, rowIndex ,warehouse_id) {
        $.ajax({
            url: '{{ route("warehouses-transfer.getquantity") }}',
            type: 'POST',
            data: {
                warehouse_id: warehouse_id,
                product_id: product_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Update available quantity display
                $(`#available_${rowIndex}`).text(response[0] || 0);
                
                // Set max attribute on quantity input
                $(`#quantity_${rowIndex}`).attr('max', response[0] || 0);
                
               
            }
        });
    }
    
    // Function to toggle remove buttons visibility
    function toggleRemoveButtons() {
        var productRows = $('.product-row');
        if(productRows.length > 1) {
            $('.remove-product-row').show();
        } else {
            $('.remove-product-row').hide();
        }
    }
    
    // Initialize with warehouse products if warehouse is pre-selected
    var initialWarehouse = $('#from_warehouse').val();
    if(initialWarehouse) {
        updateProductDropdown($('#product_id_0'), initialWarehouse);
    }
});
</script>

<style>
.product-row {
    border: 1px solid #e9ecef;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
}

.product-row:last-child {
    margin-bottom: 0;
}

.available-qty {
    font-weight: bold;
    color: #28a745;
}

#add-product-row {
    border-radius: 20px;
}

.remove-product-row {
    margin-top: 32px;
}
</style>

{{ Form::close() }}
    </div>
</div>    
@endsection
