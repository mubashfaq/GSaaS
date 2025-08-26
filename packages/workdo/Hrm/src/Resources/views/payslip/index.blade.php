@extends('layouts.main')
@section('page-title')
    {{ __('Manage Payslip') }}
@endsection
@section('page-breadcrumb')
    {{ __('Payslip') }}
@endsection
@php
    $company_settings = getCompanyAllSetting();
@endphp

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <style>
    #payslip-table{
        margin-top:25px;
    border-bottom: 1px solid #f1f1f1;
    }
                #payslip-table .sorting{
                    padding:0px !important;
                    border-bottom: 1px solid #d9d9d9;
                }
                #payslip-table .payslip-thead{
                    display:inline-block;
                    background:#f8f9fd;
                    border-bottom-color: #f1f1f1;
                    padding: 0.9rem 0.75rem;
                    position:relative;
                    width:100%;
                    height:100%;
                    color:#060606;
                    font-size:12px;
                }
                #payslip-table .payslip-thead::before, #payslip-table .payslip-thead::after {
                content: "";
                height: 0;
                width: 0;
                position: absolute;
                right: 4px;
                border-left: 4px solid transparent;
                border-right: 4px solid transparent;
                opacity: 0.2;
                }
                #payslip-table .payslip-thead::before {
            border-top: 4px solid #000;
            bottom: 15px;
        }
#payslip-table .payslip-thead::after {
    border-bottom: 4px solid #000;
    border-top: 4px solid transparent;
    top: 15px;
}
#payslip-table_filter input{
    display: block;
    width: 100%;
    padding: 0.575rem 1rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #293240;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 6px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    margin:0px;
}
#payslip-table_length select{
        display: inline;
    width: 75px;
    padding: 0.575rem 1rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #293240;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 6px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2' fill='none' stroke-linecap='round' stroke-linejoin='round' class='css-i6dzq1'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 18px 25px;
}
table.dataTable.display tbody tr.odd, table.dataTable.display tbody tr.even, .dataTable.display tbody tr.odd > .sorting_1, table.dataTable.display tbody tr.even > .sorting_1{
    background-color:#ffffff !important;
}
.dataTable.display tbody tr.odd td, .dataTable.display tbody tr.even td{
    padding: 0.9rem 0.75rem;
    border-top: 1px solid #f1f1f1;
    border-bottom: 1px solid #f1f1f1;
}
.padded-cell{
    padding-left:25px !important;
}
.bottom{
    margin-top:20px;
    padding: 0px 25px;
}
.previous, .next{
    display:none !important;
}
.paginate_button.current{
    background:#d9d9d9 !important;
    border:none !important;
}
.paginate_button:hover{
    background:#00000054 !important;
    border:none !important;
    color: #333 !important;
}
.btn-group{
    gap:5px;
}

    </style>
    <div class="row">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['payslip.store'], 'method' => 'POST', 'id' => 'payslip_form']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12 ">
                            <div class="btn-box me-2">
                                {{ Form::label('month', __('Select Month'), ['class' => 'form-label']) }}
                                {{ Form::select('month', $month, date('m'), ['class' => 'form-control ', 'id' => 'month']) }}

                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12 ">
                            <div class="btn-box me-2">
                                {{ Form::label('year', __('Select Year'), ['class' => 'form-label']) }}
                                {{ Form::select('year', $year, date('Y'), ['class' => 'form-control ']) }}

                            </div>
                        </div>
                        <div class="col-auto float-end mt-4">
                            <div class="d-flex mt-2">
                                <a href="#" onclick="document.getElementById('payslip_form').submit(); return false;"
                                    data-title="{{ __('Generate Payslip') }}" data-bs-toggle="tooltip"
                                    title="{{ __('Generate Payslip') }}" data-original-title="{{ __('payslip') }}"
                                    class="btn btn-sm btn-primary me-2">
                                    <i class="ti ti-report-money"></i>
                                </a>

                                @stack('addButtonHook')
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>

        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="d-flex align-items-center justify-content-start">
                            <h5>{{ __('Find Employee Payslip') }}</h5>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12 ">
                                <div class="btn-box me-2">
                                    <select class="form-control month_date " name="year" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="--">--</option>
                                        @foreach ($month as $k => $mon)
                                            @php
                                                $selected = date('m') == $k ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $k }}" {{ $selected }}>{{ $mon }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-12 ">
                                <div class="btn-box">
                                    {{ Form::select('year', $years, date('Y'), ['class' => 'form-control year_date ']) }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="payslip-table" class="display" style="width:100%"></table>
                        <!--<table class="table" id="pc-dt-render-column-cells">-->
                        <!--    <thead>-->
                        <!--        <tr>-->
                        <!--            <th>{{ __('Employee Id') }}</th>-->
                        <!--            <th>{{ __('Name') }}</th>-->
                        <!--            <th>{{ __('Payroll Type') }}</th>-->
                        <!--            <th>{{ __('Salary') }}</th>-->
                        <!--            <th>{{ __('Net Salary') }}</th>-->
                        <!--            <th>{{ __('Status') }}</th>-->
                        <!--            <th>{{ __('Action') }}</th>-->
                        <!--        </tr>-->
                        <!--    </thead>-->
                            <!--<table id="payslip-table" class="display" style="width:100%"></table>-->
                        <!--    <tbody>-->
                        <!--    </tbody>-->
                        <!--</table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ basic-table ] end -->
