
{{-- {{ Form::model(array('route' => array('product.shopify.store', $id), 'method' => 'PUT')) }} --}}
{{ Form::open(['route' => 'product.shopify.store','class'=>'needs-validation','novalidate']) }}

{{-- <form id="data"> --}}
<div class="modal-body">
    <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('category_name', __('Category'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::select('category_name',$category,null, ['class' => 'form-control ', 'placeholder' => __('Please Select Category'), 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('tax_name', __('Tax'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::select('tax_name' ,$tax ,null,['class' => 'form-control ', 'placeholder' => __('Please Select Tax'), 'required' => 'required']) }}
                </div>
            </div>
            <input type="hidden" name="product_id" value="{{$id}}">

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Create'), ['class' => 'btn  btn-primary']) }}
</div>
{{-- </form> --}}
{{ Form::close() }}

<script>
        $(document).ready(function() {
        $('#data').on('submit',function(e){

        console.log($("#data").serialize());
        $.ajax({
            type:"POST",
            url:"{{ route('product.shopify.store' , $id)}}",
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data){
                console.log(data);
            },
            error: function(data){

            }


        });
    });

    });
</script>



