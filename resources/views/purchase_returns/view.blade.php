@extends('layouts.main')

@section('page-title')
     {{ __('Purchase Return Details') }}
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row invoice-title mt-2">
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12">
                            <h3>{{ __('Purchase Return') }}</h3>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                            <h4 class="invoice-number">{{ $return->getReturnNumberAttribute() }}</h4>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="bill-to">
                                <small>
                                    <span>{{ __('Billed From:') }}</span><br>
                                    @if(!empty($vendor))
                                        {{ !empty($vendor->name) ? $vendor->name : '' }}<br>
                                        {{ !empty($vendor->email) ? $vendor->email : '' }}<br>
                                        {{ !empty($vendor->phone_number) ? $vendor->phone_number : '' }}<br>
                                        {{ !empty($vendor->address) ? $vendor->address : '' }}<br>
                                        {{ !empty($vendor->city) ? $vendor->city : '' . ', ' }}
                                        {{ !empty($vendor->state) ? $vendor->state : '' . ', ' }}
                                        {{ !empty($vendor->zip_code) ? $vendor->zip_code : '' }}<br>
                                        {{ !empty($vendor->country) ? $vendor->country : '' }}<br>
                                    @elseif(!empty($return->vender_name))
                                        {{ $return->vender_name }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end bill-details">
                                <small>
                                    <span>{{ __('Original Purchase Number:') }}</span>
                                    {{ \App\Models\Purchase::purchaseNumberFormat($purchase->purchase_id) }}<br>
                                    <span>{{ __('Return Date:') }}</span>
                                    {{ $return->return_date}}<br>
                                    <span>{{ __('Status:') }}</span>
                                    {!! $return->getStatusBadgeAttribute() !!}<br>
                                    <span>{{ __('Return Reason:') }}</span>
                                    {{ $return->return_reason ?? 'N/A' }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Item') }}</th>
                                            <th>{{ __('Batch No.') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Rate') }}</th>
                                            <th>{{ __('Tax') }} (%)</th>
                                            <th>{{ __('Discount') }} (%)</th>
                                            <th class="text-end">{{ __('Subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalQuantity = 0;
                                            $totalTax = 0;
                                            $totalDiscount = 0;
                                            $totalPrice = 0;
                                        @endphp
                                        @foreach($items as $item)
                                            @php
                                                $totalQuantity += $item->quantity;
                                                
                                                $priceBeforeTax = $item->price * $item->quantity;
                                                $taxAmount = ($priceBeforeTax * $item->tax_rate) / 100;
                                                $totalTax += $taxAmount;
                                                
                                                $priceWithTax = $priceBeforeTax + $taxAmount;
                                                $discountAmount = ($priceWithTax * $item->discount) / 100;
                                                $totalDiscount += $discountAmount;
                                                
                                                $subtotal = $priceWithTax - $discountAmount;
                                                $totalPrice += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ !empty($item->product) ? $item->product->name : 'N/A' }}</td>
                                                <td>{{ $item->batch_no }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }}</td>
                                               <td>{{ $item->tax_rate }}%</td>
                                                <td>{{ $item->discount }}%</td>
                                                <td class="text-end">{{ $subtotal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">{{ __('Total') }}</td>
                                            <td>{{ $totalQuantity }}</td>
                                            <td colspan="2">{{ __('Tax') }}: {{ $totalTax }}</td>
                                            <td>{{ __('Discount') }}: {{ $totalDiscount}}</td>
                                            <td class="text-end">{{ $totalPrice}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function saveAsPDF() {
            var element = document.querySelector('.card');
            var opt = {
                margin: 0.3,
                filename: '{{ $return->getReturnNumberAttribute() }}',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endpush