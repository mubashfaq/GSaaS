@extends('restaurant-menu::layouts.master')

<link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/custom.css') }}">

@section('content')
<section class="banner-sec pt">
    <div class="container">
        <div class="banner-image">
            <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/banner-image.png') }}" alt="banner-image">
        </div>
    </div>
</section>
@if(!empty($categories))
<section class="category-sec tabs-wrapper pt">
    <div class="container">
        <div class="section-title arrow-header">
            <h2>{{ __('Categories') }}</h2>
            <div class="buttons-wrapper d-flex align-items-center">
                <div class="arrow-wrapper">
                    <div class="category-arrow swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 12 20"
                            fill="none">
                            <path
                                d="M11.1727 9.45118L1.92216 0.226174C1.61907 -0.0758947 1.12837 -0.0753869 0.825796 0.227737C0.523453 0.530822 0.524235 1.0218 0.827358 1.3241L9.52732 10L0.827046 18.6759C0.523961 18.9783 0.52318 19.4689 0.825483 19.7721C0.977162 19.924 1.17587 20 1.37458 20C1.57279 20 1.77071 19.9245 1.92212 19.7736L11.1727 10.5489C11.3187 10.4036 11.4006 10.206 11.4006 10C11.4006 9.7941 11.3185 9.59668 11.1727 9.45118Z"
                                fill="white" />
                        </svg>
                    </div>
                    <div class="category-arrow swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 12 20"
                            fill="none">
                            <path
                                d="M11.1727 9.45118L1.92216 0.226174C1.61907 -0.0758947 1.12837 -0.0753869 0.825796 0.227737C0.523453 0.530822 0.524235 1.0218 0.827358 1.3241L9.52732 10L0.827046 18.6759C0.523961 18.9783 0.52318 19.4689 0.825483 19.7721C0.977162 19.924 1.17587 20 1.37458 20C1.57279 20 1.77071 19.9245 1.92212 19.7736L11.1727 10.5489C11.3187 10.4036 11.4006 10.206 11.4006 10C11.4006 9.7941 11.3185 9.59668 11.1727 9.45118Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper category-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="javascript:void(0);" data-tab="0" class="category-card active">
                        <div class="category-image">
                            <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/category-1.png') }}"
                                alt="category-image" loading="lazy">
                        </div>
                        <div class="category-name">
                            <p>{{ __('All Item') }}</p>
                        </div>
                    </a>
                </div>
                @foreach ($categories as $category)
                <div class="swiper-slide">
                    <a href="javascript:void(0);" class="category-card" data-tab="{{ $category->id }}">
                        <div class="category-image">
                            <img src="{{ isset($category->food_image) ? get_file($category->food_image) : '' }}"
                                alt="category-image" loading="lazy">

                        </div>
                        <div class="category-name">
                            <p>{{ $category->name }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tabs-container pt pb">
            <div class="title">
                <h3 class="category_name"></h3>
            </div>
            <div id="0" class="tab-content active">
                <div class="row no-gutters">
                    @foreach ($categories as $category)
                    @foreach ($category->items as $item)
                    @php
                    $currentDate = now();
                    $offers = \Workdo\RestaurantMenu\Entities\RestaurantOffer::where('items',$item->id)->where('status','active')->whereDate('start_date', '<=', $currentDate)
                        ->whereDate('end_date', '>=', $currentDate)->first();
                        $originalPrice = $item->sale_price;
                        if($offers)
                        {
                        $discountedPrice = $offers ? $originalPrice - ($originalPrice * $offers->discount / 100) : $originalPrice;
                        }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-card">
                                <div class="product-card-image img-wrapper">
                                    <img src="{{ isset($item->image) ? get_file($item->image) : '' }}"
                                        alt="product-image">

                                </div>
                                <div class="product-content">
                                    <div class="product-content-top">
                                        <h4>{{ $item->name }}</h4>
                                        <p>{{ $item->description }}</p>
                                    </div>
                                    <div class="product-content-bottom">
                                        <div class="price-wrp d-flex">
                                            <div class="price d-flex align-items-center">
                                                @if(!empty($offers->discount))
                                                <ins>
                                                    {{ currency_format_with_sym($discountedPrice, $company_id, $workspace_id) }}
                                                </ins>
                                                <del>
                                                    {{ currency_format_with_sym($item->sale_price, $company_id, $workspace_id) }}
                                                </del>
                                                @else
                                                <ins>
                                                    {{ currency_format_with_sym($item->sale_price, $company_id, $workspace_id) }}
                                                </ins>

                                                @endif
                                                <span class="discount-label">
                                                    @if(!empty($offers->discount))
                                                    ( {{$offers->discount}}% off )
                                                    @endif
                                                </span>
                                            </div>
                                            <a data-url="{{  route('restaurant-place-order', ['item_id' => $item->id, 'table_id' => $diningTable->id]) }}"
                                                class="order d-flex align-items-center" data-ajax-popup="true"
                                                data-size="md" data-toggle="tooltip">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                    height="21" viewBox="0 0 18 21" fill="none">
                                                    <path
                                                        d="M6.021 20.25C5.68948 20.2513 5.37101 20.1209 5.13565 19.8874C4.90029 19.6539 4.76733 19.3365 4.766 19.005C4.76467 18.6735 4.8951 18.355 5.12858 18.1196C5.36206 17.8843 5.67948 17.7513 6.011 17.75H6.021C6.35252 17.75 6.67046 17.8817 6.90488 18.1161C7.1393 18.3505 7.271 18.6685 7.271 19C7.271 19.3315 7.1393 19.6495 6.90488 19.8839C6.67046 20.1183 6.35252 20.25 6.021 20.25ZM15.271 19C15.271 18.6685 15.1393 18.3505 14.9049 18.1161C14.6705 17.8817 14.3525 17.75 14.021 17.75H14.011C13.7642 17.752 13.5235 17.827 13.3193 17.9655C13.115 18.104 12.9564 18.3 12.8633 18.5285C12.7702 18.7571 12.7469 19.0081 12.7963 19.2499C12.8456 19.4917 12.9654 19.7135 13.1406 19.8874C13.3159 20.0612 13.5386 20.1792 13.7808 20.2267C14.023 20.2741 14.2738 20.2488 14.5016 20.1539C14.7295 20.059 14.9241 19.8987 15.061 19.6934C15.1979 19.4881 15.271 19.2468 15.271 19ZM17.96 6.36L16.95 12.54C16.9371 12.9022 16.848 13.2576 16.6885 13.583C16.529 13.9085 16.3027 14.1966 16.0243 14.4288C15.746 14.6609 15.4219 14.8317 15.0731 14.9301C14.7243 15.0286 14.3586 15.0524 14 15H5.73C5.24778 15.0012 4.78146 14.8276 4.41742 14.5113C4.05337 14.1951 3.81626 13.7576 3.75 13.28L2.249 2.832C2.20977 2.53165 2.06223 2.25597 1.83408 2.05673C1.60593 1.85749 1.31289 1.74842 1.01 1.75H0.75C0.551088 1.75 0.360322 1.67098 0.21967 1.53033C0.0790175 1.38967 0 1.19891 0 0.999995C0 0.801083 0.0790175 0.610317 0.21967 0.469665C0.360322 0.329013 0.551088 0.249995 0.75 0.249995H1.01C1.67356 0.245737 2.31594 0.483399 2.81695 0.918513C3.31796 1.35363 3.64326 1.95638 3.732 2.614L3.941 4H16C16.2925 4.00107 16.5812 4.06629 16.8458 4.19107C17.1104 4.31585 17.3444 4.49715 17.5312 4.72218C17.7181 4.94721 17.8534 5.2105 17.9275 5.49348C18.0016 5.77647 18.0127 6.07225 17.96 6.36ZM12.507 7.636C12.4373 7.5663 12.3546 7.51101 12.2636 7.47329C12.1726 7.43557 12.075 7.41616 11.9765 7.41616C11.878 7.41616 11.7804 7.43557 11.6894 7.47329C11.5984 7.51101 11.5157 7.5663 11.446 7.636L9.31 9.772L8.51 8.972C8.36861 8.83531 8.1792 8.75962 7.98255 8.76124C7.7859 8.76285 7.59775 8.84164 7.45863 8.98063C7.31951 9.11962 7.24054 9.3077 7.23874 9.50434C7.23694 9.70099 7.31245 9.89048 7.449 10.032L8.782 11.366C8.92292 11.5063 9.11367 11.585 9.3125 11.585C9.51133 11.585 9.70208 11.5063 9.843 11.366L12.507 8.7C12.5771 8.63029 12.6328 8.5474 12.6708 8.4561C12.7088 8.3648 12.7283 8.26689 12.7283 8.168C12.7283 8.06911 12.7088 7.97119 12.6708 7.87989C12.6328 7.78859 12.5771 7.7057 12.507 7.636Z"
                                                        fill="#0CAF60" />
                                                </svg>
                                                <p>{{ __('Place Order') }}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                </div>
            </div>

            @foreach ($categories as $category)
            <div id="{{ $category->id }}" class="tab-content" data-name="{{ $category->name }}">
                <div class="row">
                    @foreach ($category->items as $item)
                    @php
                    $currentDate = now();
                    $offers = \Workdo\RestaurantMenu\Entities\RestaurantOffer::where('items',$item->id)->where('status','active')->whereDate('start_date', '<=', $currentDate)
                        ->whereDate('end_date', '>=', $currentDate)->first();
                        $originalPrice = $item->sale_price;
                    if($offers)
                    {
                        $discountedPrice = $offers ? $originalPrice - ($originalPrice * $offers->discount / 100) : $originalPrice;
                    }
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-card">
                            <div class="product-card-image img-wrapper">
                                <img src="{{ isset($item->image) ? get_file($item->image) : '' }}"
                                    alt="product-image">
                            </div>
                            <div class="product-content">
                                <div class="product-content-top">
                                    <h4>{{ $item->name }}</h4>
                                    <p>{{ $item->description }}</p>
                                </div>
                                <div class="product-content-bottom">
                                    <div class="price-wrp d-flex">
                                        <div class="price">
                                        @if(!empty($offers->discount))                                                  
                                                    <ins>
                                                        {{ currency_format_with_sym($discountedPrice, $company_id, $workspace_id) }}
                                                    </ins>
                                                    <del>
                                                        {{ currency_format_with_sym($item->sale_price, $company_id, $workspace_id) }}
                                                     </del>
                                                    @else
                                                    <ins>
                                                        {{ currency_format_with_sym($item->sale_price, $company_id, $workspace_id) }}
                                                    </ins>
                                                    
                                                    @endif
                                                    <span class="discount-label">
                                        @if(!empty($offers->discount))
                                        ( {{$offers->discount}}% off )
                                        @endif
                                    </span>
                                        </div>
                                        <a data-url="{{ route('restaurant-place-order', ['item_id' => $item->id, 'table_id' => $diningTable->id]) }}"
                                            class="order d-flex align-items-center" data-ajax-popup="true"
                                            data-size="md" data-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                height="21" viewBox="0 0 18 21" fill="none">
                                                <path
                                                    d="M6.021 20.25C5.68948 20.2513 5.37101 20.1209 5.13565 19.8874C4.90029 19.6539 4.76733 19.3365 4.766 19.005C4.76467 18.6735 4.8951 18.355 5.12858 18.1196C5.36206 17.8843 5.67948 17.7513 6.011 17.75H6.021C6.35252 17.75 6.67046 17.8817 6.90488 18.1161C7.1393 18.3505 7.271 18.6685 7.271 19C7.271 19.3315 7.1393 19.6495 6.90488 19.8839C6.67046 20.1183 6.35252 20.25 6.021 20.25ZM15.271 19C15.271 18.6685 15.1393 18.3505 14.9049 18.1161C14.6705 17.8817 14.3525 17.75 14.021 17.75H14.011C13.7642 17.752 13.5235 17.827 13.3193 17.9655C13.115 18.104 12.9564 18.3 12.8633 18.5285C12.7702 18.7571 12.7469 19.0081 12.7963 19.2499C12.8456 19.4917 12.9654 19.7135 13.1406 19.8874C13.3159 20.0612 13.5386 20.1792 13.7808 20.2267C14.023 20.2741 14.2738 20.2488 14.5016 20.1539C14.7295 20.059 14.9241 19.8987 15.061 19.6934C15.1979 19.4881 15.271 19.2468 15.271 19ZM17.96 6.36L16.95 12.54C16.9371 12.9022 16.848 13.2576 16.6885 13.583C16.529 13.9085 16.3027 14.1966 16.0243 14.4288C15.746 14.6609 15.4219 14.8317 15.0731 14.9301C14.7243 15.0286 14.3586 15.0524 14 15H5.73C5.24778 15.0012 4.78146 14.8276 4.41742 14.5113C4.05337 14.1951 3.81626 13.7576 3.75 13.28L2.249 2.832C2.20977 2.53165 2.06223 2.25597 1.83408 2.05673C1.60593 1.85749 1.31289 1.74842 1.01 1.75H0.75C0.551088 1.75 0.360322 1.67098 0.21967 1.53033C0.0790175 1.38967 0 1.19891 0 0.999995C0 0.801083 0.0790175 0.610317 0.21967 0.469665C0.360322 0.329013 0.551088 0.249995 0.75 0.249995H1.01C1.67356 0.245737 2.31594 0.483399 2.81695 0.918513C3.31796 1.35363 3.64326 1.95638 3.732 2.614L3.941 4H16C16.2925 4.00107 16.5812 4.06629 16.8458 4.19107C17.1104 4.31585 17.3444 4.49715 17.5312 4.72218C17.7181 4.94721 17.8534 5.2105 17.9275 5.49348C18.0016 5.77647 18.0127 6.07225 17.96 6.36ZM12.507 7.636C12.4373 7.5663 12.3546 7.51101 12.2636 7.47329C12.1726 7.43557 12.075 7.41616 11.9765 7.41616C11.878 7.41616 11.7804 7.43557 11.6894 7.47329C11.5984 7.51101 11.5157 7.5663 11.446 7.636L9.31 9.772L8.51 8.972C8.36861 8.83531 8.1792 8.75962 7.98255 8.76124C7.7859 8.76285 7.59775 8.84164 7.45863 8.98063C7.31951 9.11962 7.24054 9.3077 7.23874 9.50434C7.23694 9.70099 7.31245 9.89048 7.449 10.032L8.782 11.366C8.92292 11.5063 9.11367 11.585 9.3125 11.585C9.51133 11.585 9.70208 11.5063 9.843 11.366L12.507 8.7C12.5771 8.63029 12.6328 8.5474 12.6708 8.4561C12.7088 8.3648 12.7283 8.26689 12.7283 8.168C12.7283 8.06911 12.7088 7.97119 12.6708 7.87989C12.6328 7.78859 12.5771 7.7057 12.507 7.636Z"
                                                    fill="#0CAF60" />
                                            </svg>
                                            <p>{{ __('Place Order') }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="cart-page-sec pt pb">
    <!-- SVG background -->
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="empty-detail-wrap">
                    <div class="empty-image">

                    </div>
                    <div class="empty-content mt-2">
                        <div class="section-title">
                            <h2>{{__('Category & item Not Found !!')}}.</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection