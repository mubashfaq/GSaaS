@php
    $categories = \Workdo\RestaurantMenu\Entities\RestaurantCategory::where('category_id',$category->id)->where('image_switch','on')->where('created_by', '=', creatorId())->where('workspace_id', getActiveWorkSpace())->where('type', 4)->first();                
@endphp
@if($categories)
<div class="col-md-6">
    <div class="form-group">
        {{ Form::label('food_image', __('Image'), ['class' => 'form-label']) }}
        <div class="choose-file">
            <label for="Image">
                <input type="file" class="form-control" name="food_image" id="food_image"
                    data-filename="food_image" accept="image/*,.jpeg,.jpg,.png"
                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                    style = "width:365px">
                <img id="blah" width="25%" class="mt-3"
                    src="{{ asset($categories->food_image) ?? '' }}">
            </label>
        </div>
    </div>
</div>
@endif