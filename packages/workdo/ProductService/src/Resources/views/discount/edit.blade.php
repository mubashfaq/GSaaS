{{ Form::model($discount, ['route' => ['discount.update', $discount->id], 'method' => 'PUT','class' => 'needs-validation', 'novalidate']) }}
<div class="modal-body">
    <!--<div class="row">-->
    <!--    <div class="form-group col-md-12">-->
    <!--        {{ Form::label('name', __('Unit Name'), ['class' => 'form-label']) }}<x-required></x-required>-->
    <!--        {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => __('Enter Unit Name')]) }}-->
    <!--        @error('name')-->
    <!--            <small class="invalid-name" role="alert">-->
    <!--                <strong class="text-danger">{{ $message }}</strong>-->
    <!--            </small>-->
    <!--        @enderror-->
    <!--    </div>-->
    <!--</div>-->
    
    
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Title'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('title', null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Discount Title'))) }}
            @error('title')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('description', __('Discount Description'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::text('description', null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Discount Description'))) }}
            @error('description')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
                {{ Form::label('discount_type', __('Discount '), ['class' => 'form-label']) }}
                <x-required></x-required>
                
                {{-- Replace this with your actual unit options --}}
                @php
                    $unitOptions = [
                        '' => __('Select Unit Name'),
                        '0' => 'Percentage',
                        '1' => 'Fixed Amount',
                       
                    ];
                @endphp
            
                {{ Form::select('discount_type', $unitOptions, null, [
                    'class' => 'form-control',
                    'required' => 'required'
                ]) }}
            
                @error('discount_type')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        <div class="form-group col-md-6">
            {{ Form::label('discount_value', __('Discount Value'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::number('discount_value', null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Discount Value'))) }}
            @error('discount_value')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('from_date', __('Start Date'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::date('from_date', null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter Start Date'))) }}
            @error('from_date')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('Expired Date'),['class'=>'form-label']) }}<x-required></x-required>
            {{ Form::date('end_date', null, array('class' => 'form-control','required'=>'required', 'placeholder' => __('Enter End Date'))) }}
            @error('end_date')
                <small class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
    <div class="row">
        
            
            <div class="form-group col-md-6">
                {{ Form::label('discount_for', __('Discount Type'), ['class' => 'form-label']) }}
                <x-required></x-required>
                
                {{-- Replace this with your actual unit options --}}
                @php
                    $unitOptions = [
                        '' => __('Select Discount Name'),
                        '0' => 'Product Discount',
                        '1' => 'Collection Discount',
                       
                       
                    ];
                @endphp
            
                {{ Form::select('discount_for', $unitOptions, null, [
                    'class' => 'form-control',
                    'required' => 'required'
                ]) }}
            
                @error('discount_for')
                    <small class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
