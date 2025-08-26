{{ Form::open(['route' => 'consignment-qualitycontrol.store', 'class' => 'w-100 needs-validation ', 'novalidate']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('consignment_id', __('Consignment'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('consignment_id', $consignment, null, ['class' => 'form-control', 'id' => 'consignment_id', 'required' => 'required', 'placeholder' => __('Select Consignment')]) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('product_id', __('Product'), ['class' => 'form-label']) }}<x-required></x-required>
            <div class="department_div">
                <select class="form-control  product_id " name="product_id[]">
                <option value=null>{{ __('Select Product') }}</option>
                </select>
            </div>
            <p class="text-danger error_message"></p>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('check_date', __('Check Date'), ['class' => 'form-label']) }}<x-required></x-required>
                {{ Form::date('check_date', date('Y-m-d'), ['class' => 'form-control date', 'required' => 'required', 'placeholder' => __('Enter Check Date')]) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::select('status', $status, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Select Status')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('inspector', __('Inspector'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('inspector', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Inspector')]) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('remarks', __('Remarks'), ['class' => 'form-label']) }}<x-required></x-required>
            {{ Form::text('remarks', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Remarks')]) }}
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
        $("#consignment_id").change(function(event) {
            var consignment_id = $(this).val();
            $.ajax({
                url: '{{ route('consignment.qualitycontrol.product') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    consignment_id: consignment_id
                },
                success: function(data) {

                    $('.product_id').empty();
                    var emp_selct = ` <select class="form-control  product_id" name="product_id[]" id="choices-multiple"
                                            placeholder="Select Department" multiple >
                                            </select>`;
                    $('.department_div').html(emp_selct);

                    $.each(data, function(key, value) {
                        $('.product_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });

                }
            });
        });
    });

    $(document).ready(function() {
        $("#submit").click(function(event) {
            var product_id = $('.product_id').val();

            if (!product_id || product_id == "") {
                $('.error_message').text('Please select a product before submitting the form');  // Display validation message
                event.preventDefault();  // Prevent form submission
        }
        });
    });
</script>

