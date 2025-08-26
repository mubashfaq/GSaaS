@extends('layouts.main')

@section('page-title')
     {{ __('Purchase Returns') }}
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
                pageLength: 10,
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
       
            <a href="{{ route('purchase.returns.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
       
    </div>
    <div class="d-flex">
       <x-back-button  route="{{ url('/purchases') }}" />
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <!--<div class="row">-->
                    <!--    <div class="col-md-12">-->
                    <!--        <div class="form-group d-flex justify-content-end">-->
                    <!--            {{ Form::open(['route' => ['purchase.returns.index'], 'method' => 'GET', 'id' => 'purchase-return-filter']) }}-->
                    <!--            <div class="row d-flex justify-content-end">-->
                    <!--                <div class="col-auto">-->
                    <!--                    {{ Form::select('vender_id', $vender, !empty($_GET['vender_id']) ? $_GET['vender_id'] : '', ['class' => 'form-control select', 'placeholder' => __('Select Vendor')]) }}-->
                    <!--                </div>-->
                    <!--                <div class="col-auto">-->
                    <!--                    {{ Form::select('status', $status, !empty($_GET['status']) ? $_GET['status'] : '', ['class' => 'form-control select', 'placeholder' => __('Select Status')]) }}-->
                    <!--                </div>-->
                    <!--                <div class="col-auto">-->
                    <!--                    <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Apply') }}">-->
                    <!--                        <i class="ti ti-search"></i>-->
                    <!--                    </button>-->
                    <!--                    <a href="{{ route('purchase.returns.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{ __('Reset') }}">-->
                    <!--                        <i class="ti ti-trash"></i>-->
                    <!--                    </a>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--            {{ Form::close() }}-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="table-responsive " id="product-service-table_wrapper">
                        <table class="table datatable" id="expiry-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Return Number') }}</th>
                                    <th>{{ __('Purchase Number') }}</th>
                                    <th>{{ __('Vendor') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('Return Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($returns as $return)
                                    <tr>
                                        <td>{{ $return->getReturnNumberAttribute() }}</td>
                                        <td>
                                            @if (!empty($return->purchase))
                                                {{ \App\Models\Purchase::purchaseNumberFormat($return->purchase->purchase_id) }}
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($return->vender_name))
                                                {{ $return->vender_name }}
                                            @elseif(!empty($return->vender))
                                                {{ $return->vender->name }}
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($return->warehouse))
                                                {{ $return->warehouse->name }}
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td>{{ $return->return_date }}</td>
                                        <td>{{ $return->getFormattedTotalAttribute() }}</td>
                                        <td>{!! $return->getStatusBadgeAttribute() !!}</td>
                                        <td class="action">
                                           <div class="action-btn me-2">
                                                        <a href="{{ route('purchase.returns.show', \Crypt::encrypt($return->id)) }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-warning"
                                                            data-bs-toggle="tooltip" title="{{ __('View') }}"
                                                            data-original-title="{{ __('Detail') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                            <!--@if ($return->status == 0 && Auth::user()->isAbleTo('purchase edit'))-->
                                            <!--    <div class="action-btn bg-success ms-2">-->
                                            <!--        <form method="POST" action="{{ route('purchase.returns.status', $return->id) }}">-->
                                            <!--            @csrf-->
                                            <!--            <input type="hidden" name="status" value="1">-->
                                            <!--            <button type="submit" class="mx-1 btn btn-sm align-items-center show_confirm bg-success text-white" data-bs-toggle="tooltip" title="{{ __('Approve') }}">-->
                                            <!--                <i class="ti ti-check"></i>-->
                                            <!--            </button>-->
                                            <!--        </form>-->
                                            <!--    </div>-->
                                            <!--    <div class="action-btn bg-danger ms-2">-->
                                            <!--        <form method="POST" action="{{ route('purchase.returns.status', $return->id) }}">-->
                                            <!--            @csrf-->
                                            <!--            <input type="hidden" name="status" value="2">-->
                                            <!--            <button type="submit" class="mx-1 btn btn-sm align-items-center show_confirm bg-danger text-white" data-bs-toggle="tooltip" title="{{ __('Reject') }}">-->
                                            <!--                <i class="ti ti-x"></i>-->
                                            <!--            </button>-->
                                            <!--        </form>-->
                                            <!--    </div>-->
                                            <!--@endif-->
                                             @if ($return->status == 0 && Auth::user()->isAbleTo('purchase edit'))
                                           <div class="action-btn bg-success ms-2">
                                                <a href="#" data-url="{{ route('purchases.payment.return', $return->id) }}"
                                                data-ajax-popup="true" data-title="{{ __('Return Payment') }}"
                                                class="btn btn-sm btn-info" data-original-title="{{ __('Return Payment') }}"><i
                                                    class="ti ti-report-money mr-2"></i></a> <br>
                                                </div>
                                                 @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
