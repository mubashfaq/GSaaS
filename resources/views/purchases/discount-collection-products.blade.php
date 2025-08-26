@extends('layouts.main')

@section('page-title')
    {{ __('Discount Collection Products ') }}
@endsection

@section('page-breadcrumb')
    {{ __('Purchase') }}
@endsection
@php
    use Illuminate\Support\Facades\Auth;
    use App\General\CollectionClass;
    $logged_in_user = Auth::user();
@endphp

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
     @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div id="formLoader" style="display:none;" class="text-center my-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('Collections Products') }}</h5>
               <div class="float-end">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editproductModel">
                        <i class="ti ti-plus"></i> {{ __('ADD Collection Products') }}
                    </button>
                </div>
                
                <!-- Create Collection Modal -->
            <div class="modal fade" id="editproductModel" tabindex="-1" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="productModalLabel">
                            <i class="fas fa-box me-2"></i>All Products
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="unchecked"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="collection_product_form" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" id="searchProducts"
                                        class="form-control border-start-0" placeholder="Search Products">
                                </div>
                            </div>

                            <div id="saveform_errList" class="alert alert-danger" style="display: none;"></div>
                            <div id="success_message" class="alert alert-success" style="display: none;"></div>

                            <div class="products-list card p-2" style="max-height: 400px; overflow-y: auto;">
                                @if ($products->isEmpty())
                                    <p class="text-center py-4 text-muted">No records found.</p>
                                @else
                                    <input type="hidden" name="collection_discount_id" id="collection_discount_id"
                                        value="{{ $collection->discount_id }}">
                                    <input type="hidden" name="collection_id" id="collection_id"
                                        value="{{ $collection->id }}">

                                    @foreach ($products as $product)
                                        <input type="hidden" name="discount_id" id="discount_id"
                                            value="{{ $product->discount_id }}">
                                        <div class="product-item border-bottom p-2">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check">
                                                    <input type="checkbox" name="product_ids[]" class="form-check-input"
                                                          value="{{ $product->id }}" id="product-{{ $product->id }}">
                                                    <!--<input type="checkbox" name="product_id" class="form-check-input"-->
                                                    <!--    value="{{ $product->id }}"-->
                                                    <!--    id="product-{{ $product->id }}">-->
                                                </div>
                                                <div class="product-image ms-3 me-3 rounded product-clickable"
                                                    style="background-image: url('{{ url('/') . '/' . $product->image }}'); 
                                                        width: 50px; height: 50px; background-size: cover; background-position: center;">
                                                </div>
                                                <div>
                                                    <label class="title-truncate product-clickable mb-0"
                                                        for="product-{{ $product->id }}">{{ $product->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="no-records-message text-center text-muted py-4" style="display: none;">
                                <i class="fas fa-search fa-2x mb-3"></i>
                                <p>Record not found.</p>
                            </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <div class="d-flex justify-content-between w-100">
                            <div>
                                <span class="text-muted small">Click on product row to select/deselect</span>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    id="unchecked_product">
                                    <i class="fas fa-times me-1"></i>Close
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i>Add
                                </button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

            </div>
        </div>
        <div class="card-body">
            <div id="product-service-table_wrapper" class="table-responsive">
                <table class="table " id="expiry-table">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collectionproducts as $collection)
                            <tr>
                                <td>{{ $collection->name }}</td>
                                <td>
                                    <div class="action-btn me-2">
                                        <a href="{{ route('discount.collection.destroy.product', $collection->id) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-danger"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}">
                                                            <i class="ti ti-trash text-white"></i>
                                        </a>
                                                       
                                    </div>
                                                    
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No Products Found</td>
                            </tr>
                        @endforelse
                      
                      
                           

                      
                      
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    

<script>
    $('.addTitle').on('input', function() {
        var title = $(this).val();
        var sku = title.replace(/\s+/g, '-').toLowerCase();
        $('.permalink').val(sku);
        validate_permalink();
    });
    $('.permalink').on('input', function() {
        validate_permalink();
    });
    // $('#seo_tags').tagsinput({
    //     tagClass: 'badge badge-dark'
    // });
</script>

