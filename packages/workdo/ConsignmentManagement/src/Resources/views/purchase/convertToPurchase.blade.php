{{ Form::open(['route' => ['purchase.order.convert', $purchaseOrderId], 'method' => 'get', 'id' => 'purchaseForm' , 'class' => 'w-100']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="form-group">
                {{ Form::label('warehouse_id', __('Warehouse'), ['class' => 'form-label']) }}
                {{ Form::select('warehouse_id', $warehouse, null, ['class' => 'form-control select', 'required' => 'required', 'id' => 'warehouse_id']) }}
            </div>
        </div>
        <div class="col-lg-12 col-12">
            <div class="form-group">
                {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}
                {{ Form::select('category_id', $category, null, ['class' => 'form-control select', 'required' => 'required', 'id' => 'category_id']) }}
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-end ">
        <div class="col-lg-6 col-6 d-flex justify-content-end modal-footer">
            <input type="button" value="{{ __('Cancel') }}" class="btn btn-light me-2" data-bs-dismiss="modal">
            {!! Form::open([
                'url' => route('purchase.order.convert', $purchaseOrderId),
                'method' => 'GET',
                'class' => 'show_confirm',
                'data-bs-toggle' => 'tooltip',
                'data-bs-original-title' => __('Convert to Purchase'),
                'data-text' => __('This action can not be undone. Do you want to continue?'),
                'data-confirm-yes' => 'purchase-form-{{ $purchaseOrderId }}',
            ]) !!}
            {!! Form::button(__('Convert'), [
                'type' => 'submit',
                'class' => 'btn btn-primary',
                'id' => 'convertButton',
            ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
{{ Form::close() }}

