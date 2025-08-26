@if (module_is_active('RestaurantMenu') && !empty($restaurant_customer))
    <div class="row row-gap">
        <div class="col-md-10">
            <div class="mt-3">
                <span><b>{{ __('First Name')}} : </b> {{ isset($restaurant_customer->first_name) ? $restaurant_customer->first_name : '--' }}</span><br>
                <span><b>{{ __('Last Name')}} : </b> {{ isset($restaurant_customer->last_name) ? $restaurant_customer->last_name : '--' }}</span><br>
                <span><b>{{ __('Email')}} : </b> {{ isset($restaurant_customer->email) ? $restaurant_customer->email : '--' }}</span>
            </div>
        </div>
        <div class="col-md-2">
            <a href="#" id="remove" class="text-sm btn btn-danger">{{__(' Remove')}}</a>
        </div>
    </div>
@endif
