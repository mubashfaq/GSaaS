@extends('layouts.main')
@section('page-title')
    {{ __('Manage Daily Register') }}
@endsection
@section('page-breadcrumb')
    {{ __('Register') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">-->
    <link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/custom.css') }}">
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
@endpush

@section('page-action')
    <div class="d-flex">
        <a href="{{ route('purchase.returns.index', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
           title="{{ __('Return Purchase') }}">
            <i class="ti ti-rotate-clockwise"></i>
        </a>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Close Register</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.close') }}">
                        @csrf

                        <div class="form-group">
                            <label for="closing_balance">Closing Balance</label>
                            <input type="number" step="0.01" class="form-control" id="closing_balance" name="closing_balance" required>
                        </div>

                        <div class="form-group">
                            <label for="closing_note">Note (Optional)</label>
                            <textarea class="form-control" id="closing_note" name="closing_note" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-danger">
                                Close Register
                            </button>
                            <a href="{{ route('register.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection