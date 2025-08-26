@extends('layouts.main')
@section('page-title')
    {{ __('Manage Daily Register') }}
@endsection
@section('page-breadcrumb')
    {{ __('Register') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/custom.css') }}">
    
    <!-- Custom pagination styles -->
    <style>
        .pagination {
            justify-content: center;
            margin: 0;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.25rem;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Focus on opening balance when modal shows
            $('#openRegisterModal').on('shown.bs.modal', function () {
                $('#opening_balance').focus();
            });
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Set max date to today for both fields
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="to_date"]').max = today;
    document.querySelector('input[name="from_date"]').max = today;
    
    // Validate date range
    document.querySelector('form').addEventListener('submit', function(e) {
        const fromDate = document.querySelector('input[name="from_date"]').value;
        const toDate = document.querySelector('input[name="to_date"]').value;
        
        if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
            alert('"From Date" cannot be after "To Date"');
            e.preventDefault();
        }
    });
});
    </script>
@endpush

@section('page-action')
    <!--<div class="d-flex">-->
    <!--    <a href="{{ route('purchase.returns.index', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"-->
    <!--       title="{{ __('Return Purchase') }}">-->
    <!--        <i class="ti ti-rotate-clockwise"></i>-->
    <!--    </a>-->
    <!--</div>-->
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Register Management') }}</h5>
                </div>
                
                <div class="card-body">
                    <!--@if(session('success'))-->
                    <!--    <div class="alert alert-success alert-dismissible fade show">-->
                    <!--        {{ session('success') }}-->
                    <!--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
                    <!--    </div>-->
                    <!--@endif-->
                    <!--@if(session('error'))-->
                    <!--    <div class="alert alert-danger alert-dismissible fade show">-->
                    <!--        {{ session('error') }}-->
                    <!--        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
                    <!--    </div>-->
                    <!--@endif-->

                    <div class="row">
                        @if($currentRegister)
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="mb-0 flex-grow-1">
                                            <i class="bi bi-cash-stack me-2"></i>Register is currently OPEN
                                        </h5>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#closeRegisterModal">
                                            <i class="bi bi-x-circle"></i> Close Register
                                        </button>
                                        <!--<a href="#" class="btn btn-success btn-sm text-white">-->
                                        <!--    <i class="bi bi-cash me-1"></i> POS-->
                                        <!--</a>-->
                                    </div>
                                       <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                           
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Opening Balance:</strong> {{ number_format($currentRegister->opening_balance, 2) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Opened at:</strong> {{ \Carbon\Carbon::parse($currentRegister->opened_at)->format('Y-m-d H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12 text-center mb-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openRegisterModal">
                                    <i class="bi bi-cash-stack me-1"></i> Open Register
                                </button>
                            </div>
                        @endif
                         <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="ti ti-filter me-2"></i>Filter Closed Registers</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="GET" action="">
                                              <div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label">From Date</label>
            <input type="date" name="from_date" class="form-control" 
                   value="{{ request('from_date') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label">To Date</label>
            <input type="date" name="to_date" class="form-control" 
                   value="{{ request('to_date') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label">&nbsp;</label>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="ti ti-search me-1"></i> Filter
                </button>
                <a href="{{ route('register.index') }}" class="btn btn-secondary">
                    <i class="ti ti-rotate-clockwise me-1"></i> Reset
                </a>
            </div>
        </div>
    </div>
</div>
                                            </form>
                                        </div>
                                    </div>
                        @if($closedRegisters->count() > 0)
                            <div class="mt-4">
                                <div class="card">
                                    
                                   
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Register History</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Opening Balance</th>
                                                        <th>Closing Balance</th>
                                                        <th>Opened At</th>
                                                        <th>Closed At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($closedRegisters as $register)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ number_format($register->opening_balance, 2) }}</td>
                                                            <td>{{ number_format($register->closing_balance, 2) }}</td>
                                                             <td>{{convertToTargetTimezone($register->opened_at)}}</td>    
                                                             <td>{{convertToTargetTimezone($register->closed_at)}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <!-- Fixed Pagination -->
                                        @if($closedRegisters->hasPages())
                                            <div class="d-flex justify-content-center mt-4">
                                                <nav aria-label="Page navigation">
                                                    {{ $closedRegisters->links('pagination::bootstrap-4') }}
                                                </nav>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning mt-4">
                                <i class="bi bi-exclamation-triangle me-2"></i> No closed registers found.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Open Register Modal -->
<div class="modal fade" id="openRegisterModal" tabindex="-1" aria-labelledby="openRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="openRegisterModalLabel">
                    <i class="bi bi-cash-stack me-2"></i>Open Register
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('register.open') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="opening_balance" class="form-label">Opening Balance *</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ config('pos.currency_symbol', '$') }}</span>
                            <input type="number" step="0.01" class="form-control" id="opening_balance" 
                                   name="opening_balance" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="opening_note" class="form-label">Note (Optional)</label>
                        <textarea class="form-control" id="opening_note" name="opening_note" 
                                  rows="3" placeholder="Any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Open Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Close Register Modal -->
<div class="modal fade" id="closeRegisterModal" tabindex="-1" aria-labelledby="closeRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeRegisterModalLabel">
                    <i class="bi bi-cash-stack me-2"></i>Close Register
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('register.close') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="closing_balance" class="form-label">Close Balance *</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ config('pos.currency_symbol', '$') }}</span>
                            <input type="number" step="0.01" class="form-control" id="closing_balance" 
                                   name="closing_balance" required placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="closing_note" class="form-label">Note (Optional)</label>
                        <textarea class="form-control" id="closing_note" name="closing_note" 
                                  rows="3" placeholder="Any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Close Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection