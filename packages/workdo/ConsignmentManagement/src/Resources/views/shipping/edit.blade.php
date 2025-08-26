
{{ Form::model($shipping, ['route' => ['consignment-shipping.update',$shipping->id],'method'=>'PUT', 'class' => 'needs-validation formsubmit','novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('consignment_id', __('Consignment'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('consignment_id', $consignment, null, ['class' => 'form-control select-customer', 'id' => 'customer', 'required' => 'required', 'placeholder' => __('Select Consignment')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('tracking_number', __('Tracking Number'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('tracking_number', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Tracking Number')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('shipping_company', __('Shipping Company'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('shipping_company', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Shipping Company')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('status', $status, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select Status')]) }}
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('shipping_date', __('Shipping Date'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::date('shipping_date', null, ['class' => 'form-control date', 'required' => 'required', 'placeholder' => __('Enter Shipping Date')]) }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('estimated_delivery_date', __('Estimated Delivery Date'), ['class' => 'form-label']) }}<x-required></x-required>
                <div class="form-icon-user">
                    {{ Form::date('estimated_delivery_date', null, ['class' => 'form-control date', 'required' => 'required', 'placeholder' => __('Enter Estimated Delivery Date')]) }}
                </div>
                <p class="text-danger" id="error_message"></p>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Cancle')}}</button>
    <button type="submit"  id="submit" class="btn  btn-primary shipmentForm" >{{__('Update')}}</button>
</div>

{{ Form::close() }}

<script>
    $(document).ready(function() {
        $("#submit").click(function(event) {
            var isValid = true;
            var shippingDate = $("#shipping_date").val();
            var estimatedDeliveryDate = $("#estimated_delivery_date").val();
            if (estimatedDeliveryDate < shippingDate) {
                $("#error_message").text(
                    "Estimated delivery date must be on or after the shipping date.");
                isValid = false;
            } else {

            }
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
