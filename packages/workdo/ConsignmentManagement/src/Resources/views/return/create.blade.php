{{ Form::open(['route' => 'consignment-return.store', 'class' => 'w-100 needs-validation ', 'novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('product_id', __('Sales Order'), ['class' => 'form-label']) }}<x-required></x-required>
            <select class="form-control" required="required" id="sale_order_id" name="sale_order_id">
                <option value="">{{__('Select Order')}}</option>
                @foreach($sale_order as $key=>$order)
                    <option  value="{{$order}}">{{\Workdo\ConsignmentManagement\Entities\SaleOrder::saleOrderNumberFormat($order)}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('product_id', __('Product'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('product_id', [], null, ['class' => 'form-control', 'id' => 'product_id', 'required' => 'required', 'placeholder' => __('Select Products')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::number('quantity', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Quantity')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('return_reason', __('Return Reason'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('return_reason', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Return Reason')]) }}
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('return_date', __('Return Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('return_date', date('Y-m-d'), ['class' => 'form-control date', 'required' => 'required', 'placeholder' => __('Enter Return Date')]) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('status', $status, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select Status')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancle') }}</button>
    <button type="submit" id="submit" class="btn  btn-primary ">{{ __('Create') }}</button>
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        $("#sale_order_id").change(function(event) {
            var sale_order_id = $(this).val();
            $.ajax({
                url: '{{ route('consignment.return.product') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    sale_order_id: sale_order_id
                },
                success: function(data) {
                    $('#product_id').empty();
                    $('#product_id').append('<option value="">' + "{{ __('Select Product') }}" + '</option>');
                    $.each(data.products, function(key, value) {
                        $('#product_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        });
    });
</script>