<script>
    $(document).ready(function() {
        // Global array to track selected product IDs across searches and page refreshes
        var selectedProductIds = [];

        // Initialize: Check if any checkboxes are already checked and add to tracking array
        $('input[name="product_ids[]"]:checked').each(function() {
            selectedProductIds.push($(this).val());
        });

        // Uncheck all products on the "unchecked" button click
        $("#unchecked_product, #unchecked").on("click", function() {
            $("input[type='checkbox']").prop("checked", false);
            selectedProductIds = []; // Clear selected products array
        });

        // Toggle checkbox when product row is clicked
        $(".product-clickable").on("click", function() {
            var checkbox = $(this).closest(".d-flex").find("input[type='checkbox']");
            checkbox.prop("checked", !checkbox.prop("checked"));

            // Update selectedProductIds array
            var productId = checkbox.val();
            if (checkbox.prop("checked")) {
                if (!selectedProductIds.includes(productId)) {
                    selectedProductIds.push(productId);
                }
            } else {
                selectedProductIds = selectedProductIds.filter(id => id !== productId);
            }
        });

        // Store original products HTML
        var originalProductsHtml = $('.products-list').html();
        var collectionId = $('#collection_id').val();

        // Handle checkbox changes to update our tracking array
        $(document).on('change', 'input[name="product_ids[]"]', function() {
            var productId = $(this).val();
            if ($(this).prop('checked')) {
                if (!selectedProductIds.includes(productId)) {
                    selectedProductIds.push(productId);
                }
            } else {
                selectedProductIds = selectedProductIds.filter(id => id !== productId);
            }
        });

        // Search functionality for products
        $('#searchProducts').on('input', function() {
            var searchTerm = $(this).val().trim();
            var resultsContainer = $('.products-list');

            if (searchTerm === "") {
                // Show original products if search term is empty
                resultsContainer.html(originalProductsHtml);
                $('.no-records-message').hide();

                // Restore selected checkboxes
                selectedProductIds.forEach(function(id) {
                    $('#product-' + id).prop('checked', true);
                });
            } else {
                // Perform search via API if search term is not empty
                $.ajax({
                    url: '/discount/search-products',
                    method: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        resultsContainer.empty();

                        if (response.searchResults.length > 0) {
                            var collectionDiscountId = response.collection.discount_id;
                            collectionId = response.collection.id; // Update collectionId

                            // Add hidden inputs for collection details
                            resultsContainer.append($('<input>', {
                                'type': 'hidden',
                                'name': 'collection_discount_id',
                                'id': 'collection_discount_id',
                                'value': collectionDiscountId
                            }));

                            resultsContainer.append($('<input>', {
                                'type': 'hidden',
                                'name': 'collection_id',
                                'id': 'collection_id',
                                'value': collectionId
                            }));

                            // Add products to the list
                            $.each(response.searchResults, function(index, product) {
                                var productItem = $('<div>', {
                                    'class': 'product-item border-bottom p-2'
                                });
                                var productInfo = $('<div>', {
                                    'class': 'd-flex align-items-center'
                                });

                                // Check if this product was previously selected
                                var isChecked = selectedProductIds.includes(product
                                    .id.toString()) ? 'checked' : '';

                                var checkboxElement = $('<div>', {
                                    'class': 'form-check',
                                    'html': '<input type="checkbox" name="product_ids[]" value="' +
                                        product.id +
                                        '" class="form-check-input" id="product-' +
                                        product.id + '" ' + isChecked + '>'
                                });

                                var imageElement = $('<div>', {
                                    'class': 'product-image ms-3 me-3 rounded product-clickable',
                                    'style': 'background-image: url("' +
                                        '{{ url('/') }}' + '/' +
                                        product.image  +
                                        '"); width: 50px; height: 50px; background-size: cover; background-position: center;'
                                });

                                var titleElement = $('<div>', {
                                        'class': 'flex-grow-1'
                                    })
                                    .append($('<label>', {
                                        'class': 'title-truncate product-clickable mb-0 fw-medium',
                                        'for': 'product-' + product.id,
                                        'text': product.name
                                    }));

                                productInfo.append(checkboxElement, imageElement,
                                    titleElement);
                                productItem.append(productInfo);
                                resultsContainer.append(productItem);
                            });

                            $('.no-records-message').hide();
                        } else {
                            $('.no-records-message').show();
                        }
                    },
                    error: function(error) {
                        console.error('Error searching products:', error);
                    }
                });
            }
        });

        // Make product items clickable to toggle checkbox
        $(document).on('click', '.product-clickable', function() {
            var checkboxItem = $(this).closest('.product-item').find('input[type="checkbox"]');
            checkboxItem.prop("checked", !checkboxItem.prop("checked"));

            // Update selected products array
            var productId = checkboxItem.val();
            if (checkboxItem.prop('checked')) {
                if (!selectedProductIds.includes(productId)) {
                    selectedProductIds.push(productId);
                }
            } else {
                selectedProductIds = selectedProductIds.filter(id => id !== productId);
            }
        });

        // Reset checkboxes when modal is closed
        $('#unchecked, #unchecked_product').on('click', function() {
            $('.products-list input[type="checkbox"]').prop('checked', false);
            selectedProductIds = []; // Clear selected products array
        });

        // Submit handler for the collection form
        $('#collection_product_form').submit(function(e) {
            e.preventDefault();
             console.log('Selected Product IDs:', selectedProductIds);

            // Ensure at least one product is selected
            if (selectedProductIds.length === 0) {
                $('#saveform_errList').html("");
                $('#saveform_errList').addClass('alert alert-danger m-2');
                $('#saveform_errList').text('Please select at least one product').show();
                return; // Stop form submission
            }

            const discountId = $('#collection_discount_id').val();

            // Prepare the form data
            const formData = new FormData(this);

            // Clear any existing product IDs from the form
            formData.delete('checked_ids[]');

            // Add ALL selected product IDs to the form data
            for (const id of selectedProductIds) {
                formData.append('checked_ids[]', id);
            }

            formData.append('discount_id', discountId);

            // Submit the form data using AJAX
            $.ajax({
                url: '/store-collection-product',
                method: "POST",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    console.log(res);
                    $('#saveform_errList').html("").removeClass('alert alert-danger m-2')
                        .hide();
                    $('#success_message').html("").removeClass('alert alert-success m-2')
                        .hide();

                    if (res.discount_expired) {
                        $('#saveform_errList').addClass(
                            'alert alert-danger m-2 auto-dismiss');
                        $('#saveform_errList').text(
                            'Cannot add products - the discount on this collection has expired.'
                        ).show();
                        setTimeout(hideAllAlerts, 3000);
                        return;
                    }

                    if (res.products_with_discounts && res.products_with_discounts.length >
                        0) {
                        var discountProductListHTML = '<ul>';
                        res.products_with_discounts.forEach(function(product) {
                            discountProductListHTML += '<li>Product Name: ' + product
                                .name + ' - Already has a discount applied</li>';
                        });
                        discountProductListHTML += '</ul>';
                        $('#saveform_errList').append(
                            '<div class="alert alert-warning m-2 auto-dismiss"><strong>Products with Discount:</strong>' +
                            discountProductListHTML + '</div>'
                        ).show();
                    }
                    
                    
                    if (res.already_existing_products && res.already_existing_products.length > 0) {
                        var existingProductListHTML = '<ul>';
                        res.already_existing_products.forEach(function(product) {
                            existingProductListHTML += '<li>Product Name: ' + product
                                .name + ' - Already has a discount applied</li>';
                        });
                        existingProductListHTML += '</ul>';
                        $('#saveform_errList').append(
                            '<div class="alert alert-warning m-2 auto-dismiss"><strong>Products Already in Other Collections:</strong>' +
                            existingProductListHTML + '</div>'
                        ).show();
                    }

                    // if (res.already_existing_products && res.already_existing_products
                    //     .length > 0) {
                    //     var existingProductListHTML = '<ul>';
                    //     res.already_existing_products.forEach(function(product) {
                    //         existingProductListHTML += '<li>Product SKU: ' + product
                    //             .sku + ' - Already in other collection</li>';
                    //     });
                    //     existingProductListHTML += '</ul>';
                    //     $('#saveform_errList').append(
                    //         '<div class="alert alert-warning m-2 auto-dismiss"><strong>Products Already in Other Collections:</strong>' +
                    //         existingProductListHTML + '</div>'
                    //     ).show();
                    // }

                    if (res.message === 'products_added') {
                        $('input[type="checkbox"]:checked').prop('checked', false);
                        selectedProductIds = []; // Clear selected products array
                        $('#collection_discount_id').val('');
                        $('#success_message').addClass(
                            'alert alert-success m-2 auto-dismiss');
                        $('#success_message').text('All products added successfully')
                            .show();
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } else if (!res.products_with_discounts && !res
                        .already_existing_products) {
                        $('#saveform_errList').addClass(
                            'alert alert-danger m-2 auto-dismiss');
                        $('#saveform_errList').text('An unexpected error occurred.').show();
                    }

                    // Auto-dismiss all alerts after 3 seconds
                    setTimeout(hideAllAlerts, 3000);
                },
                error: function(err) {
                    $('#saveform_errList').addClass('alert alert-danger m-2 auto-dismiss');
                    $('#saveform_errList').text(
                        'An error occurred while processing your request. Please try again.'
                    ).show();

                    setTimeout(hideAllAlerts, 3000);
                }
            });

            // Function to hide all alert messages with class "auto-dismiss"
            function hideAllAlerts() {
                $('.auto-dismiss').fadeOut('slow', function() {
                    $(this).removeClass('alert alert-danger alert-warning alert-success m-2')
                        .hide();
                });
            }

        });
    });
