<div class="card" id="shopify_sidenav">
    {{ Form::open(array('route' => 'shopify.setting','method' => 'post')) }}
    <div class="card-header">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
                <h5 class="">{{ __('Shopify Settings') }}</h5>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 text-end">
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="shopify_setting_is_on" class="form-check-input input-primary" id="shopify_setting_is_on" {{ (isset($settings['shopify_setting_is_on']) && $settings['shopify_setting_is_on']=='on') ? ' checked ' : '' }} >
                    <label class="form-check-label" for="shopify_setting_is_on"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('shopify_store_url',__('Shopify store url'),array('class'=>'form-label')) }}
                    <div class="input-group">
                        {{Form::text('shopify_store_url',isset($settings['shopify_store_url']) ? $settings['shopify_store_url'] :'',array('class'=>'form-control', 'placeholder' => 'Enter Store Url'))}}
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">{{'.myshopify.com'}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{Form::label('shopify_access_token',__('Shopify access token'),array('class'=>'form-label')) }}
                    {{Form::text('shopify_access_token',isset($settings['shopify_access_token']) ? $settings['shopify_access_token'] :'',array('class'=>'form-control', 'placeholder' => 'Enter Shopify access token'))}}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit" value="{{ __('Save Changes') }}">
    </div>
    {{Form::close()}}
</div>

<script>
    $(document).on('click','#shopify_setting_is_on',function(){
        if( $('#shopify_setting_is_on').prop('checked') )
        {
            $("#shopify_store_url").removeAttr("disabled");
            $("#shopify_access_token").removeAttr("disabled");
        } else {
            $('#shopify_store_url').attr("disabled", "disabled");
            $('#shopify_access_token').attr("disabled", "disabled");
        }
    });
</script>


