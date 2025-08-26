<div class="category">
    <div class="mb-3 d-flex gap-2">
        <label for="image_switch">{{ __('enable/disable') }}</label>
        <div class="form-check form-switch custom-switch-v1 float-end">
            <input type="checkbox" name="image_switch" class="form-check-input input-primary pointer" value="on" id="image_switch" {{ company_setting('image_switch')=='on'?' checked ':'' }}>
            <label class="form-check-label" for="image_switch"></label>
        </div>
    </div>
    <div class="d-none img_div">
        <div class="form-group">
            {{ Form::label('food_image', __('Image'), ['class' => 'form-label']) }}
            <div class="choose-file">
                <label for="food_image">
                    <input type="file" class="form-control" name="food_image" id="food_image"
                        data-filename="food_image" accept="image/jpeg, image/jpg, image/png" 
                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                        style="width: 365px">
                    <img id="blah" width="25%" class="mt-3">
                </label>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('change', '#image_switch', function() {
        if ($(this).is(':checked')) {
            $('.img_div').removeClass('d-none');
            $('#food_image').attr("required", true);

        } else {
            $('.img_div').addClass('d-none');
            $('#food_image').val(null);
            $('#food_image').removeAttr("required");
        }
    });
</script>