
{{ Form::model($product, array('route' => array('shopify-product.update' ,$id), 'method' => 'PUT','class'=>'needs-validation','novalidate')) }}


<div class="modal-body">
    <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('category_name', __('Category'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::select('category_name',$category,$product->category_id, ['class' => 'form-control ', 'placeholder' => __('Please Select Category'), 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('tax_name', __('Tax'), ['class' => 'col-form-label']) }}<x-required></x-required>
                    {{ Form::select('tax_name' ,$tax ,$product->tax_id,['class' => 'form-control ', 'placeholder' => __('Please Select Tax'), 'required' => 'required']) }}
                </div>
            </div>
            <input type="hidden" name="product_id" value="{{$id}}">

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    {{ Form::submit(__('Update'), ['class' => 'btn  btn-primary']) }}
</div>
{{ Form::close() }}





