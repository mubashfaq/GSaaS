<div class="row">
    <div class="col-sm-12">
        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end mb-4">
            <div class="col-md-6">
                <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details" data-bs-toggle="pill"
                            data-bs-target="#details-tab" type="button">{{ __('Details') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pricing" data-bs-toggle="pill" data-bs-target="#pricing-tab"
                            type="button">{{ __('Pricing') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="media" data-bs-toggle="pill" data-bs-target="#media-tab"
                            type="button">{{ __('Media') }}</button>
                    </li>
                    <li class="nav-item" role="presentation" id="restaurant-varient">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#restaurant-varient-tab"
                            type="button">{{ __('Restaurant Varient') }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="details-tab" role="tabpanel"
                        aria-labelledby="pills-user-tab-1">
                        <div class="text-end mb-3">
                            @if (module_is_active('AIAssistant'))
                                @include('aiassistant::ai.generate_ai_btn', [
                                    'template_module' => 'product',
                                    'module' => 'ProductService',
                                ])
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::text('name',!empty($productService->name)?$productService->name:'', ['class' => 'form-control' , 'placeholder' => __('Enter Name')]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('sku', __('SKU'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="input-group">
                                        {{ Form::text('sku',!empty($productService->sku)?$productService->sku:'', ['class' => 'form-control', 'placeholder' => __('Enter SKU')]) }}
                                        <button class="btn btn-outline-primary" type="button"
                                            onclick="generateSKU()">{{ __('Generate') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                {{ Form::label('tax_id', __('Tax'), ['class' => 'form-label']) }}
                                {{ Form::select('tax_id[]', $tax, !empty($productService->tax_id)?explode(',', $productService->tax_id):'', ['class' => 'form-control choices tax_data', 'id' => 'choices-multiple1', 'multiple']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }}<span
                                    class="text-danger">*</span>
                                {{ Form::select('category_id', $category, !empty($productService->category_id)?$productService->category_id:'', ['class' => 'form-control', 'required' => 'required']) }}

                                <div class="mt-1 text-xs">
                                    {{ __('Please add constant category. ') }}<a
                                        href="{{ route('category.index') }}"><b>{{ __('Add Category') }}</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                            {!! Form::textarea('description', !empty($productService->description)?$productService->description:'', ['class' => 'form-control', 'rows' => '2' , 'placeholder' => __('Enter Description')]) !!}
                        </div>
                        @if (module_is_active('CustomField') && !$customFields->isEmpty())
                            <div class="col-md-12">
                                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                    @include('custom-field::formBuilder')
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-6 text-end">
                                <button class="btn btn-primary d-inline-flex align-items-center"
                                    onClick="changetab('#pricing-tab')" type="button">{{ __('Next') }}<i
                                        class="ti ti-chevron-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pricing-tab" role="tabpanel" aria-labelledby="pills-user-tab-2">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('sale_price', __('Sale Price'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::number('sale_price',!empty($productService->sale_price)?$productService->sale_price:'', ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Enter Sale Price')]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('purchase_price', __('Purchase Price'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::number('purchase_price', !empty($productService->purchase_price)?$productService->purchase_price:'', ['class' => 'form-control', 'step' => '0.01', 'placeholder' => __('Enter Purchase Price')]) }}
                                    </div>
                                </div>
                            </div>
                            @stack('add_column_in_productservice')
                            <div class="form-group col-md-6">
                                {{ Form::label('unit_id', __('Unit'), ['class' => 'form-label']) }}<span
                                    class="text-danger">*</span>
                                {{ Form::select('unit_id', $unit, !empty($productService->unit_id)?$productService->unit_id:'', ['class' => 'form-control', 'required' => 'required']) }}
                            </div>

                            <div class="form-group col-md-6 quantity">
                                {{ Form::label('quantity', __('Quantity'), ['class' => 'form-label']) }}<span
                                    class="text-danger">*</span>
                                {{ Form::number('quantity', !empty($productService->quantity)?$productService->quantity:'0', ['class' => 'form-control', 'min' => '0' , 'placeholder' => __('Enter Quntity')]) }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <button class="btn btn-outline-secondary d-inline-flex align-items-center"
                                    onClick="changetab('#details-tab')" type="button"><i
                                        class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-primary d-inline-flex align-items-center"
                                    onClick="changetab('#media-tab')" type="button">{{ __('Next') }}<i
                                        class="ti ti-chevron-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="media-tab" role="tabpanel" aria-labelledby="pills-user-tab-3">
                        <div class="col-sm-6 col-12 form-group">
                            {{ Form::label('image', __('Image'), ['class' => 'col-form-label']) }}
                            <div class="choose-file form-group">
                                <label for="file" class="form-label d-block">
                                    <input type="file" class="form-control file" name="image" id="file"
                                        data-filename="image_update"
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                    @php
                                        if (!empty($productService->image) && check_file($productService->image) == true) {
                                            $path = get_file($productService->image);

                                        } else {
                                            $path = asset(
                                                'packages/workdo/ProductService/src/Resources/assets/image/img01.jpg',
                                            );
                                        }
                                    @endphp
                                    <hr>
                                    <img id="blah" src="{{ $path }}" alt="your image" width="100"
                                        height="100" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-outline-secondary d-inline-flex align-items-center"
                                    onClick="changetab('#pricing-tab')" type="button"><i
                                        class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                            </div>

                            <div class="col-6 text-end" id="nextButtonContainer">
                                <button class="btn btn-primary d-inline-flex align-items-center"
                                    onClick="changetab('#restaurant-varient-tab')" type="button">{{ __('Next') }}
                                    <i class="ti ti-chevron-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade restaurant-varient" id="restaurant-varient-tab" role="tabpanel"
                        aria-labelledby="pills-user-tab-1">
                        <div class="text-end mb-3">
                            @if (module_is_active('AIAssistant'))
                                @include('aiassistant::ai.generate_ai_btn', [
                                    'template_module' => 'product',
                                    'module' => 'ProductService',
                                ])
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('varient_name', __('Name'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::text('varient_name', isset($varient->varient_name) ? $varient->varient_name : '', ['class' => 'form-control', 'placeholder' => __('Enter Name')]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('additional_price', __('Additional Price'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::text('additional_price',  isset($varient->additional_price) ? $varient->additional_price : '', ['class' => 'form-control' , 'placeholder' => __('Enter Additional Price')]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('item_attribute', __('Item Attribute'), ['class' => 'form-label']) }}<span
                                        class="text-danger">*</span>
                                    <div class="form-icon-user">
                                        {{ Form::select('item_attribute', $itemAttribute, isset($varient->item_attribute) ? $varient->item_attribute : null, ['class' => 'form-control', 'placeholder' => 'Select Item Attribute']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                                <div class="d-flex radio-check">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="active" value="active" name="status" {{!empty($varient->status) && !empty($varient->status == 'active') ? 'checked' : ''}}
                                            class="form-check-input code" checked="checked">
                                        <label class="custom-control-label"
                                            for="active">{{ __('Active') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="in_active" value="Inactive" name="status" {{!empty($varient->status) && !empty($varient->status == 'Inactive') ? 'checked' : ''}}
                                            class="form-check-input code">
                                        <label class="custom-control-label"
                                            for="in_active">{{ __('InActive') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (module_is_active('CustomField') && !$customFields->isEmpty())
                            <div class="col-md-12">
                                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                    @include('custom-field::formBuilder')
                                </div>
                            </div>
                        @endif
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <button class="btn btn-outline-secondary d-inline-flex align-items-center"
                                    onClick="changetab('#media-tab')" type="button"><i
                                        class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                            </div>
                            <div class="d-flex gap-2 justify-content-end text-end modal-footer" id ="item_save">
                                <a class="btn btn-secondary btn-light btn-submit"
                                    href="{{ route('product-service.index') }}">{{ __('Cancel') }}</a>
                                <button class="btn btn-primary btn-submit" type="submit"
                                    id="submit">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
