@extends('layouts.main')
@section('page-title')
    {{ __('Create Employee') }}
@endsection
@section('page-breadcrumb')
    {{ __('Employee') }}
@endsection
@php
    $company_settings = getCompanyAllSetting();
@endphp
@section('page-action')
    <div class="d-flex">
        @stack('addButtonHook')
        <x-back-button  route="{{ url('/employee') }}" />
       
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-4 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-details" data-bs-toggle="pill"
                                data-bs-target="#personal-details-tab" type="button">{{ __('Personal Details') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="company" data-bs-toggle="pill" data-bs-target="#company-tab"
                                type="button">{{ __('Company Details') }}</button>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {{ Form::open(['route' => ['employee.store'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation', 'novalidate']) }}

            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="personal-details-tab" role="tabpanel"
                            aria-labelledby="pills-user-tab-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>{{ __('Personal Details') }}</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<x-required></x-required>
                                            <div class="form-icon-user">
                                                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Employee Name')]) }}
                                            </div>
                                        </div>
                                        <x-mobile divClass="col-md-6" name="phone" label="{{ __('Phone') }}"
                                            placeholder="{{ __('Enter Employee Phone') }}" id="phone" required>
                                        </x-mobile>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('dob', __('Date of Birth'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            {{ Form::date('dob', date('Y-m-d', strtotime('-1 day')), ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => __('Select Date of Birth'), 'max' => date('Y-m-d')]) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('gender', __('Gender'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            <div class="d-flex radio-check">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="g_male" value="Male" checked="checked">
                                                    <label class="form-check-label"
                                                        for="g_male">{{ __('Male') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="g_female" value="Female">
                                                    <label class="form-check-label"
                                                        for="g_female">{{ __('Female') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('email', __('Email'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            {!! Form::email('email', old('email'), [
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'placeholder' => __('Enter Employee Email'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('password', __('Password'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            {!! Form::password('password', [
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'placeholder' => __('Enter Employee New Password'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('passport_country', __('Passport country'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('passport_country', null, ['class' => 'form-control', 'placeholder' => __('Enter Passport Country')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('passport', __('Passport'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('passport', null, ['class' => 'form-control', 'placeholder' => __('Enter Passport')]) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h5>{{ __('Location Details') }}</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{ Form::label('location_type', __('Location Type'), ['class' => 'form-label']) }}
                                            {{ Form::select('location_type', $location_type, null, ['class' => 'form-control select']) }}
                                        </div>

                                        <div class="form-group col-md-6">
                                            {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            {!! Form::textarea('address', old('address'), [
                                                'class' => 'form-control',
                                                'rows' => 1,
                                                'placeholder' => __('Enter Employee Address'),
                                                'required' => 'required',
                                                'id' => 'address',
                                            ]) !!}
                                        </div>
                                      
                                        <div class="form-group col-md-6">
                                            {{ Form::label('city', __('City'), ['class' => 'form-label' ]) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => __('Enter City') , 'id' => 'city']) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('zipcode', __('Zip code'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('zipcode', null, ['class' => 'form-control', 'placeholder' => __('Enter Zip code')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('state', __('State'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => __('Enter State') , 'id' => 'state']) }}
                                            </div>
                                        </div>
                                                
                                        <div class="form-group col-md-6">
                                            {{ Form::label('country', __('Country'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::text('country', null, ['class' => 'form-control', 'placeholder' => __('Enter Country'),'id' => 'country']) }}
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>{{ __('Document') }}</h5>
                                    <hr>
                                    <div class="card-body employee-detail-create-body p-0">
                                        @foreach ($documents as $key => $document)
                                            <div class="row">
                                                <div class="form-group col-12 d-flex">
                                                    <div class="float-left col-9">
                                                        {{ Form::label('document', $document->name, ['class' => 'float-left pt-1 form-label']) }}
                                                        @if ($document->is_required == 1)
                                                            <x-required></x-required>
                                                        @endif
                                                        <input type="hidden" name="emp_doc_id[{{ $document->id }}]"
                                                            value="{{ $document->id }}">
                                                        <div class="choose-file form-group">
                                                            <label for="document[{{ $document->id }}]"
                                                                class="form-label d-block">
                                                                <input type="file"
                                                                    class="form-control file @error('document') is-invalid @enderror doc_data"
                                                                    name="document[{{ $document->id }}]"
                                                                    id="document[{{ $document->id }}]"
                                                                    data-filename="{{ $document->id . '_filename' }}"
                                                                    @if ($document->is_required == 1) data-key="{{ $key }}" required @endif
                                                                    onchange="document.getElementById('{{ 'blah' . $key }}').src = window.URL.createObjectURL(this.files[0])">
                                                                <hr>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="float-right col-3">
                                                        <img id="{{ 'blah' . $key }}" style="margin-left: 15px;"
                                                        src="{{ asset('packages/workdo/Hrm/src/Resources/assets/image/default.png') }}"
                                                        alt="your image" width="120" height="100" class="rounded" />
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h5>{{ __('Bank Account Detail') }}</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('account_holder_name', __('Account Holder Name'), ['class' => 'form-label']) !!}
                                            {!! Form::text('account_holder_name', old('account_holder_name'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Account Holder Name'),
                                            ]) !!}

                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            {!! Form::label('bank_name', __('Bank Name'), ['class' => 'form-label']) !!}
                                            {!! Form::text('bank_name', old('bank_name'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Bank Name'),
                                            ]) !!}

                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('bank_identifier_code', __('Bank Identifier Code'), ['class' => 'form-label']) !!}
                                            {!! Form::text('bank_identifier_code', old('bank_identifier_code'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Bank Identifier Code'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('account_number', __('Account Number'), ['class' => 'form-label']) !!}
                                            {!! Form::number('account_number', old('account_number'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Account Number'),
                                            ]) !!}

                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('branch_location', __('Branch Location'), ['class' => 'form-label']) !!}
                                            {!! Form::text('branch_location', old('branch_location'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Branch Location'),
                                            ]) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('tax_payer_id', __('Tax Payer Id'), ['class' => 'form-label']) !!}
                                            {!! Form::text('tax_payer_id', old('tax_payer_id'), [
                                                'class' => 'form-control',
                                                'placeholder' => __('Enter Tax Payer Id'),
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-auto">
                                    <x-back-button />
                                </div>
                                <div class="col"></div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-primary d-inline-flex align-items-center"
                                        onClick="changetab('#company-tab')" type="button">{{ __('Next') }}<i
                                            class="ti ti-chevron-right ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="company-tab" role="tabpanel" aria-labelledby="pills-user-tab-2">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>{{ __('Company Details') }}</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group">
                                            {!! Form::label('employee_id', __('Employee ID'), ['class' => 'form-label']) !!}
                                            {!! Form::text('employee_id', $employeesId, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('branch_id', !empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch'), ['class' => 'form-label']) }}<x-required></x-required>
                                            {{ Form::select('branch_id', $branches, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select ' . (!empty($company_settings['hrm_branch_name']) ? $company_settings['hrm_branch_name'] : __('Branch')))]) }}
                                            <!--@if (empty($branches->count()))-->
                                            <!--    <div class="text-xs">-->
                                            <!--        {{ __('Please add Branch. ') }}<a-->
                                            <!--            href="{{ route('branch.index') }}"><b>{{ __('Add Branch') }}</b></a>-->
                                            <!--    </div>-->
                                            <!--@endif-->
                                            <div class="text-xs">
                                                    {{ __('Please add Branch. ') }}<a
                                                        href="{{ route('branch.index') }}"><b>{{ __('Add Branch') }}</b></a>
                                                </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('department_id', !empty($company_settings['hrm_department_name']) ? $company_settings['hrm_department_name'] : __('Department'), ['class' => 'form-label']) }}<x-required></x-required>
                                            {{ Form::select('department_id', [], null, ['class' => 'form-control', 'id' => 'department_id', 'required' => 'required', 'placeholder' => __('Select ' . (!empty($company_settings['hrm_department_name']) ? $company_settings['hrm_department_name'] : __('Department')))]) }}
                                         <div class="text-xs">
                                                    {{ __('Please add Department. ') }}<a
                                                        href="{{ route('department.index') }}"><b>{{ __('Add Department') }}</b></a>
                                                </div>
                                       
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('designation_id', !empty($company_settings['hrm_designation_name']) ? $company_settings['hrm_designation_name'] : __('Designation'), ['class' => 'form-label']) }}<x-required></x-required>
                                            {{ Form::select('designation_id', [], null, ['class' => 'form-control', 'id' => 'designation_id', 'required' => 'required', 'placeholder' => __('Select ' . (!empty($company_settings['hrm_designation_name']) ? $company_settings['hrm_designation_name'] : __('Designation')))]) }}
                                        <div class="text-xs">
                                                    {{ __('Please add Designation. ') }}<a
                                                        href="{{ route('designation.index') }}"><b>{{ __('Add Designation') }}</b></a>
                                                </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('company_doj', __('Company Date Of Joining'), ['class' => 'form-label']) !!}<x-required></x-required>
                                            {{ Form::date('company_doj', date('Y-m-d'), ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => __('Select company date of joining')]) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('role', __('Role'), ['class' => 'form-label']) }}<x-required></x-required>
                                            {{ Form::select('role', $role, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select Role')]) }}
                                            <div class="text-xs mt-1">
                                                <span class="text-danger text-xs">{{ __('Unable to modify this user`s role. Please ensure that the correct role has been assigned to this user.') }}</span><br>
                                                {{ __('Create role here. ') }}
                                                <a href="{{ route('roles.index') }}"><b>{{ __('Create role') }}</b></a>
                                            </div>
                                        </div>
                                        @stack('biometric_emp_id')
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h5>{{ __('Hours and Rates Detail') }}</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>{{ __('Hours') }}</h6>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('Rates') }}</h6>
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('hours_per_day', __('Hours Per day'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('hours_per_day', null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Enter Hours Per Day')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('annual_salary', __('Annual salary'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('annual_salary', null, ['class' => 'form-control', 'placeholder' => __('Enter Annual Salary')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('days_per_week', __('Days Per week'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('days_per_week', null, ['class' => 'form-control', 'placeholder' => __('Enter Days Per Week')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('fixed_salary', __('Fixed Salary'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('fixed_salary', null, ['class' => 'form-control', 'placeholder' => __('Enter Fixed Salary')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('hours_per_month', __('Hours Per month'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('hours_per_month', null, ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Enter Hours Per Month')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('rate_per_day', __('Rate per day'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('rate_per_day', null, ['class' => 'form-control', 'placeholder' => __('Enter Rate Per Day')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('days_per_month', __('Days per month'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('days_per_month', null, ['class' => 'form-control', 'placeholder' => __('Enter Days Per Month')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('rate_per_hour', __('Rate per hour'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::number('rate_per_hour', null, ['class' => 'form-control', 'placeholder' => __('Enter Rate Per Hour')]) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="payment_requires_work_advice" name="payment_requires_work_advice">
                                                <label class="form-check-label"
                                                    for="payment_requires_work_advice">{{ __('This employee must not be paid unless hours or days worked are advised') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 row">
                                <div class="col-6">
                                    <button class="btn btn-outline-secondary d-inline-flex align-items-center"
                                        onClick="changetab('#personal-details-tab')" type="button"><i
                                            class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                                </div>
                                <div class="col-6 text-end" id="savebutton">
                                    <a class="btn btn-secondary btn-submit me-1"
                                        href="{{ route('employee.index') }}">{{ __('Cancel') }}</a>
                                    <button class="btn btn-primary btn-submit" type="submit"
                                        id="submit">{{ __('Create') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
    <!--<script>-->
    <!--    function changetab(tabname) {-->
    <!--        var someTabTriggerEl = document.querySelector('button[data-bs-target="' + tabname + '"]');-->
    <!--        var actTab = new bootstrap.Tab(someTabTriggerEl);-->
    <!--        actTab.show();-->
    <!--    }-->
    <!--</script>-->

    <script type="text/javascript">
        $(document).on('change', '#branch_id', function() {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(branch_id) {
            var data = {
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            }

            $.ajax({
                url: '{{ route('employee.getdepartments') }}',
                method: 'POST',
                data: data,
                success: function(data) {
                    $('#department_id').empty();
                    $('#department_id').append(
                        '<option value="" disabled>{{ __('Select Department') }}</option>');

                    $.each(data, function(key, value) {
                        $('#department_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    $('#department_id').val('');
                }
            });
        }

        $(document).on('change', 'select[name=department_id]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.getdesignations') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#designation_id').empty();
                    $('#designation_id').append(
                        '<option value="">{{ __('Select Designation') }}</option>');
                    $.each(data, function(key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });
        }
    </script>





<script>
    document.getElementById('address').addEventListener('keydown', function(event) {
        console.log("hleoooooo");
        if (event.key === 'Enter') {
            event.preventDefault();
            return false;
        }
    });

    // Check if Google Maps is already loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        window.googleMapsInitialized = false;

        window.initMap = function() {
            if (window.googleMapsInitialized) return;
               window.googleMapsInitialized = true;

            initializeAutocomplete();
        };

        if (!document.querySelector('script[src*="maps.googleapis.com/maps/api/js"]')) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyB7aLtWqhztn7r4Fcce7WqQT-Qdlpl7MnQ&libraries=places&callback=initMap`;
            script.async = true;
            script.defer = true;
            script.onerror = function() {
                console.error('Failed to load Google Maps API');
            };
            document.head.appendChild(script);
        }
    } else {
        initializeAutocomplete();
    }

    function initializeAutocomplete() {
        try {
            const input = document.getElementById("address");
            if (!input) {
                console.error('Address input element not found');
                return;
            }

            const options = {
                fields: ["formatted_address", "geometry", "name", "address_components"],
                strictBounds: false
            };

            // Initialize Google Places Autocomplete
            const autocomplete = new google.maps.places.Autocomplete(input, options);
  
            // Add listener for place selection
            autocomplete.addListener("place_changed", function() {
                const place = autocomplete.getPlace();
                 console.log("hleoooooo",place);
                if (!place.geometry) {
                    return;
                }

                try {
                    // Extract coordinates
                    // document.getElementById('address_latitude').value = place.geometry.location.lat();
                    // document.getElementById('address_longitude').value = place.geometry.location.lng();
                    document.getElementById('address').value = place.formatted_address;
                    console.log("hleoooooo",place.formatted_address);
                    // Initialize city, state, and country variables
                    let city = "", state = "", country = "",zip = "";;

                    // Check if address_components is available
                    if (place.address_components) {
                        // Loop through address_components to find city, state, and country
                        for (const component of place.address_components) {
                            const types = component.types;

                            if (types.includes("locality")) {
                                city = component.long_name; // City
                            }
                            if (types.includes("administrative_area_level_1")) {
                                state = component.long_name; // State
                            }
                            if (types.includes("country")) {
                                country = component.long_name; // Country
                            }
                            if (types.includes("postal_code")) {
                                zip = component.long_name; // ZIP Code
                            }
                        }
                    } else {
                        console.error('No address components found.');
                    }

                    // Update the company_city input dynamically
                    // document.getElementById('company_city').value = city;

                    // Assign values to hidden fields
                    document.getElementById('city').value = city;
                    document.getElementById('state').value = state;
                    document.getElementById('country').value = country;
                    document.getElementById("zipcode").value = zip;
                } catch (error) {
                    console.error('Error updating location details:', error);
                }
            });
        } catch (error) {
            console.error('Error initializing Google Places Autocomplete:', error);
        }
    }
</script>







@push('scripts')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone-amd-module.min.js') }}"></script>
    <script>
        // Your existing changetab function - replace it with this updated version
        function changetab(tabname) {
            // If going from personal details to company tab, validate first
            if (tabname === '#company-tab') {
                if (!validateCurrentTab('#personal-details-tab')) {
                    // Show alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill all required fields in Personal Details before proceeding.',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            }
            
            // If validation passed or going to previous tab, proceed with tab change
            var someTabTriggerEl = document.querySelector('button[data-bs-target="' + tabname + '"]');
            var actTab = new bootstrap.Tab(someTabTriggerEl);
            actTab.show();
            return true;
        }

        // Function to validate required fields in the current tab
        function validateCurrentTab(tabId) {
            const tab = document.querySelector(tabId);
            const requiredFields = tab.querySelectorAll('[required]');
            let isValid = true;
            
            // Reset previous validation errors
            const invalidFields = tab.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
            });
            
            // Validate each required field
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // For radio buttons, check if any is selected
                    if (field.type === 'radio') {
                        const name = field.getAttribute('name');
                        const radioGroup = document.querySelectorAll(`input[name="${name}"]:checked`);
                        if (radioGroup.length > 0) {
                            field.classList.remove('is-invalid');
                        }
                    }
                } else if (field.type === 'email' && !validateEmail(field.value)) {
                    isValid = false;
                    field.classList.add('is-invalid');
                }
            });
            
            // If not valid, scroll to the first invalid field
            if (!isValid) {
                const firstInvalid = tab.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            return isValid;
        }

        // Email validation helper
        function validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        // Add form submission validation
        $(document).ready(function() {
            const form = $('form.needs-validation');
            
            form.on('submit', function(event) {
                // Validate both tabs
                const personalTabValid = validateCurrentTab('#personal-details-tab');
                const companyTabValid = validateCurrentTab('#company-tab');
                
                if (!personalTabValid || !companyTabValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // If personal tab has errors, switch to it
                    if (!personalTabValid) {
                        changetab('#personal-details-tab');
                    } else if (!companyTabValid) {
                        changetab('#company-tab');
                    }
                }
            });
            
            // Add input event listeners to clear validation errors when typing
            $('input, select, textarea').on('input change', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>

    
@endpush

@endpush
