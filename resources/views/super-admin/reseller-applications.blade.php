@extends('layouts.main')

@section('page-title')
    {{ __('Reseller Applications') }}
@endsection

@section('page-breadcrumb')
    {{ __('Reseller Applications') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
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

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-approved {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background-color: #fecaca;
        color: #991b1b;
    }

    .btn-view {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    </style>
@endpush

@push('scripts')
    @include('layouts.includes.datatable-js')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
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
                order: [[5, 'desc']], // Order by created_at column
                initComplete: function() {
                    $('#expiry-table_filter input').attr('placeholder', 'Search...');
                }
            });

            // Optional: initialize select2 if present
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2();
            }

            // View details modal
            $('.view-details').click(function() {
                var applicationId = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var company = $(this).data('company');
                var website = $(this).data('website');
                var size = $(this).data('size');
                var industry = $(this).data('industry');
                var experience = $(this).data('experience');
                var whyReseller = $(this).data('why-reseller');
                var targetMarket = $(this).data('target-market');
                var monthlySales = $(this).data('monthly-sales');
                var hasSalesTeam = $(this).data('sales-team');
                var teamSize = $(this).data('team-size');
                var additionalInfo = $(this).data('additional-info');
                var status = $(this).data('status');
                var createdAt = $(this).data('created-at');

                // Populate modal
                $('#modal-name').text(name);
                $('#modal-email').text(email);
                $('#modal-phone').text(phone);
                $('#modal-company').text(company);
                $('#modal-website').html('<a href="' + website + '" target="_blank">' + website + '</a>');
                $('#modal-size').text(size);
                $('#modal-industry').text(industry);
                $('#modal-experience').text(experience);
                $('#modal-why-reseller').text(whyReseller);
                $('#modal-target-market').text(targetMarket);
                $('#modal-monthly-sales').text('$' + monthlySales);
                $('#modal-sales-team').text(hasSalesTeam == 1 ? 'Yes' : 'No');
                $('#modal-team-size').text(teamSize || 'Not specified');
                $('#modal-additional-info').text(additionalInfo || 'None');
                $('#modal-status').text(status.charAt(0).toUpperCase() + status.slice(1));
                $('#modal-created-at').text(createdAt);

                // Show modal
                $('#detailsModal').modal('show');
            });

            // Copy link functionality (optional)
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
    
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5>{{ __('Reseller Applications') }}</h5>
                <div class="float-end">
                    <span class="badge bg-primary">{{ count($resellerApplications) }} {{ __('Applications') }}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="product-service-table_wrapper" class="table-responsive">
                <table class="table" id="expiry-table">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Company') }}</th>
                            <th>{{ __('Experience') }}</th>
                           
                            <th>{{ __('Applied Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resellerApplications as $application)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                      
                                            <!--<div class="avatar-title bg-primary rounded-circle text-white">-->
                                            <!--    {{ strtoupper(substr($application->name, 0, 2)) }}-->
                                            <!--</div>-->
                                      
                                        <div>
                                            <h6 class="mb-0">{{ $application->name }}</h6>
                                            <small class="text-muted">{{ $application->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->email }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $application->company_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $application->company_size }} employees</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $application->experience_level }}</span>
                                </td>
                                
                                <td>{{ \Carbon\Carbon::parse($application->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary view-details btn-view" 
                                            data-id="{{ $application->id }}"
                                            data-name="{{ $application->name }}"
                                            data-email="{{ $application->email }}"
                                            data-phone="{{ $application->phone }}"
                                            data-company="{{ $application->company_name }}"
                                            data-website="{{ $application->company_website }}"
                                            data-size="{{ $application->company_size }}"
                                            data-industry="{{ $application->industry }}"
                                            data-experience="{{ $application->experience_level }}"
                                            data-why-reseller="{{ $application->why_reseller }}"
                                            data-target-market="{{ $application->target_market }}"
                                            data-monthly-sales="{{ $application->expected_monthly_sales }}"
                                            data-sales-team="{{ $application->has_sales_team }}"
                                            data-team-size="{{ $application->team_size }}"
                                            data-additional-info="{{ $application->additional_info }}"
                                            data-status="{{ $application->status }}"
                                            data-created-at="{{ \Carbon\Carbon::parse($application->created_at)->format('M d, Y H:i') }}">
                                        <i class="ti ti-eye"></i> {{ __('View') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('No Applications Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">{{ __('Reseller Application Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Personal Information') }}</h6>
                        <div class="mb-2">
                            <strong>{{ __('Name') }}:</strong> <span id="modal-name"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Email') }}:</strong> <span id="modal-email"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Phone') }}:</strong> <span id="modal-phone"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Experience Level') }}:</strong> <span id="modal-experience"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Company Information') }}</h6>
                        <div class="mb-2">
                            <strong>{{ __('Company Name') }}:</strong> <span id="modal-company"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Website') }}:</strong> <span id="modal-website"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Company Size') }}:</strong> <span id="modal-size"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Industry') }}:</strong> <span id="modal-industry"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Business Details') }}</h6>
                        <div class="mb-2">
                            <strong>{{ __('Why Reseller') }}:</strong> <span id="modal-why-reseller"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Target Market') }}:</strong> <span id="modal-target-market"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Expected Monthly Sales') }}:</strong> <span id="modal-monthly-sales"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">{{ __('Sales Team') }}</h6>
                        <div class="mb-2">
                            <strong>{{ __('Has Sales Team') }}:</strong> <span id="modal-sales-team"></span>
                        </div>
                        <div class="mb-2">
                            <strong>{{ __('Team Size') }}:</strong> <span id="modal-team-size"></span>
                        </div>
                        <!--<div class="mb-2">-->
                        <!--    <strong>{{ __('Status') }}:</strong> <span id="modal-status"></span>-->
                        <!--</div>-->
                        <div class="mb-2">
                            <strong>{{ __('Applied Date') }}:</strong> <span id="modal-created-at"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-2">
                    <strong>{{ __('Additional Information') }}:</strong>
                    <p id="modal-additional-info" class="mt-1"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
               
            </div>
        </div>
    </div>
</div>
@endsection