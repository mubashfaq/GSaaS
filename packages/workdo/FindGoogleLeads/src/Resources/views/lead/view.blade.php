@extends('layouts.main')

@section('page-title')
    {{ __('Manage Google Leads') }}
@endsection

@section('page-breadcrumb')
    {{ __('Google Leads') }}
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
@endpush

@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script>
        $('body').on('click', '.convert-to-lead', function() {
            var clickedButton = $(this);
            $('#commonModal').on('show.bs.modal', function() {
                $('.website-append').remove();

                var id = clickedButton.data('id');
                var tr = clickedButton.closest('tr');
                var name = tr.find('td').eq(1).text(); // Assuming 'name' is in the 2nd column
                var phone = tr.find('td').eq(2).text(); // Assuming 'phone' is in the 4th column
                var website = tr.find('td').eq(3).text(); // Assuming 'website' is in the 5th column

                if (website !== '-') {
                    $('#website').val($.trim(website));
                }
                if (name !== '-') {
                    $('#name').val($.trim(name));
                }
                if (phone !== '-') {
                    $('#phone').val($.trim(phone));
                }

                // Create a new div for the "Website" input field
                var websiteField = $(
                    '<div class="col-12 form-group website-append"><label for="website" class="col-form-label">Website</label><input class="form-control" name="website" type="text" id="website" value="' +
                    $.trim(website) + '"> </div>');

                // Insert the new div after the existing one containing the "Phone No" field and the text
                websiteField.insertAfter('.col-6.form-group:has(input[name="follow_up_date"])');

                $('#commonModal form').append(
                    '<input type="hidden" class="form-control" name="google_contact_lead_id" value="' +
                    id + '">');
            });
        })
    </script>
@endpush
@section('page-action')
    <a href="{{ route('find-google-leads.index') }}" class="btn-submit btn btn-sm btn-primary " data-toggle="tooltip"
        title="{{ __('Back') }}">
        <i class=" ti ti-arrow-back-up"></i> </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
