@extends('layouts.main')

@section('page-title')
    {{ __('Contact Us Messages') }}
@endsection

@section('page-breadcrumb')
    {{ __('Contact Us Messages') }}
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
                <h5>{{ __('Contact Us Messages') }}</h5>
                <div class="float-end">
                    <!--<a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}" class="btn btn-sm btn-primary">-->
                    <!--    <i class="ti ti-file-export"></i> {{ __('Export CSV') }}-->
                    <!--</a>-->
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="product-service-table_wrapper" class="table-responsive">
                <table class="table " id="expiry-table">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Message') }}</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contactUsMessages as $messages)
                            <tr>
                                <td>{{ $messages->name }}</td>
                                <td>{{ $messages->email }}</td>
                                <td>{{ $messages->phone }}</td>
                                <td>{{ $messages->message }}</td>
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
@endsection
