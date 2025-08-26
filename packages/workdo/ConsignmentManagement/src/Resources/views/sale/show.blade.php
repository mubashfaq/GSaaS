@extends('layouts.main')
@section('page-title')
    {{ __('Sale Order Detail') }}
@endsection
@section('page-breadcrumb')
    {{ __('Sale Order Detail') }}
@endsection

@section('page-action')
    <div>
        <a type="button" href="{{ route('sale-order.index') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Back') }}">
            <i class="ti ti-arrow-back-up"></i>
        </a>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            var consignmentId = '{{ $saleOrder->consignment_id }}';

            $.ajax({
                url: '{{ route('get.section') }}',
                type: 'POST',
                data: {
                    "consignment_id": consignmentId,
                    "_token": "{{ csrf_token() }}",
                    "module": 'sale',

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

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <div class="row" id="customer-box">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <div class="form-group ">
                                            <label class="require form-label">{{ __('Consignment') }}</label>
                                            <p>{{ $saleOrder->consignment->title }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    {{ Form::label('customer', __('Customer'), ['class' => 'form-label']) }}
                                    <p>{{ $saleOrder->customer->name }}</p>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
                                        <div class="form-icon-user">
                                            <p>{{ $saleOrder->date }}</p>

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



    </div>
@endsection
