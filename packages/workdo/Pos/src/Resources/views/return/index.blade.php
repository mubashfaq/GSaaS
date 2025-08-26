@extends('layouts.main')

@section('page-title')
     {{ __('POS Returns') }}
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

        <div class="float-end">
            
            
                <a href="{{ route('pos.return.select.sale') }}" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i> {{ __('Create Return') }}
                </a>
        </div>
    <div class="d-flex">
       <x-back-button  route="{{ url('/pos') }}" />
    </div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('POS Returns') }}</h5>
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
                           <th>{{ __('Return Number') }}</th>
                                    <th>{{ __('Original Sale') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Return Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($returns as $return)
                                    <tr>
                                        <td>{{$return->return_id }}</td>
                                        <td>{{ \Workdo\Pos\Entities\Pos::posNumberFormat($return->pos->pos_id) }}</td>
                                        <td>{{ !empty($return->customer) ? $return->customer->name : __('Walk-in Customer') }}</td>
                                        <td>{{ $return->return_date }}</td>
                                        <td>{{ $return->returnPayment->amount }}</td>
                                        <td class="Action">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{ route('pos.return.show', $return->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                    <i class="ti ti-eye text-white"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    
@endsection
