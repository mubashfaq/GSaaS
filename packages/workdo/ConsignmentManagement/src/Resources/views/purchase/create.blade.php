@extends('layouts.main')
@section('page-title')
    {{ __('Purchase Order Create') }}
@endsection
@section('page-breadcrumb')
    {{ __('Purchase Order Create') }}
@endsection

@section('page-action')
    <div>

    </div>
@endsection

@push('scripts')
    <script>
        $('.consignments-select').on('change', function() {

            var consignmentId = $('.consignments-select').val();

            $.ajax({
                url: '{{ route('get.section') }}',
                type: 'POST',
                data: {
                    "consignment_id": consignmentId,
                    "_token": "{{ csrf_token() }}",
                    "module": 'purchase',
                },
                success: function(response) {
                    if (response.status == true) {
                        $('.section_div').html(response.html);
                        $("#loader").addClass('d-none');
                        $('.date').val(response.date);
                    } else {
                        $('.section_div').html('');
                        $("#loader").removeClass('d-none');
                    }
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        {{ Form::open(['route' => 'purchase-order.store', 'class' => 'w-100 needs-validation','novalidate']) }}

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <div class="row" id="customer-box">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <div class="form-group ">
                                            <label class="require form-label">{{ __('Consignment') }}</label><x-required></x-required>
                                            {{ Form::select('consignment', $consignments, null, ['class' => 'form-control consignments-select', 'id' => 'vendor', 'required' => 'required', 'placeholder' => __('Please Select')]) }}

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    {{ Form::label('vendor', __('Vendor'), ['class' => 'form-label']) }}<x-required></x-required>
                                    {{ Form::select('vendor', $vendors, null, ['class' => 'form-control select-vendor', 'id' => 'vendor', 'required' => 'required', 'placeholder' => __('Select vendor')]) }}
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}<x-required></x-required>
                                        <div class="form-icon-user">
                                            {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control date', 'required' => 'required', 'placeholder' => __('Select Date')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="loader" class="card card-flush">
            <div class="card-body">
                <div class="row">
                    <img class="loader" src="{{ asset('public/images/loader.gif') }}" alt="">
                </div>
            </div>
        </div>

        <div class="col-12 section_div">

        </div>

        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('purchase-order.index') }}';"
                class="btn btn-light ">
            <input type="submit" id="submit" value="{{ __('Create') }}" class="btn  btn-primary mx-3">
        </div>

        {{ Form::close() }}

    </div>
@endsection