@endsection

@push('scripts')
    <script>
       
   $(document).ready(function() {
    // Initial Callback to Load Data
    callback();

    // Function to Fetch and Render Data
    function callback() {
        var month = $(".month_date").val() || '{{ date('m', strtotime('last month')) }}';
        var year = $(".year_date").val() || '{{ date('Y') }}';
        var datePicker = year + '-' + month;

        $.ajax({
            url: '{{ route('payslip.search_json') }}',
            type: 'POST',
            data: {
                "datePicker": datePicker,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                table.clear().rows.add(data).draw();
            },
            error: function() {
                console.error("Failed to fetch data.");
            }
        });
    }
    
    
    let table = $('#payslip-table').DataTable({
    processing: true,
    columns: [
    { 
        title: "<span class='payslip-thead' style='padding-left:25px;'>EMPLOYEE ID</span>", 
        data: '1',
        render: function(data, type, row) {
        //   return `<a href="#" class="btn btn-outline-primary">${data}</a>`;
            return `<a href="{{ route('setsalary.show', '') }}/${row[0]}" class="btn btn-outline-primary">${data}</a>`;
        },
        className: 'padded-cell'
    },
    { title: "<span class='payslip-thead'>NAME</span>", data: '2' },
    { title: "<span class='payslip-thead'>PAYROLL TYPE</span>", data: '3' },
    { 
        title: "<span class='payslip-thead'>SALARY</span>",
        data: '4',
        render: function(data) {
            return parseFloat(data).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
        }
    },
    { 
        title: "<span class='payslip-thead'>NET SALARY</span>",
        data: '5',
        render: function(data) {
            return parseFloat(data).toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
        }
    },
    { 
        title: "<span class='payslip-thead'>STATUS</span>",
        data: '6',
        render: function(data, type, row) {
            let statusClass = data === 'UnPaid' ? 'bg-danger' : 'bg-success';
            return `<a href="{{ route('payslip.show', '') }}/${row[0]}" class="text-decoration-none badge ${statusClass} text-white" style="padding:8px 16px;">
            ${data}
        </a>`;
        }
    },
    {
        
        title: "<span class='payslip-thead'>ACTION</span>",
        data: null,
        render: function(value, type, row) {
    var month = $(".month_date").val() || '{{ date("m", strtotime("last month")) }}';
    var year = $(".year_date").val() || '{{ date("Y") }}';
    var datePicker = year + '-' + month;

    const statusBadge = value[6] === 'Paid' ? 
        `<div class="badge bg-success p-2 px-3"><a href="#" class="text-white">${value[6]}</a></div>` :
        `<div class="badge bg-danger p-2 px-3"><a href="#" class="text-white">${value[6]}</a></div>`;

    const payslipButton = value[7] !== 0 ?
        `<a href="#" data-url="{{ url('payslip/pdf/') }}/${value[0]}/${datePicker}" data-size="lg" data-toggle="tooltip" title="" data-ajax-popup="true" class=" btn-sm btn btn-warning me-1" data-title="Employee Payslip" data-bs-original-title="Payslip" aria-label="Payslip"><i class="ti ti-report-money"></i></a>` :
        '';
        

    const clickToPaidButton = (value[6] === 'UnPaid' && value[7] !== 0) ?
        `<a href="{{ url('payslip/paysalary/') }}/${value[0]}/${datePicker}" data-toggle="tooltip" title="{{ __('Click To Paid') }}" class="btn-sm btn btn-primary me-1">
            <i class="ti ti-currency-dollar"></i>
        </a>` :
        '';

    const editButton = (value[6] === 'UnPaid' && value[7] !== 0) ?
        `<a href="#" data-url="{{ url('payslip/editemployee/') }}/${value[7]}" data-ajax-popup="true" data-size="lg" class="btn-sm btn btn-info me-2" data-toggle="tooltip" title="{{ __('Edit Employee Salary') }}">
            <i class="ti ti-pencil"></i>
        </a>` :
        '';
    const deleteButton = value[7] !== 0 && '{{ \Auth::user()->type !== "employee" }}' ?
    `<a href="#" data-url="{{ route('payslip.delete', ':id') }}" class="payslip_delete btn btn-danger btn-sm" data-toggle="tooltip" title="{{ __('Delete') }}">
        <i class="ti ti-trash"></i>
    </a>`.replace(':id', value[7]) :
    '';
    // const deleteButton = value[7] !== 0 && '{{ \Auth::user()->type !== "employee" }}' ?
    //     `<a href="#" data-url="{{ route('payslip.delete', ':id') }}".replace(':id', ${value[7]})" class="payslip_delete btn btn-danger btn-sm" data-toggle="tooltip" title="{{ __('Delete') }}">
    //         <i class="ti ti-trash"></i>
    //     </a>` :
    //     '';

    const currencySymbolPosition = @json($company_settings['site_currency_symbol_position']);
    const currencySymbol = @json($company_settings['defult_currancy_symbol']);
    const salary = currencySymbolPosition === 'pre' ? currencySymbol + value[4] : value[4] + currencySymbol;
    const netSalary = currencySymbolPosition === 'pre' ? currencySymbol + value[5] : value[5] + currencySymbol;

    return payslipButton + clickToPaidButton + editButton + deleteButton;
}
    }
],

    order: [[0, 'asc']],
    responsive: true,
    dom: '<"top"lf>rt<"bottom"ip><"clear">',
     language: {
        search: "",
        lengthMenu: "_MENU_ entries per page"
    },
     initComplete: function() {
        $('#payslip-table_filter input').attr('placeholder', 'Search...');
    }
});

    // Function to Render Table
    // function renderTable(data, datePicker) {
    //     let tr = '';
        
    //     if (data.length > 0) {
    //         $.each(data, function(index, value) {
    //             const statusBadge = value[6] === 'Paid' ? 
    //                 `<div class="badge bg-success p-2 px-3"><a href="#" class="text-white">${value[6]}</a></div>` :
    //                 `<div class="badge bg-danger p-2 px-3"><a href="#" class="text-white">${value[6]}</a></div>`;

    //             const payslipButton = value[7] != 0 ?
    //                 `<a href="#" data-url="{{ url('payslip/pdf/') }}/${value[0]}/${datePicker}" data-size="lg" data-toggle="tooltip" title="{{ __('Payslip') }}" class="btn-sm btn btn-warning me-1" data-title="{{ __('Employee Payslip') }}"><i class="ti ti-report-money"></i></a>` :
    //                 '';

    //             const clickToPaidButton = (value[6] === 'UnPaid' && value[7] != 0) ?
    //                 `<a href="{{ url('payslip/paysalary/') }}/${value[0]}/${datePicker}" data-toggle="tooltip" title="{{ __('Click To Paid') }}" class="btn-sm btn btn-primary me-1"><i class="ti ti-currency-dollar"></i></a>` :
    //                 '';

    //             const editButton = (value[6] === 'UnPaid' && value[7] != 0) ?
    //                 `<a href="#" data-url="{{ url('payslip/editemployee/') }}/${value[7]}" data-ajax-popup="true" data-size="lg" class="btn-sm btn btn-info me-2" data-title="{{ __('Edit Employee Salary') }}"><i class="ti ti-pencil"></i></a>` :
    //                 '';

    //             const deleteButton = value[7] != 0 && '{{ \Auth::user()->type != "employee" }}' ?
    //                 `<a href="#" data-url="{{ route('payslip.delete', ':id') }}".replace(':id', ${value[7]})" class="payslip_delete btn btn-danger btn-sm" data-toggle="tooltip" title="{{ __('Delete') }}"><i class="ti ti-trash"></i></a>` :
    //                 '';

    //             const currencySymbolPosition = @json($company_settings['site_currency_symbol_position']);
    //             const currencySymbol = @json($company_settings['defult_currancy_symbol']);
    //             const salary = currencySymbolPosition === 'pre' ? currencySymbol + value[4] : value[4] + currencySymbol;
    //             const netSalary = currencySymbolPosition === 'pre' ? currencySymbol + value[5] : value[5] + currencySymbol;

    //             tr += `<tr>
    //                 <td>${value[2]}</td>
    //                 <td>${value[3]}</td>
    //                 <td>${salary}</td>
    //                 <td>${netSalary}</td>
    //                 <td>${statusBadge}</td>
    //                 <td>${payslipButton + clickToPaidButton + editButton + deleteButton}</td>
    //             </tr>`;
    //         });
    //         // Populate table body
    //             $('#pc-dt-render-column-cells tbody').html(tr);
    //             $('.dataTable-info').show();
    //             $('.dataTable-pagination').show();
    //         } else {
    //             // Handle no data scenario
    //             const colspan = $('#pc-dt-render-column-cells thead tr th').length;
    //             $('#pc-dt-render-column-cells tbody').html(
    //                 `<tr><td class="dataTables-empty" colspan="${colspan}">{{ __('No entries found') }}</td></tr>`
    //             );
    //             $('.dataTable-info').hide(); // Hide entries text
    //             $('.dataTable-pagination').hide(); // Hide pagination
    //         }

        

    //     // Reinitialise SimpleDatatables
    //     const table = document.querySelector("#pc-dt-render-column-cells");
    //     new simpleDatatables.DataTable(table);
    // }

    // Change Event for Date Inputs
    $(document).on("change", ".month_date,.year_date", function() {
        callback();
    });

    // Delete Payslip Event
    $(document).on("click", ".payslip_delete", function() {
        const confirmation = confirm("Are you sure you want to delete this payslip?");
        const url = $(this).data('url');

        if (confirmation) {
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                beforeSend: function() {
                    $(".loader-wrapper").removeClass('d-none');
                },
                success: function() {
                    // toastr.success('Payslip Deleted Successfully');
                     $(".loader-wrapper").addClass('d-none');
                    setTimeout(() => location.reload(), 800);
                   
                },
                error: function() {
                    // toastr.error('Failed to delete payslip.');
                    $(".loader-wrapper").addClass('d-none');
                }
            });
        }
    });
});


    </script>
@endpush
