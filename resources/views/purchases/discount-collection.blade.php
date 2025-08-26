@extends('layouts.main')

@section('page-title')
    {{ __('Discount Collections') }}
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
                <h5>{{ __('Discount Collections') }}</h5>
               <div class="float-end">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCollectionModal">
                        <i class="ti ti-plus"></i> {{ __('Create Collection') }}
                    </button>
                </div>
                
                <!-- Create Collection Modal -->
            <div class="modal fade" id="createCollectionModal" tabindex="-1" aria-labelledby="createCollectionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('discount.collections.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCollectionModalLabel">{{ __('Create Collection') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Add your form fields here -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">{{ __('Title') }} <span class="text-danger">*</span>:</label>
                                    <input type="text" name="title" class="form-control" id="title" required>
                                </div>
                                
                                    <div class="mb-3">
                                        <label for="brand-status" class="form-label">Active Status</label>
                                        <select name="active" class="form-select" id="colleciton-status">
                                            <!--<option value="0" @if (old('active') == 0) selected @endif>Draft</option>-->
                                            <option value="1" @if (old('active') == 1) selected @endif>Public</option>
                                            <option value="2" @if (old('active') == 2) selected @endif>Private</option>
                                            <!--<option value="3" @if (old('active') == 3) selected @endif>Trash</option>-->
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="brand-status" class="form-label">Select Discount <span class="text-danger">*</span>:</label>
                                        <select name="discount_id" class="form-select" id="brand-status">
                                            <option value="" selected disabled>Select Discount On Collection</option>
                                            @foreach ($latest_discounts as $discount)
                                                    <option value="{{ $discount->id }}"
                                                        @if (old('discount_id') == $discount->id) selected @endif>{{ $discount->title }}
                                                    </option>
                                            @endforeach
                                            <option value="0">General Collection</option>
                                        </select>
                                    </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                </div>
                                <!-- Add more fields as needed -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
                            <th>{{ __('Discount') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($collections as $collection)
                            <tr>
                                <td>{{ $collection->title }}</td>
                                <td>{{ isset($collection->discount) ? $collection->discount->title : '' }}</td>
                                  <td class="active-status">
                                        @php
                                            $activeStatus = CollectionClass::check_active($collection->active);
                                            $badgeClass =
                                                $activeStatus == 'Public'
                                                    ? 'bg-primary-subtle text-primary'
                                                    : ($activeStatus == 'Draft'
                                                        ? 'bg-warning-subtle text-warning'
                                                        : ($activeStatus == 'Private'
                                                            ? 'bg-info-subtle text-info'
                                                            : 'bg-secondary-subtle text-secondary'));
                                        @endphp
                                        <span id="collection-status-{{ $collection->id }}"
                                            class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ $activeStatus }}</span>
                                    </td>
                                   
                               
                                <td>
                                                  <div class="action-btn me-2">
                                                        <a href="{{ route('discount.collections.products', $collection->id) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-warning"
                                                            data-bs-toggle="tooltip" title="{{ __('View') }}"
                                                            data-original-title="{{ __('Detail') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn me-2">
                                                         <a href="{{ route('discount.collections.destroy', $collection->id) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-danger"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                       
                                                    </div>
                                                    <div class="action-btn me-2">
                                                    <button type="button" class="mx-3 btn btn-sm align-items-center bg-info"
                                                        data-bs-toggle="modal" data-bs-target="#editCollectionModal-{{ $collection->id }}"
                                                        title="{{ __('Edit') }}">
                                                        <i class="ti ti-edit text-white"></i>
                                                    </button>
                                                </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No Products Found</td>
                            </tr>
                        @endforelse
                      
                      
                            @foreach($collections as $collection)
                            <!-- Edit Modal -->
                                        
                            <div class="modal fade" id="editCollectionModal-{{ $collection->id }}" tabindex="-1" aria-labelledby="editCollectionModalLabel-{{ $collection->id }}" aria-hidden="true">
                                @php
                                            $currentDiscount = Workdo\ProductService\Entities\Discount::find($collection->discount_id);
                                            $isExpired = false;
                        
                                            if (
                                                $currentDiscount &&
                                                $currentDiscount->end_date &&
                                                \Carbon\Carbon::parse($currentDiscount->end_date)->lt(\Carbon\Carbon::now())
                                            ) {
                                                $isExpired = true;
                                            }
                        
                                            if ($currentDiscount && $currentDiscount->active != 1) {
                                                $isExpired = true;
                                            }
                                        @endphp

                                   
                                <div class="modal-dialog">
                                    
                                    <div class="modal-content">
                                        
                                    
                                        <form action="{{ route('discount.collection.update', $collection->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCollectionModalLabel-{{ $collection->id }}">{{ __('Edit Collection') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                                            </div>
                                             @if ($isExpired)
                                            <div class="alert alert-warning mb-4">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                                <strong>Warning:</strong> The current discount for this collection has expired or is inactive.
                                                Please create a new collection or select another discount.
                                            </div>
                                            @endif
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title-{{ $collection->id }}" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control" id="title-{{ $collection->id }}" value="{{ $collection->title }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="discount_id-{{ $collection->id }}" class="form-label">Select Discount <span class="text-danger">*</span></label>
                                                    <select name="discount_id" class="form-select" id="discount_id-{{ $collection->id }}" required>
                                                        <option value="" disabled>Select Discount On Collection</option>
                                                        @foreach ($latest_discounts as $discount)
                                                            <option value="{{ $discount->id }}" {{ $collection->discount_id == $discount->id ? 'selected' : '' }}>
                                                                {{ $discount->title }}
                                                            </option>
                                                        @endforeach
                                                        <option value="0" @if ($collection->discount_id == 0) selected @endif>
                                                         General Collection</option>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="active-{{ $collection->id }}" class="form-label">Active Status</label>
                                                    <select name="active" class="form-select" id="active-{{ $collection->id }}">
                                                        <!--<option value="0" {{ $collection->active == 0 ? 'selected' : '' }}>Draft</option>-->
                                                        <option value="1" {{ $collection->active == 1 ? 'selected' : '' }}>Public</option>
                                                        <option value="2" {{ $collection->active == 2 ? 'selected' : '' }}>Private</option>
                                                        <!--<option value="3" {{ $collection->active == 3 ? 'selected' : '' }}>Trash</option>-->
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="description-{{ $collection->id }}" class="form-label">{{ __('Description') }}</label>
                                                    <textarea name="description" class="form-control" id="description-{{ $collection->id }}" rows="3">{{ $collection->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-primary updateBtn" data-id="{{ $collection->id }}">
                                                    <span class="btn-text">Update</span>
                                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                </button>
                                                <!--<button type="submit" class="btn btn-primary">{{ __('Update') }}</button>-->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
@endforeach

                      
                      
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createCollectionModal');
    const modal = new bootstrap.Modal(document.getElementById('createCollectionModal'));
    const loader = document.getElementById('formLoader');

    form.addEventListener('submit', function () {
        modal.hide(); // Hide the modal
        loader.style.display = 'block'; // Show loader
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Select all forms inside modals
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const submitBtn = form.querySelector('.updateBtn');

            if (submitBtn) {
                const btnText = submitBtn.querySelector('.btn-text');
                const spinner = submitBtn.querySelector('.spinner-border');

                if (btnText) btnText.classList.add('d-none');
                if (spinner) spinner.classList.remove('d-none');

                submitBtn.disabled = true;
            }
        });
    });
});


</script>

@endsection