</script>




<script>
    // Global variable to store the current product ID to delete
    let productIdToDelete = null;
    let productTitle = '';

    // Function to show delete confirmation modal
    function deleteProduct(id, title) {
        productIdToDelete = id;
        productTitle = title;

        // Set the product title in the modal
        $('#productTitleToDelete').text(title);

        // Show the modal
        $('#deleteProductModal').modal('show');
    }

    // Add event listener for the confirmation button
    $(document).ready(function() {
        $('#confirmDeleteProduct').on('click', function() {
            if (productIdToDelete) {
                $.ajax({
                    url: '/destroy-product/' + productIdToDelete,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Close the modal
                        $('#deleteProductModal').modal('hide');

                        // Show success message (you can replace with toast notification)

                        // Refresh the page after deletion
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        // Close the modal
                        $('#deleteProductModal').modal('hide');

                        // Show error message
                        showToast('error', 'Error occurred while deleting the product: ' +
                            (xhr.responseJSON ? xhr.responseJSON.message :
                                'Unknown error'));
                    }
                });
            }
        });
    });

    // Toast function if you don't already have one
    function showToast(type, message) {
        // If you have a toast system already, use that instead
        if (type === 'success') {
            alert(message); // Replace with your toast implementation
        } else {
            alert(message); // Replace with your toast implementation
        }
    }
</script>




@endsection
