@php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting();
    $favicon = isset($company_settings['favicon']) ? $company_settings['favicon'] : (isset($admin_settings['favicon']) ? $admin_settings['favicon'] : 'uploads/logo/favicon.png');
    $color = !empty($company_settings['color']) ? $company_settings['color'] : 'theme-1';
      if (isset($company_settings['color_flag']) && $company_settings['color_flag'] == 'true') {
          $themeColor = 'custom-color';
      } else {
          $themeColor = $color;
      }
@endphp
 <?php $lastsegment = request()->segment(count(request()->segments())); ?>
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{company_setting('site_rtl') == 'on'?'rtl':''}}">

<head>
    <title>
        {{ __('POS') }} |
        {{ isset($company_settings['header_text']) && !empty($company_settings['header_text']) ? $company_settings['header_text']->value : config('app.name', 'WorkDo Crm') }}
    </title>
    <meta name="title" content="{{ isset($admin_settings['meta_title']) && !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta name="keywords" content="{{ isset($admin_settings['meta_keywords']) && !empty($admin_settings['meta_keywords']) ? $admin_settings['meta_keywords'] : 'WorkDo Dash,SaaS solution,Multi-workspace' }}">
    <meta name="description" content="{{ isset($admin_settings['meta_description']) && !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ isset($admin_settings['meta_title']) && !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="og:description" content="{{ isset($admin_settings['meta_description']) && !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}} ">
    <meta property="og:image" content="{{ get_file( (isset($admin_settings['meta_image']) && !empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  ) }}{{'?'.time() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ isset($admin_settings['meta_title']) && !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="twitter:description" content="{{ isset($admin_settings['meta_description']) && !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}} ">
    <meta property="twitter:image" content="{{ get_file( (isset($admin_settings['meta_image']) && !empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  ) }}{{'?'.time() }}">

    <meta name="author" content="Workdo.io">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{ check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png') }}{{ '?' . time() }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/site.css') }}" id="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <style>
    @media (min-width:320px) and (max-width:576px){
        .catgory-btns{
            height:55px !important;
        }
        #categories-listing{
            position:relative;
            top:5px;
        }
        
    }
        .category-scroll {
          display: flex;
          flex-wrap: nowrap;
          overflow-x: auto;
          gap: 10px;
          cursor: grab;
          scrollbar-width: none;
          -webkit-overflow-scrolling: touch;
        }
        .category-scroll::-webkit-scrollbar {
          display: none;
        }
        .category-scroll.dragging {
          cursor: grabbing !important;
          user-select: none;
        }




    .default-cart{
        width:70px;
        font-size:5px !important;
    }
        :root {
            --color-customColor: <?= $color ?>;
        }
        .vertical-line {
            width: 2px;
            height: 40px;
            background-color: #6c757d;
        }
         .cat-active .btn{
            background: linear-gradient(90deg, #14C4F6 0%, #0070E2 100%);
            color:white !important;
            border:none !important;
        
        }
        /* Chrome, Safari, Edge, Opera */
        input[type=number][name="quantity"]::-webkit-outer-spin-button,
        input[type=number][name="quantity"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number][name="quantity"] {
            -moz-appearance: textfield;
        }
    </style>
    <style>
@media print {
    #barcode-test-container, 
    #show-barcode-test {
        display: none !important;
    }
    
    /* Also consider hiding other non-essential elements */
    
    .btn-empty {
        display: none !important;
    }
    
}
// Thermal printer CSS
@media print {
    body {
        width: 80mm; 
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        font-size: 12px;
        color: black !important;
        background: none !important;
    }
    
     /*Hide unnecessary elements */
 
    #barcode-test-container, 
    #show-barcode-test,
    .btn-empty,
    .no-print {
        display: none !important;
    }
    
     /*Force black text for thermal printing */
    * {
        color: black !important;
        background: none !important;
    }
    
     /*Optimize tables for receipts */
    table {
        width: 100% !important;
        border-collapse: collapse;
    }
    
    td, th {
        padding: 2px;
        text-align: left;
    }
    
     /*Remove shadows and colors */
    .card, .shadow, [class*="bg-"] {
        box-shadow: none !important;
        background: none !important;
    }
    
     Page breaks 
    .page-break {
        page-break-after: always;
    }
}

/// multi cart
.multi-cart-manager {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;

    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cart-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cart-list {
    max-height: 300px;
    overflow-y: auto;
}

.cart-item {
    width:74px;
    padding: 10px;
    margin-bottom: 5px;
    border-radius: 44px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    border: 1px solid #dee2e6;
    transition: all 0.2s;
}

.cart-item:hover {
    background: #f1f1f1;
}

.cart-item.active {
    background: #e7f5ff;
    border-color: #4dabf7;
}

.cart-item .cart-name {
    width:50px;
    height:50px;
    font-weight: 500;
    flex: 1;
}

.cart-item .cart-info {
    display: flex;
    align-items: center;
}

.cart-item .item-count {
    margin-right: 10px;
    font-size: 0.85rem;
    color: #868e96;
}

.cart-item .subtotal {
    font-weight: 600;
    margin-right: 10px;
}

.cart-actions {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
    margin-top: 10px;
}

#create-new-cart {
    padding: 5px 10px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .multi-cart-manager {
        padding: 10px;
    }
    
    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .cart-item .cart-info {
        width: 100%;
        justify-content: space-between;
        margin-top: 5px;
    }
}


.quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .quantity button {
            background: #f8f9fa;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .quantity button:hover {
            background: #e9ecef;
        }
        
        .quantity button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .quantity input {
            border: none;
            text-align: center;
            width: 60px;
            padding: 8px 4px;
            outline: none;
        }
        
        .quantity input::-webkit-outer-spin-button,
        .quantity input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .quantity input[type=number] {
            -moz-appearance: textfield;
        }
        
        .demo-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        
        .product-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px;
            border: 1px solid #eee;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        
        .product-name {
            flex: 1;
            font-weight: bold;
        }
        
        .subtotal {
            font-weight: bold;
            color: #28a745;
            min-width: 80px;
        }
        
        
///
</style>
    <link rel="stylesheet" href="{{ asset('css/custome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">

    <!--bootstrap switch-->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">

    <!-- vendor css -->
    @if (isset($company_settings['site_rtl']) && $company_settings['site_rtl'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif
    @if (isset($company_settings['cust_darklayout']) && $company_settings['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/workdo/Pos/src/Resources/assets/css/custom.css') }}" id="main-style-link">
    <style>

    </style>
    @stack('css')
</head>

<body class="{{ isset($themeColor) ? $themeColor : 'theme-1' }}">
    <!-- [ Main Content ] start -->
    
    
    <div class="toast" id="toast"></div>
    <div class="container-fluid px-2">
        <?php $lastsegment = request()->segment(count(request()->segments())); ?>
        <div class="row">
            
            <div class="col-12">
                    <!-- TopBar -->
                <!--<nav class=" navbar navbar-expand-lg navbar-light bg-light py-2">-->
                <!--    <div style="padding-left: 5%; padding-right: 5%" class="container-fluid">-->
                <!--        <a class="navbar-brand" href="#">-->
                <!--            <img src="./public/Assest/images/pos-logo.png" alt="Logo" style="height: 40px;">-->
                <!--        </a>-->
            
                        <!-- Toggler -->
                <!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"-->
                <!--            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">-->
                <!--            <span class="navbar-toggler-icon"></span>-->
                <!--        </button>-->
            
                        <!-- Navbar Content -->
                <!--        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">-->
                <!--            <form class="d-flex align-items-center flex-wrap gap-2 mt-2 mt-lg-0">-->
                <!--                <div class="position-relative flex-grow-1">-->
                <!--                    <input class="form-control rounded-pill p-2 search-input" type="search"-->
                <!--                        placeholder="Search Product" aria-label="Search" style="width: 600px;" />-->
                <!--                    <button-->
                <!--                        class="btn search-btn position-absolute end-0 top-50 translate-middle-y me-2 p-0 d-flex align-items-center justify-content-center rounded-pill"-->
                <!--                        style="width: 45px; height: 38px;" type="button">-->
                <!--                        <i class="fas fa-search text-white"></i>-->
                <!--                    </button>-->
                <!--                </div>-->
                <!--                <button style="background-color: #FF2E5F;" class="btn btn-danger rounded-pill px-3 p-2"-->
                <!--                    type="button">-->
                <!--                    Close Register-->
                <!--                </button>-->
                <!--            </form>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</nav>-->

                <div class="navbar navbar-expand-lg navbar-light bg-light py-2 mt-2 pos-top-bar  d-flex align-items-center justify-content-between ">
                    <div class="logo">
                        <a href="https://dev.gsaas.com.au/dashboard" class="b-brand">
                            <img src="/uploads/logo/logo_dark_1753348639.png?1753348654" alt="" style="max-width: 170px">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                            <form class="d-flex align-items-center flex-wrap gap-2 mt-2 mt-lg-0">
                                <div class="position-relative flex-grow-1">
                                   <div class="d-flex align-items-center">
                                        <input class="form-control rounded-pill p-4 search-input" id="searchproduct" type="text" data-url="{{ route('search.products') }}"
                                            placeholder="{{ __('Search Product') }}" type="search"
                                            aria-label="Search" style="width: 600px;" />
                                    
                                        <button  style="background: linear-gradient(90deg, #14C4F6 0%, #0070E2 100%);position:relative;right:20px" type="button" class="btn btn-primary rounded-pill border border-0 ms-n5">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>


                                        
                                    
                                </div>
                                <a href="{{ route('register.index') }}" style="background-color: #FF2E5F;" class="btn btn-danger rounded-pill px-3 p-2"
                                    type="button">
                                    Close Register
                                </a>
                            </form>
                        </div>
                   <!--<div class="d-flex flex-wrap align-items-center justify-content-end gap-2">-->
                   <!--     <div>-->
                   <!--         <a href="{{ route('pos.return.index') }}" class="btn btn-light text-dark">-->
                   <!--             <i class="ti ti-rotate-ccw"></i> Sale Return-->
                   <!--         </a>-->
                   <!--     </div>-->
                   <!--     <div>-->
                   <!--         <a href="{{ route('register.index') }}" class="btn btn-danger ">-->
                   <!--             <i class="ti ti-rotate-ccw"></i> Close Register-->
                   <!--         </a>-->
                   <!--     </div>-->
                   <!--</div>-->
                  
                
                    <!--<a href="{{ route('dashboard') }}" class="text-white"><i class="ti ti-home"-->
                    <!--        style="font-size: 20px;"></i> </a>-->
                </div>
                <div class="multi-cart-manager">
                    <div class="cart-list-header">
                          <div style="padding-left: 5%;">
                            <div class="rounded-layer d-flex flex-wrap gap-2 gap-md-3 align-items-center">
                                <a href="{{ route('pos.return.index') }}" style="background: linear-gradient(90deg, #14C4F6 0%, #0070E2 100%);"
                                    class="btn rounded-pill border-0 text-white px-3">
                                    Sale Return
                                </a>
                                <button id="show-barcode-test" style="background-color: #E0E0E0; color: black;" class="btn rounded-pill border-0 px-3">
                                    <i class="fa-solid fa-qrcode"></i> Scanner
                                </button>
                    
                                <div class="vertical-line d-none d-md-block mx-2"></div>
                    
                                <button class="btn btn-dark rounded-pill border-0 px-3" id="create-new-cart">
                                    <i class="fa-solid fa-bag-shopping"></i> New Cart
                                </button>
                                <span style="display:flex;flex-direction:row;gap:20px" class="cart-list"></span>
                            </div>
                        </div>
                        <!--<button class="btn btn-sm btn-primary" id="create-new-cart">-->
                        <!--    <i class="ti ti-plus"></i> New Cart-->
                        <!--</button>-->
                    </div>
                    
                   
                    
                    <div class="cart-actions">
                        <!--<button class="btn btn-sm btn-outline-secondary rename-cart" disabled>-->
                        <!--    <i class="ti ti-edit"></i> Rename-->
                        <!--</button>-->
                        <!--<button class="btn btn-sm btn-outline-danger delete-cart" disabled>-->
                        <!--    <i class="ti ti-trash"></i> Delete-->
                        <!--</button>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 row row-gap">
            <div class="col-xl-7">
                <div class="sop-card card">
                    <div class="card-body p-2">
                        <div class="right-content">
                            <div class="search-bar-left ">
                                <form>
                                    <div class="input-group bg-white rounded">
                                        
                                    </div>
                                </form>
                            </div>
                            <div class="button-list b-bottom catgory-pad" >
                                <div class="container-fluid rounded  p-md-1 mb-2"
                                    style="background: linear-gradient(90deg, #14C4F6 0%, #0070E2 100%);height:52px">
                        <div class="d-flex flex-wrap form-row gap-2 top-10-scroll m-0" id="categories-listing"  >
                             
                            <!-- First Two Buttons -->
                            

                           

                          

                           
                        </div>
                    </div>
                                <!--<div class="form-row top-10-scroll m-0" id="categories-listing" style="height: 100px" >-->
                                <!--</div>-->
                            </div>
                            <div class="product-body-nop">
                                <div class="form-row" id="product-listing">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 ps-xl-0">
                <div class="card m-0">
                    <div class="card-header p-2">
                        <div class="row row-gap">
                            <div class="col-md-6" >
                                <!-- top-bar -->
                                
                                {{ Form::select('customer_id', $customers,$customer, array('class' => 'btn  dropdown-toggle rounded-pill  border border-3 shadow text-dark w-100 form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                {{ Form::hidden('vc_name_hidden', '',['id' => 'vc_name_hidden']) }}
                            </div>
                            <div class="col-md-6">
                                {{ Form::select('warehouse_id', $warehouses,$warehouseId, array('class' => 'btn  dropdown-toggle rounded-pill shadow  border border-3 text-dark w-100  form-control select warehouse_select ','id'=>'warehouse','required'=>'required')) }}
                                {{ Form::hidden('warehouse_name_hidden', '',['id' => 'warehouse_name_hidden', 'class'=>"dropdown-menu w-100"]) }}
                                {{ Form::hidden('quotation_id', $id,['id' => 'quotation_id' , 'class'=>"quotation"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body carttable cart-product-list carttable-scroll p-1" id="carthtml">

                        @php $total = 0 @endphp

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-left">{{ __('Name') }}</th>
                                        <th class="text-center">{{ __('QTY') }}</th>
                                        <th>{{ 'Tax' }}</th>
                                        <th class="text-center">{{ __('Price') }}</th>
                                        <th class="text-center">{{ __('Sub Total') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @if (module_is_active('ProductService'))
                                    <tbody id="tbody">
                                        @php
                                                $ids = \App\Models\WarehouseProduct::All()->pluck('product_id')->toArray();
                                        @endphp
                                        @if (session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                            @foreach (session($lastsegment) as $id => $details)
                                            @if (in_array($details['id'], $ids))
                                                @php

                                                    $product = \workdo\ProductService\Entities\ProductService::find($details['id']);
                                                    $image_url = !empty($product) && check_file($product->image) && get_file($product->image) ? $product->image : asset('packages/workdo/ProductService/src/Resources/assets/image/img01.jpg');
                                                    $total += $details['subtotal'];
                                                @endphp

                                                <tr data-product-id="{{ $id }}" id="product-id-{{ $id }}">
                                                    <td class="cart-images">
                                                        <img alt="Image placeholder" src="{{ get_file($image_url) }}"
                                                            class="card-image avatar rounded-circle-sale shadow hover-shadow-lg">
                                                    </td>
                                                    <td class="name">{{ $details['name'] }}</td>
                                                    <td>
                                                        <span class="quantity buttons_added">
                                                                <button class="minus">
                                                                    <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-518.000000, -1089.000000)" fill="#000000">
                                                                                <path d="M540,1106 L528,1106 C527.447,1106 527,1105.55 527,1105 C527,1104.45 527.447,1104 528,1104 L540,1104 C540.553,1104 541,1104.45 541,1105 C541,1105.55 540.553,1106 540,1106 L540,1106 Z M534,1089 C525.163,1089 518,1096.16 518,1105 C518,1113.84 525.163,1121 534,1121 C542.837,1121 550,1113.84 550,1105 C550,1096.16 542.837,1089 534,1089 L534,1089 Z" id="minus-circle" sketch:type="MSShapeGroup">
                                                                            </path>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                </button>                                                            <input type="text" step="1" name="quantity"
                                                                title="{{ __('Quantity') }}" class="input-number"
                                                                data-url="{{ url('update-cart/') }}"
                                                                data-id="{{ $id }}" min="1"
                                                                max="10000"
                                                                value="{{ $details['quantity'] }}">
                                                                <button class="plus">
                                                                    <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-466.000000, -1089.000000)" fill="#000000">
                                                                                <path d="M488,1106 L483,1106 L483,1111 C483,1111.55 482.553,1112 482,1112 C481.447,1112 481,1111.55 481,1111 L481,1106 L476,1106 C475.447,1106 475,1105.55 475,1105 C475,1104.45 475.447,1104 476,1104 L481,1104 L481,1099 C481,1098.45 481.447,1098 482,1098 C482.553,1098 483,1098.45 483,1099 L483,1104 L488,1104 C488.553,1104 489,1104.45 489,1105 C489,1105.55 488.553,1106 488,1106 L488,1106 Z M482,1089 C473.163,1089 466,1096.16 466,1105 C466,1113.84 473.163,1121 482,1121 C490.837,1121 498,1113.84 498,1105 C498,1096.16 490.837,1089 482,1089 L482,1089 Z" id="plus-circle" sketch:type="MSShapeGroup">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                </button>                                                        </span>
                                                    </td>

                                                    <td>
                                                        @if (!empty($product->tax_id))
                                                            @php
                                                                $taxes = \workdo\Pos\Entities\Pos::tax($product->tax_id);
                                                            @endphp

                                                            @foreach ($taxes as $tax)
                                                                <span
                                                                    class="badge bg-primary">{{ $tax->name . ' (' . $tax->rate . '%)' }}</span>
                                                                <br>
                                                            @endforeach
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="price text-right">
                                                        {{ currency_format_with_sym($details['price']) }}</td>
                                                    <td class="col-sm-3 mt-2">
                                                        <span
                                                            class="subtotal">{{ currency_format_with_sym($details['subtotal']) }}</span>
                                                    </td>
                                                    <td class="col-sm-2 mt-2">
                                                        <a href="#"
                                                            class="action-btn  show_confirm-pos"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $id }}"
                                                            title="{{ __('Delete') }}"
                                                            data-id="{{ $id }}">
                                                            <i class="ti ti-trash bg-danger text-white mx-3 btn btn-sm"
                                                                title="{{ __('Delete') }}"></i>
                                                        </a>
                                                        {!! Form::open(['method' => 'delete', 'url' => ['remove-from-cart'], 'id' => 'delete-form-' . $id]) !!}
                                                        <input type="hidden" name="session_key"
                                                            value="{{ $lastsegment }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $id }}">
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endif
                                            @endforeach
                                        @else
                                            <tr class="text-center no-found">
                                                <td colspan="7">{{ __('No Data Found.!') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <div style="position:relative;bottom:80px" class="total-section" @if(isset($company_settings['site_rtl']) && $company_settings['site_rtl'] == 'on') style="background: #0000" @endif>
                            <div class="sub-total">
                                <div class="row row-gap align-items-center">
                                    <div class="col-sm-6">
                                        <div class="d-flex text-end justify-content-end align-items-center">
                                            <div class="input-group">
                                                <span class="input-group-text g-1 bg-transparent currency-symbol rounded-start">{{__('Discount')}}</span>
                                                {{ Form::number('discount', number_format($bill->discount ?? 0, 2, '.', ''), [
                                                    'class' => 'form-control discount rounded-end',
                                                    'required' => 'required',
                                                    'placeholder' => __('Discount'),
                                                    'readonly' => 'readonly',
                                                    'step' => '0.01',
                                                ]) }}
                                                
                                                {{ Form::hidden('discount_hidden', number_format($bill->discount ?? 0, 2, '.', ''), ['id' => 'discount_hidden']) }}
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex text-end justify-content-end mb-2">
                                            <h6 class="mb-0 text-dark">{{ __('Sub Total') }} :</h6>
                                            <h6 class="mb-0 text-gray-800 totalamount" >
                                                {{ currency_format_with_sym($total) }}</h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <h6 class="mb-0">{{ __('Total') }} :</h6>
                                            <h6 class="mb-0 totalamount">{{ currency_format_with_sym($total) }}</h6>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-3 gap-2" id="btn-pur">
                                    @if (module_is_active('ProductService'))
                                        <button style="background: linear-gradient(90deg, #14C4F6 0%, #0070E2 100%);" type="button" class="btn btn-primary border border-0 pay-btn m-0" data-ajax-popup="true"
                                            data-size="lg" data-align="centered"
                                            data-url="{{ route('pos.create') }}"
                                            data-title="{{ __('POS Invoice') }}"
                                            @if (session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else  @endif>
                                            {{ __('PAY') }}
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary" data-ajax-popup="true"
                                            data-size="lg" data-align="centered"
                                            data-url="{{ route('pos.create') }}"
                                            data-title="{{ __('POS Invoice') }}" >
                                            {{ __('PAY') }}
                                        </button>
                                    @endif
                                    <div class="tab-content btn-empty text-end">
                                        <!--<a href="/empty-cart" class="btn btn-danger  m-0"-->
                                            
                                        <!--    @if (session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else style="pointer-events: none; cursor: default; opacity: 0.65;" @endif>-->
                                        <!--    {{ __('Empty Cart') }}-->
                                        <!--</a>-->
                                        {!! Form::open(['method' => 'post', 'url' => ['empty-cart'], 'id' => 'delete-form-emptycart']) !!}
                                        <input type="hidden" name="session_key" value="{{ $lastsegment }}"
                                            id="empty_cart">

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ isset($company_settings['pos_logo']) ? $company_settings['pos_logo'] : 'https://dev.gsaas.com.au/uploads/logo/logo_dark_1753348639.png?1753348654' }}" style="width:130px;margin:auto;" />

                  
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="reload_page" aria-label="Close" style="margin:0px !important;position:absolute;top:10px;right:10px;"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
        <div id="liveToast" class="toast text-white  fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        
    </div>

    <!-- Required Js -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/dash.js') }}"></script>
    <script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/moment.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>



    <script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/jscolor.js') }}"></script>
    <script src="{{ asset('packages/workdo/Pos/src/Resources/assets/js/custom.js') }}"></script>

    @if ($message = Session::get('success'))
        <script>
            show_toastr('success', '{!! $message !!}');
        </script>
    @endif
    @if ($message = Session::get('error'))
        <script>
            show_toastr('error', '{!! $message !!}');
        </script>
    @endif
    @if(isset($admin_settings['enable_cookie']) && $admin_settings['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
    @stack('scripts')

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {

            $("#vc_name_hidden").val($('.customer_select').val());
            $("#warehouse_name_hidden").val($('.warehouse_select').val());
            $("#discount_hidden").val($('.discount').val());
            $( "#quotation_id").val($('.quotation').val());

            $(function() {
                getProductCategories();

            });

            if ($('#searchproduct').length > 0) {
                console.log("search change");
                var url = $('#searchproduct').data('url');
                var ware_id = $("#warehouse").val();
                var cat = $(this).data('cat-id');
                      
                searchProducts(url, '', cat, ware_id);
            }

            $('#warehouse').change(function() {
                var ware_id = $("#warehouse").val();
                searchProducts(url, '', '0', ware_id);
            });

            $('.customer_select').change(function() {
                $("#vc_name_hidden").val($(this).val());
            });
            $('.warehouse_select').change(function() {
                $("#warehouse_name_hidden").val($(this).val());

                var session_key = $("#empty_cart").val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('warehouse-empty-cart') }}',
                    data: {
                        'session_key': session_key
                    },
                    success: function(data) {
                        $("#tbody").empty();
                        $('.pay-btn').attr('disabled','disabled');
                        $('#btn-pur .btn-empty a').attr('style','pointer-events: none; cursor: default; opacity: 0.65;');
                        $("#tbody").html(
                            '<tr class="text-center no-found"><td colspan="7">{{ __('No Data Found.!') }}</td></tr>'
                            );

                    }
                });
            });

            $(document).on('click', '#clearinput', function(e) {
                var IDs = [];
                $(this).closest('div').find("input").each(function() {
                    IDs.push('#' + this.id);
                });
                $(IDs.toString()).val('');
            });

            $(document).on('keyup', 'input#searchproduct', function() {
                var url = $(this).data('url');
                var value = this.value;
                var cat = $('.cat-active').children().data('cat-id');
                searchProducts(url, value, cat);
            });


            function searchProducts(url, value, cat_id, war_id = '0') {
                console.log("hello G",value);
                 war_id = $("#warehouse").val();
                if (value === '') {
                     war_id = $("#warehouse").val();
                    
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'search': value,
                        'cat_id': cat_id,
                        'war_id': war_id,
                        'session_key': '{{ $lastsegment}}'

                    },
                    success: function(data) {
                        $("#product-listing").empty();
                        $('#product-listing').html(data);
                    }
                });
            }

            function getProductCategories() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('product.categories') }}',
                    success: function(data) {

                        $('#categories-listing').html(data);
                    }
                });
            }

            $(document).on('click', '.toacart', function() {
                var sum = 0;
                var totalDiscount = 0;
                  let original_price = 0; 
                 
                $.ajax({
                    url: $(this).data('url'),

                    success: function(data) {
                        if (data.code == '200') {
                            console.log("dato",data);
                            //  window.multiCartManager.refreshCurrentCart();
                            $('#displaytotal').text(data.totalWithoutDiscount);
                            $('.totalamount').text(addCommas(data.product.subtotal));
                            $('.discount').val(parseFloat(data.product.total_discount).toFixed(2));
                            console.log(data.product.total_discount);
                            if ('carttotal' in data) {
                                $.each(data.carttotal, function(key, value) {
                                    $('#product-id-' + value.id + ' .subtotal').text(
                                        addCommas(value.subtotal));
                                    sum += value.subtotal +totalDiscount;
                                });
                                $.each(data.carttotal, function(key, value) {
                                    $('.total_discount').text(
                                        addCommas(parseFloat(value.total_discount).toFixed(2))
                                    );
                                    totalDiscount += value.total_discount;
                                    
                                });
                              $.each(data.carttotal, function (key, value) {
                                let price = parseFloat(value.price) || 0;
                                original_price += price;
                                });
                                $('#displaytotal').text(data.totalWithoutDiscount);
                                $('.totalamount').text(addCommas(sum));
                                $('.discount').val(totalDiscount);
                            }

                            $('#tbody').append(data.carthtml);
                            $('.no-found').addClass('d-none');
                            $('.carttable #product-id-' + data.product.id +
                                ' input[name="quantity"]').val(data.product.quantity);
                            $('#btn-pur button').removeAttr('disabled');
                            $('#btn-pur .btn-empty a').removeAttr('style');
                            $('.btn-empty button').addClass('btn-clear-cart');
                        }
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            });

            $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
            e.preventDefault();
            var ele = $(this);
            var sum = 0;
            var quantity = ele.closest('span').find('input[name="quantity"]').val();
            var discount = $('.discount').val();
            var session_key = $('#empty_cart').val();

            if(quantity != "" && quantity != 0){
                $.ajax({
                    url: ele.data('url'),
                    method: "patch",
                    data: {
                        id: ele.attr("data-id"),
                        quantity: quantity,
                        discount:discount,
                        session_key: session_key
                    },
                    success: function (data) {

                        if (data.code == '200') {
            
                            if (quantity == 0) {
                                ele.closest(".row").hide(250, function () {
                                    ele.closest(".row").remove();
                                });
                                if (ele.closest(".row").is(":last-child")) {
                                    $('#btn-pur button').attr('disabled', 'disabled');
                                    $('.btn-empty button').removeClass('btn-clear-cart');
                                }
                            }
                              
                            $.each(data.product, function (key, value) {
                                sum += value.subtotal;
                                $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                            });
                            $('.discount').val(data.productDiscountTotal);
                            $('#displaytotal').text(data.totalWithoutDiscount);
                            $('.totalamount').text(addCommas(sum));
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            }


        });

            $(document).on('click', '.remove-from-cart', function(e) {
                e.preventDefault();
                var ele = $(this);
                var sum = 0;

                if (confirm('{{ __('Are you sure?') }}')) {
                    ele.closest(".row").hide(250, function() {
                        ele.closest(".row").parent().parent().remove();
                    });
                    if (ele.closest(".row").is(":last-child")) {
                        $('#btn-pur button').attr('disabled', 'disabled');
                        $('.btn-empty button').removeClass('btn-clear-cart');
                    }
                    $.ajax({
                        url: ele.data('url'),
                        method: "DELETE",
                        data: {
                            id: ele.attr("data-id"),
                        },
                        success: function(data) {
                            if (data.code == '200') {

                                $.each(data.product, function(key, value) {
                                    sum += value.subtotal;
                                    $('#product-id-' + value.id + ' .subtotal').text(
                                        addCommas(value.subtotal));
                                });

                                $('#displaytotal').text(addCommas(sum));

                                toastrs('Success', data.success, 'success')
                            }
                        },
                        error: function(data) {
                            data = data.responseJSON;
                            show_toastr('{{ __('Error') }}', data.error, 'error');
                        }
                    });
                }
            });
            $(document).on('click', '.btn-clear-cart', function(e) {
                e.preventDefault();

                if (confirm('{{ __('Remove all items from cart?') }}')) {

                    $.ajax({
                        url: $(this).data('url'),
                        data: {
                            session_key: session_key
                        },
                        success: function(data) {
                            location.reload();
                        },
                        error: function(data) {
                            data = data.responseJSON;
                            show_toastr('{{ __('Error') }}', data.error, 'error');
                        }
                    });
                }
            });
            $(document).on('click', '.btn-done-payment', function(e) {
                e.preventDefault();
                var ele = $(this);

                $.ajax({
                    url: ele.data('url'),

                    method: 'GET',
                    data: {
                        vc_name: $('#vc_name_hidden').val(),
                        warehouse_name: $('#warehouse_name_hidden').val(),
                        discount: $('#discount_hidden').val(),
                        quotation_id : $('#quotation_id').val(),

                    },
                    beforeSend: function() {
                        ele.remove();
                    },
                    success: function(data) {
                        // return false;
                        if (data.code == 200) {
                            show_toastr('Success', data.success, 'success');
                        }
                        // setTimeout(function() {
                        //     window.location.reload();
                        // }, 1000);
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }

                });

            });
            $(document).on('click', '#reload_page', function(e) {
                e.preventDefault();

                var ele = $(this);
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }, );

            $(document).on('click', '.category-select', function(e) {
                var cat = $(this).data('cat-id');
                var white = 'text-white';
                var dark = 'text-dark';
                $('.category-select').parent().removeClass('cat-active');
                $('.category-select').children().removeClass('btn-primary');
                $(this).children().addClass('btn-primary');
                $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
                $('.category-select').find('.card-title').parent().removeClass('text-white').addClass('text-dark');
                $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
                $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
                $(this).parent().addClass('cat-active');
                var url = '{{ route('search.products') }}'
                var ware_id = $("#warehouse").val();
                searchProducts(url, '', cat, ware_id);


            });

            $(document).on('keyup', '.discount', function () {
                var discount = $('.discount').val();
                var total = $('#displaytotal').html().replace(/[^0-9.]/gi, ''); // Assuming the displaytotal element contains the total amount

                $("#discount_hidden").val(discount);

                $.ajax({
                    url: "{{ route('cartdiscount') }}",
                    method: 'POST',
                    data: {
                        discount: discount,
                    },
                    success: function (data) {

                        if (parseFloat(discount) <= parseFloat(total) || discount == null || discount == '') {
                            $('.totalamount').text(data.total);
                        } else {
                          
                            $('.totalamount').text(addCommas(0));
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __('Error') }}', data.error, 'error');
                    }
                });
            });
        });
    </script>
    
    
    <script>
    // Enhanced Barcode Scanner Implementation for POS System
    class BarcodeScanner {
        constructor(options = {}) {
        // Configuration options with improved timing
        this.config = {
            minBarcodeLength: options.minBarcodeLength || 3,
            maxBarcodeLength: options.maxBarcodeLength || 50,
            scanTimeout: options.scanTimeout || 150, // Increased from 50ms to 150ms
            interCharTimeout: options.interCharTimeout || 30, // Time between characters during scan
            endScanDelay: options.endScanDelay || 200, // Wait time after last character before processing
            apiEndpoint: options.apiEndpoint || '/pos/scan-barcode',
            enableSounds: options.enableSounds !== false,
            enableTestMode: options.enableTestMode !== false,
            debounceDelay: options.debounceDelay || 100,
            ...options
        };

        // State management
        this.state = {
            buffer: '',
            lastKeyTime: Date.now(),
            isScanning: false,
            isProcessing: false,
            scanCount: 0,
            lastProcessedBarcode: '',
            lastProcessedTime: 0,
            scanStartTime: 0,
            endScanTimer: null
        };

        // Bind methods to maintain context
        this.handleKeyInput = this.handleKeyInput.bind(this);
        this.processBarcode = this.debounce(this.processBarcode.bind(this), this.config.debounceDelay);
        this.endScanTimeout = this.endScanTimeout.bind(this);
        
        this.init();
    }

    init() {
        try {
            // Listen for keydown events globally
            document.addEventListener('keydown', this.handleKeyInput, { passive: false });
            
            // Create visual indicators
            this.createScanIndicator();
            this.createScanStats();
            
            // Initialize test mode if enabled
            if (this.config.enableTestMode) {
                this.createTestInterface();
            }
            
            // Add cleanup on page unload
            window.addEventListener('beforeunload', () => this.cleanup());
          
        } catch (error) {
            console.error('Failed to initialize barcode scanner:', error);
        }
    }

    handleKeyInput(e) {
        // Skip if currently processing
        if (this.state.isProcessing) {
            return;
        }

        const currentTime = Date.now();
        const timeDiff = currentTime - this.state.lastKeyTime;

        // Ignore if user is typing in specific input fields
        if (this.shouldIgnoreInput()) {
            return;
        }

        // Handle Enter key (barcode scanners usually end with Enter)
        if (e.key === 'Enter') {
            if (this.state.buffer.length >= this.config.minBarcodeLength) {
                e.preventDefault();
                this.clearEndScanTimer();
                this.processBarcodeInput();
                return;
            }
        }

        // Handle Escape key to reset
        if (e.key === 'Escape') {
            this.resetBuffer();
            return;
        }

        // Handle regular characters
        if (this.isValidCharacter(e)) {
            // Prevent default to avoid interference
            if (this.state.isScanning || this.detectRapidInput(timeDiff)) {
                e.preventDefault();
            }

            // Check if this is start of a new scan
            if (timeDiff > this.config.scanTimeout && this.state.buffer.length > 0) {
                // Previous scan timed out, start fresh
                this.resetBuffer();
                this.state.scanStartTime = currentTime;
            }

            // Initialize scan if this is the first character
            if (this.state.buffer.length === 0) {
                this.state.scanStartTime = currentTime;
                this.state.isScanning = true;
                this.showScanIndicator();
                // console.log('Barcode scan started');
            }
            
            // Add character to buffer
            this.state.buffer += e.key;
            this.state.lastKeyTime = currentTime;

            // Update scan stats
            this.updateScanStats();

            // Clear any existing end scan timer
            this.clearEndScanTimer();

            // Set new end scan timer
            this.state.endScanTimer = setTimeout(this.endScanTimeout, this.config.endScanDelay);

            // Auto-process if buffer gets too long (safety measure)
            if (this.state.buffer.length > this.config.maxBarcodeLength) {
                this.clearEndScanTimer();
                this.processBarcodeInput();
            }

            // console.log(`Buffer: "${this.state.buffer}" (${this.state.buffer.length} chars)`);
        }
    }

    detectRapidInput(timeDiff) {
        // Consider it rapid input if characters come within interCharTimeout
        return timeDiff < this.config.interCharTimeout && timeDiff > 0;
    }

    endScanTimeout() {
        // console.log(`Scan timeout reached. Buffer: "${this.state.buffer}"`);
        if (this.state.buffer.length >= this.config.minBarcodeLength) {
            this.processBarcodeInput();
        } else {
            this.resetBuffer();
        }
    }

    clearEndScanTimer() {
        if (this.state.endScanTimer) {
            clearTimeout(this.state.endScanTimer);
            this.state.endScanTimer = null;
        }
    }

    shouldIgnoreInput() {
        const activeElement = document.activeElement;
        if (!activeElement) return false;

        const tagName = activeElement.tagName.toLowerCase();
        const inputTypes = ['input', 'textarea', 'select'];
        
        // Allow scanning in search fields
        const allowedIds = ['searchproduct', 'search_product', 'product_search'];
        if (allowedIds.includes(activeElement.id)) {
            return false;
        }

        return inputTypes.includes(tagName) || 
               activeElement.contentEditable === 'true' ||
               activeElement.hasAttribute('data-barcode-ignore');
    }

    isValidCharacter(e) {
        // Allow alphanumeric characters, hyphens, and underscores commonly found in barcodes
        const validChars = /^[a-zA-Z0-9\-_]$/;
        return e.key.length === 1 && 
               validChars.test(e.key) &&
               !e.ctrlKey && 
               !e.altKey && 
               !e.metaKey;
    }

    processBarcodeInput() {
        const barcode = this.state.buffer.trim();
        const scanDuration = Date.now() - this.state.scanStartTime;
        
        // console.log(`Processing barcode: "${barcode}" (${barcode.length} chars, ${scanDuration}ms duration)`);
        
        if (barcode.length >= this.config.minBarcodeLength) {
            this.processBarcode(barcode);
        } else {
            console.log(`Barcode too short: "${barcode}" (${barcode.length} chars)`);
        }
        this.resetBuffer();
    }

    resetBuffer() {
        // console.log(`Resetting buffer. Previous: "${this.state.buffer}"`);
        this.state.buffer = '';
        this.state.isScanning = false;
        this.state.scanStartTime = 0;
        this.clearEndScanTimer();
        this.hideScanIndicator();
    }

    // Debounce function to prevent multiple rapid calls
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    async processBarcode(barcode) {
        // Prevent duplicate processing
        if (this.state.isProcessing) return;
        
        // Check for duplicate scan within 2 seconds
        const now = Date.now();
        if (this.state.lastProcessedBarcode === barcode && 
            (now - this.state.lastProcessedTime) < 2000) {
            this.showScanResult('Duplicate scan ignored', 'warning');
            return;
        }

        this.state.isProcessing = true;
        this.state.lastProcessedBarcode = barcode;
        this.state.lastProcessedTime = now;
        this.state.scanCount++;

        // console.log('Processing barcode:', barcode);
        
        // Show processing state with yellow indicator
        this.showProcessingIndicator();
        
        try {
            const response = await this.makeAjaxRequest(barcode);
            this.handleScanResponse(response, barcode);
        } catch (error) {
            this.handleScanError(error, barcode);
        } finally {
            this.state.isProcessing = false;
            this.hideScanIndicator();
        }
    }

    makeAjaxRequest(barcode) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: this.config.apiEndpoint,
                method: 'POST',
                timeout: 10000, // 10 second timeout
                data: {
                    sku: barcode,
                    session_key: this.getSessionKey(),
                    warehouse_id: this.getWarehouseId(),
                    _token: this.getCsrfToken()
                },
                success: resolve,
                error: reject
            });
        });
    }

    getSessionKey() {
        return $('#empty_cart').val() || 
               $('input[name="session_key"]').val() || 
               'pos';
    }

    getWarehouseId() {
        return $('#warehouse').val() || 
               $('select[name="warehouse_id"]').val() || 
               1;
    }

    getCsrfToken() {
        return $('meta[name="csrf-token"]').attr('content') || 
               $('input[name="_token"]').val();
    }

    handleScanResponse(data, barcode) {
        if (data.code === 200 || data.code === '200') {
            this.handleSuccessfulScan(data);
        } else {
            const message = data.message || `Product not found: ${barcode}`;
            this.showScanResult(message, 'error');
            this.playErrorSound();
        }
    }

    handleScanError(xhr, barcode) {
        let errorMessage = 'Error scanning barcode';
        
        if (xhr.responseJSON) {
            errorMessage = xhr.responseJSON.message || xhr.responseJSON.error || errorMessage;
        } else if (xhr.statusText) {
            errorMessage = `Network error: ${xhr.statusText}`;
        }
        
        this.showScanResult(errorMessage, 'error');
        this.playErrorSound();
        // console.error('Barcode scan error:', xhr);
    }

    handleSuccessfulScan(data) {
        try {
            if (!data.product) {
                throw new Error('No product data received');
            }

            // Update cart display
            this.updateCartDisplay(data);
            
            // Update totals
            this.updateTotals(data);
            
            // Handle new product HTML
            if (data.carthtml) {
                this.addProductToCartTable(data.carthtml);
            }
            
            // Update existing product quantity
            this.updateProductQuantity(data.product);
            
            // Enable purchase buttons
            this.enablePurchaseButtons();
            
            // Show success message
            const message = data.success || `Product added: ${data.product.name}`;
            this.showScanResult(message, 'success');
            this.playSuccessSound();
            
        } catch (error) {
            // console.error('Error handling successful scan:', error);
            this.showScanResult('Error updating cart display', 'error');
        }
    }

    updateCartDisplay(data) {
        if (data.carttotal) {
            let totalSum = 0;
            let totalDiscount = 0;

            // Update individual product subtotals
            $.each(data.carttotal, (key, product) => {
                const productRow = $(`#product-id-${product.id}`);
                if (productRow.length) {
                    productRow.find('.subtotal').text(this.formatCurrency(product.subtotal));
                    productRow.find('input[name="quantity"]').val(product.quantity);
                }
                totalSum += parseFloat(product.subtotal) || 0;
                totalDiscount += parseFloat(product.total_discount) || 0;
            });

            // Update main totals
            // $('.totalamount').text(this.formatCurrency(totalSum));
            // $('.discount').val(totalDiscount);
        }
    }

    updateTotals(data) {
        var sum = 0;
        var totalDiscount = 0;
        let original_price = 0;
        if (data.totalWithoutDiscount) {
            $('#displaytotal').text(data.totalWithoutDiscount);
        }
        if (data.code == '200') {
                $('#displaytotal').text(data.totalWithoutDiscount);
                $('.totalamount').text(addCommas(data.product.subtotal));
                $('.discount').val(data.product.total_discount);
                    if ('carttotal' in data) {
                        $.each(data.carttotal, function(key, value) {
                            $('#product-id-' + value.id + ' .subtotal').text(
                                addCommas(value.subtotal));
                            sum += value.subtotal +totalDiscount;
                            
                        });
                         $.each(data.carttotal, function(key, value) {
                            $('.total_discount').text(
                                addCommas(value.total_discount));
                            totalDiscount += value.total_discount;
                            
                        });
                        $.each(data.carttotal, function (key, value) {
                            let price = parseFloat(value.price) || 0;
                            original_price += price;
                        });
                        $('#displaytotal').text(data.totalWithoutDiscount);
                        $('.totalamount').text(addCommas(sum));
                        $('.discount').val(totalDiscount);
                    }
        }
    }

    addProductToCartTable(carthtml) {
        const tbody = $('#tbody, .cart-tbody, table tbody').first();
        if (tbody.length) {
            tbody.append(carthtml);
            $('.no-found, .empty-cart-message').addClass('d-none');
        }
    }

    updateProductQuantity(product) {
        const quantityInput = $(`.carttable #product-id-${product.id} input[name="quantity"], 
                               #product-id-${product.id} input[name="quantity"]`);
        if (quantityInput.length) {
            quantityInput.val(product.quantity);
        }
    }

    enablePurchaseButtons() {
        $('#btn-pur button, .purchase-btn').removeAttr('disabled');
        $('#btn-pur .btn-empty a, .empty-cart-btn').removeAttr('style');
    }

    formatCurrency(amount) {
        // Use existing currency formatting if available
        if (typeof addCommas === 'function') {
            return addCommas(amount);
        }
        
        // Fallback formatting
        return parseFloat(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    createScanIndicator() {
        if (document.getElementById('barcode-scan-indicator')) return;

        const indicator = document.createElement('div');
        indicator.id = 'barcode-scan-indicator';
        indicator.innerHTML = `
            <div class="scan-indicator-content">
                <i class="ti ti-scan" style="font-size: 20px;"></i>
                <span>Scanning...</span>
                <div class="scan-progress"></div>
                <div class="buffer-display" style="font-size: 11px; margin-top: 4px; opacity: 0.8;"></div>
            </div>
        `;
        
        // Enhanced styling with green success color
        indicator.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            z-index: 9999;
            display: none;
            box-shadow: 0 4px 12px rgba(40,167,69,0.4);
            border: 1px solid rgba(255,255,255,0.2);
            min-width: 200px;
        `;
        
        document.body.appendChild(indicator);
        this.addScanIndicatorStyles();
    }

    createScanStats() {
        if (document.getElementById('barcode-scan-stats')) return;

        const stats = document.createElement('div');
        stats.id = 'barcode-scan-stats';
        stats.innerHTML = `
            <div class="scan-stats-content">
                <small>Scans: <span id="scan-count">0</span></small>
                <small>Buffer: <span id="buffer-length">0</span></small>
                <small>Duration: <span id="scan-duration">0ms</span></small>
            </div>
        `;
        
        stats.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            z-index: 9998;
            font-size: 11px;
            display: none;
        `;
        
        document.body.appendChild(stats);
    }

    addScanIndicatorStyles() {
        if (document.getElementById('barcode-scanner-styles')) return;

        const style = document.createElement('style');
        style.id = 'barcode-scanner-styles';
        style.textContent = `
            @keyframes scannerPulse {
                0% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.9; transform: scale(1.02); }
                100% { opacity: 1; transform: scale(1); }
            }
            
            #barcode-scan-indicator {
                animation: scannerPulse 1s ease-in-out infinite;
                transition: all 0.3s ease;
            }
            
            #barcode-scan-indicator.scanning {
                background: linear-gradient(135deg, #28a745, #1e7e34) !important;
                box-shadow: 0 4px 12px rgba(40,167,69,0.4) !important;
            }
            
            #barcode-scan-indicator.processing {
                background: linear-gradient(135deg, #ffc107, #e0a800) !important;
                box-shadow: 0 4px 12px rgba(255,193,7,0.4) !important;
            }
            
            .scan-progress {
                height: 2px;
                background: rgba(255,255,255,0.3);
                margin-top: 8px;
                border-radius: 1px;
                overflow: hidden;
            }
            
            .scan-progress::after {
                content: '';
                display: block;
                height: 100%;
                background: white;
                width: 0%;
                animation: progressBar 2s infinite;
            }
            
            @keyframes progressBar {
                0% { width: 0%; }
                100% { width: 100%; }
            }
            
            .buffer-display {
                font-family: monospace;
                background: rgba(255,255,255,0.1);
                padding: 2px 4px;
                border-radius: 2px;
            }
        `;
        document.head.appendChild(style);
    }

    updateScanStats() {
        const scanCount = document.getElementById('scan-count');
        const bufferLength = document.getElementById('buffer-length');
        const scanDuration = document.getElementById('scan-duration');
        
        if (scanCount) scanCount.textContent = this.state.scanCount;
        if (bufferLength) bufferLength.textContent = this.state.buffer.length;
        if (scanDuration && this.state.scanStartTime > 0) {
            const duration = Date.now() - this.state.scanStartTime;
            scanDuration.textContent = `${duration}ms`;
        }
        
        // Update buffer display in indicator
        const bufferDisplay = document.querySelector('.buffer-display');
        if (bufferDisplay && this.state.isScanning) {
            bufferDisplay.textContent = `"${this.state.buffer}"`;
        }
        
        // Show stats during scanning
        const stats = document.getElementById('barcode-scan-stats');
        if (stats && this.state.isScanning) {
            stats.style.display = 'block';
        }
    }

    showScanIndicator() {
        const indicator = document.getElementById('barcode-scan-indicator');
        if (indicator) {
            indicator.style.display = 'block';
            indicator.className = 'scanning'; // Add scanning class for green color
        }
    }

    hideScanIndicator() {
        const indicator = document.getElementById('barcode-scan-indicator');
        const stats = document.getElementById('barcode-scan-stats');
        
        if (indicator) {
            indicator.style.display = 'none';
            indicator.className = ''; // Remove classes
        }
        if (stats) stats.style.display = 'none';
    }

    showProcessingIndicator() {
        const indicator = document.getElementById('barcode-scan-indicator');
        if (indicator) {
            indicator.style.display = 'block';
            indicator.className = 'processing'; // Add processing class for yellow color
            const content = indicator.querySelector('.scan-indicator-content span');
            if (content) content.textContent = 'Processing...';
        }
    }

    
    showScanResult(message, type) {
    // Get the toast element
     const toastEl = document.getElementById('liveToast');
    if (!toastEl) {
        console.error('Toast element not found');
        return;
    }

    // Remove all existing color classes
    const colorClasses = ['bg-success', 'bg-danger', 'bg-warning', 'bg-info'];
    toastEl.classList.remove(...colorClasses);

    // Add the appropriate color class based on type
    const colorClass = 
        type === 'success' ? 'bg-success' :
        type === 'error' ? 'bg-danger' :
        type === 'warning' ? 'bg-warning' : 'bg-info';
    
    toastEl.classList.add(colorClass);

    // Set the message
    const toastBody = toastEl.querySelector('.toast-body');
    if (toastBody) {
        toastBody.textContent = message;
    }

    // Initialize and show the toast if using Bootstrap 5
    if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    } else {
        // Fallback for non-Bootstrap environments
        $(toastEl).toast('show');
    }
}
    showFallbackNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `scan-notification scan-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            border-radius: 6px;
            z-index: 10000;
            font-weight: 500;
            background: ${type === 'success' ? '#28a745' : 
                        type === 'warning' ? '#ffc107' : 
                        type === 'info' ? '#17a2b8' : '#dc3545'};
            color: ${type === 'warning' ? '#212529' : 'white'};
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    playSuccessSound() {
        if (!this.config.enableSounds) return;
        
        try {
            // Simple success beep
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            oscillator.frequency.setValueAtTime(1000, audioContext.currentTime + 0.1);
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.2);
        } catch (e) {
            console.log('Audio not supported');
        }
    }

    playErrorSound() {
        if (!this.config.enableSounds) return;
        
        try {
            // Simple error beep
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(300, audioContext.currentTime);
            oscillator.frequency.setValueAtTime(200, audioContext.currentTime + 0.15);
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        } catch (e) {
            console.log('Audio not supported');
        }
    }

    createTestInterface() {
        if (document.getElementById('barcode-test-container')) return;

        const testHtml = `
            <div id="barcode-test-container" style="position: absolute; top: 62px; left: 200px; background: white; padding: 15px; border: 2px solid #007bff; border-radius: 8px; z-index: 9998; display: none; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <h6 style="margin: 0 0 10px 0; color: #007bff;">Barcode Scanner Test</h6>
                <div style="margin-bottom: 10px;">
                    <input type="text" id="manual-barcode-input" placeholder="Enter barcode to test" style="width: 200px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <button type="button" id="test-scan-btn" class="btn btn-sm btn-primary">Scan</button>
                    <button type="button" id="clear-stats-btn" class="btn btn-sm btn-warning">Clear Stats</button>
                    <button type="button" id="close-test-btn" class="btn btn-sm btn-secondary">×</button>
                </div>
                <div style="font-size: 12px; color: #666;">
                    <div>Total Scans: <span id="total-scans">0</span></div>
                    <div>Buffer Length: <span id="current-buffer">0</span></div>
                    <div>Last Scan: <span id="last-scan">-</span></div>
                    <div>Scan Timeout: <span id="scan-timeout">${this.config.scanTimeout}ms</span></div>
                    <div>End Delay: <span id="end-delay">${this.config.endScanDelay}ms</span></div>
                </div>
                <div style="margin-top: 10px; font-size: 11px;">
                    <label>Adjust Timing:</label><br>
                    <input type="range" id="timeout-slider" min="50" max="500" value="${this.config.scanTimeout}" style="width: 100px;">
                    <span id="timeout-value">${this.config.scanTimeout}ms</span>
                </div>
            </div>
            
        `;
        
        $('body').append(testHtml);
        this.bindTestEvents();
    }

    bindTestEvents() {
        $('#show-barcode-test').on('click', () => {
            $('#barcode-test-container').show();
            $('#show-barcode-test').hide();
        });
        
        $('#close-test-btn').on('click', () => {
            $('#barcode-test-container').hide();
            $('#show-barcode-test').show();
        });
        
        $('#test-scan-btn').on('click', () => {
            const barcode = $('#manual-barcode-input').val().trim();
            if (barcode) {
                this.testScan(barcode);
                $('#manual-barcode-input').val('');
                $('#last-scan').text(barcode);
            }
        });
        
        $('#clear-stats-btn').on('click', () => {
            this.state.scanCount = 0;
            this.updateTestStats();
        });
        
        $('#timeout-slider').on('input', (e) => {
            const value = parseInt(e.target.value);
            this.config.scanTimeout = value;
            this.config.endScanDelay = value + 50;
            $('#timeout-value').text(`${value}ms`);
            $('#scan-timeout').text(`${value}ms`);
            $('#end-delay').text(`${value + 50}ms`);
        });
        
        $('#manual-barcode-input').on('keypress', (e) => {
            if (e.which === 13) {
                $('#test-scan-btn').click();
            }
        });

        // Update test stats periodically
        setInterval(() => this.updateTestStats(), 500);
    }

    updateTestStats() {
        $('#total-scans').text(this.state.scanCount);
        $('#current-buffer').text(this.state.buffer.length);
    }

    // Public method to manually trigger barcode scan
    testScan(barcode) {
        // console.log('Manual test scan triggered:', barcode);
        this.processBarcode(barcode);
    }

    // Method to get current scanner state
    getState() {
        return { ...this.state };
    }

    // Method to update configuration
    updateConfig(newConfig) {
        this.config = { ...this.config, ...newConfig };
        // console.log('Scanner config updated:', this.config);
    }

    // Cleanup method
    cleanup() {
        document.removeEventListener('keydown', this.handleKeyInput);
        this.clearEndScanTimer();
        // console.log('Barcode scanner cleaned up');
    }

    // Method to temporarily disable scanner
    disable() {
        this.state.isProcessing = true;
        // console.log('Barcode scanner disabled');
    }

    // Method to re-enable scanner
    enable() {
        this.state.isProcessing = false;
        // console.log('Barcode scanner enabled');
    }
}

// Initialize the barcode scanner when document is ready
$(document).ready(function() {
    // Initialize with improved configuration
    const scannerConfig = {
        minBarcodeLength: 3,
        maxBarcodeLength: 50,
        scanTimeout: 150, // Increased timeout
        interCharTimeout: 30, // New: time between chars during scan
        endScanDelay: 200, // New: wait time after last char
        apiEndpoint: '/pos/scan-barcode',
        enableSounds: true,
        enableTestMode: true,
        debounceDelay: 100
    };

    window.barcodeScanner = new BarcodeScanner(scannerConfig);
    
    // Optional: Log scanner initialization
    // console.log('Enhanced Barcode Scanner ready for use');
    
    // Optional: Add keyboard shortcut to toggle test mode
    $(document).on('keydown', function(e) {
        // Ctrl+Shift+T to toggle test interface
        if (e.ctrlKey && e.shiftKey && e.key === 'T') {
            e.preventDefault();
            $('#show-barcode-test').click();
        }
    });
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = BarcodeScanner;
}
    </script>


    <script>
        var site_currency_symbol_position = "{{isset($company_settings['site_currency_symbol_position']) ? $company_settings['site_currency_symbol_position'] : 'pre'}}";
        var site_currency_symbol = "{{isset($company_settings['defult_currancy_symbol']) ? $company_settings['defult_currancy_symbol'] : '$'}}";
    </script>
    
    
    
    <script>
    
// Handle cart item deletion with single confirmation





$(document).on('click', '.show_confirm-pos', function(e) {
    e.preventDefault();
    e.stopPropagation();
    // loadCarts();
    var deleteFormId = $(this).data('confirm-yes');
    var productId = $(this).data('id');
    var confirmMessage = $(this).data('confirm');
    var confirmText = $(this).data('text');
    
    // Use SweetAlert2 if available, otherwise use browser confirm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: confirmMessage,
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                removeFromCart(deleteFormId, productId);
            }
        });
    } else {
        // Fallback to browser confirm (single popup)
        if (confirm(confirmMessage + '\n' + confirmText)) {
            removeFromCart(deleteFormId, productId);
        }
    }
});

// Function to handle the actual removal
function removeFromCart(deleteFormId, productId) {
    // Get form data
    var form = $('#' + deleteFormId);
    var formData = form.serialize();
    var actionUrl = form.attr('action');
    
    // Make AJAX request
    $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
      
        success: function(response) {
           
            if (response.code === 200) {
            window.multiCartManager.refreshCurrentCart();
                // Remove the product row from cart table
              
                // $('#product-id-' + productId).fadeOut(300, function() {
                //     $(this).remove();
                    
                //     // Update cart totals using the new totals data
                //     if (response.totals) {
                //         updateCartDisplayFromResponse(response.totals);
                //     } else {
                //         // Fallback to manual calculation
                //         updateCartTotals(response.carttotal);
                //     }
                    
                //     // Update cart count if element exists
                //     if ($('.cart-count').length) {
                //         $('.cart-count').text(response.cartCount);
                //     }
                    
                //     // If cart is empty, show empty cart message
                //     if (response.cartCount === 0) {
                //         showEmptyCart();
                //     }
                // });
                
                // Show success message
                showMessage(response.success, 'success');
            } else {
                showMessage(response.error, 'error');
            }
        },
        error: function(xhr) {
            var errorMessage = 'An error occurred while removing the product.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            showMessage(errorMessage, 'error');
        }
    });
}
////////// review code for deletion
// Function to update cart display from response totals
function updateCartDisplayFromResponse(totals) {
    // Update subtotal
    
     
    $('.cart-subtotal, .subtotal-amount, #cart-subtotal').text(totals.subtotal);
    
    // Update tax
    $('.cart-tax, .tax-amount, #cart-tax').text(totals.tax);
    
    // Update grand total
    $('.totalamount, .total-amount, #cart-total, .grand-total').text(totals.total);
    $('#displaytotal').text(totals.totalWithoutDiscount);
     let discount = totals.discount.replace(/[^\d.-]/g, '');
    // Now set it as a number with two decimals
    $('.discount').val(Number(discount).toFixed(2));
    $('.total-without-discount, #total-without-discount').text(totals.totalWithoutDiscount);
    // Update any data attributes
    $('[data-cart-subtotal]').text(totals.subtotal);
    $('[data-cart-tax]').text(totals.tax);
    $('[data-cart-total]').text(totals.total);
    $('[discount]').text(totals.discount);
    $('[totalamount]').text(totals.totalWithoutDiscount);
}

// Function to update cart totals
function updateCartTotals(cart) {
    var subtotal = 0;
    var totalTax = 0;
    var grandTotal = 0;
    var totalDiscount = 0;
    var totalWithoutDiscount = 0;
    
    // Calculate all totals
    Object.keys(cart).forEach(function(key) {
        var item = cart[key];
        
        // Calculate subtotal (price * quantity)
        subtotal += (item.price * item.quantity);
        
        // Calculate total tax
        totalTax += item.tax_price || 0;
        
        // Calculate grand total (subtotal + tax)
        grandTotal += item.subtotal || 0;
        
        // Calculate total discount
        totalDiscount += item.total_discount || 0;
        
        // Calculate total without discount (original price * quantity + tax)
        var originalPrice = item.original_price || item.price;
        var itemOriginalTotal = originalPrice * item.quantity;
        var itemOriginalTax = (itemOriginalTotal * (item.tax || 0)) / 100;
        totalWithoutDiscount += itemOriginalTotal + itemOriginalTax;
    });
    
    // Update all totals in the UI
    updateCartDisplay(subtotal, totalTax, grandTotal, totalDiscount, totalWithoutDiscount);
}

// Function to update cart display elements
function updateCartDisplay(subtotal, totalTax, grandTotal, totalDiscount, totalWithoutDiscount) {
    // Update subtotal
    $('.cart-subtotal, .subtotal-amount, #cart-subtotal').text(currency_format_with_sym(subtotal));
    
    // Update tax
    $('.cart-tax, .tax-amount, #cart-tax').text(currency_format_with_sym(totalTax));
    
    // Update grand total
    $('.cart-total, .total-amount, #cart-total, .grand-total').text(currency_format_with_sym(grandTotal));
    
    // Update discount
    $('.cart-discount, .discount-amount, #cart-discount').text(currency_format_with_sym(totalDiscount));
    
    // Update total without discount
    $('.total-without-discount, #total-without-discount').text(currency_format_with_sym(totalWithoutDiscount));
    
    // Update any other common selectors
    $('[data-cart-subtotal]').text(currency_format_with_sym(subtotal));
    $('[data-cart-tax]').text(currency_format_with_sym(totalTax));
    $('[data-cart-total]').text(currency_format_with_sym(grandTotal));
   $('[discount]').text(totals.discount);
    $('[totalamount]').text(totals.totalWithoutDiscount);
}

// Function to show empty cart
function showEmptyCart() {
    var emptyCartHtml = '<tr><td colspan="7" class="text-center"><h4>' + 
                       'Your cart is empty' + '</h4></td></tr>';
    $('.cart-table tbody').html(emptyCartHtml);
}

// Function to show messages
function showMessage(message, type) {
    // Use SweetAlert2 if available
    if (typeof Swal !== 'undefined') {
        if (type === 'success') {
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error'
            });
        }
    } else if (typeof toastr !== 'undefined') {
        // Use toastr if available
        if (type === 'success') {
            toastr.success(message);
        } else {
            toastr.error(message);
        }
    } else {
        // Fallback to alert
        alert(message);
    }
}

// Helper function for currency formatting
function currency_format_with_sym(amount) {
    // Adjust this according to your currency format
    return '' + parseFloat(amount).toFixed(2);
}








////// multi cart
// UPDATED JavaScript - Add proper headers for JSON requests
class MultiCartManager {
    constructor() {
        this.initElements();
        this.bindEvents();
        this.loadCarts();
    }
    //////// update cart
    
    //////// end update cart
    
   
    
    
    
    initElements() {
        this.$cartManager = $('.multi-cart-manager');
        this.$cartList = this.$cartManager.find('.cart-list');
        this.$createCartBtn = this.$cartManager.find('#create-new-cart');
        this.$renameCartBtn = this.$cartManager.find('.rename-cart');
        this.$deleteCartBtn = this.$cartManager.find('.delete-cart');
        this.selectedCartId = null;
        this.activeCartId = null; // Track the actual active cart
    }
    
    bindEvents() {
        this.$createCartBtn.on('click', () => this.createNewCart());
        this.$renameCartBtn.on('click', () => this.renameCart());
        this.$deleteCartBtn.on('click', () => this.deleteCart());
        
        // Delegate cart item clicks
        this.$cartList.on('click', '.cart-item', (e) => {
            if (!$(e.target).hasClass('delete-cart')) {
                const cartId = $(e.currentTarget).data('id');
                this.switchCart(cartId);
            }
        });
    }
    
    loadCarts() {
        console.log('Loading carts from: /pos/carts');
        
        fetch('/pos/carts/get', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('Content-Type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON. Content-Type: ' + contentType);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Carts data received:', data);
            
            if (data.success) {
                this.renderCarts(data.carts || []);
                
                // UPDATED: Handle both active_cart and active_pos_cart
                const activeCart = data.active_pos_cart || data.active_cart;
                if (activeCart) {
                    this.activeCartId = activeCart;
                    this.selectedCartId = activeCart;
                    this.updateActionButtons(true);
                    this.loadCartItems(activeCart);
                    this.highlightActiveCart(activeCart);
                }
            } else {
                throw new Error('API returned success: false');
            }
        })
        .catch(error => {
            console.error("Error loading carts:", error);
            show_toastr('Error', 'Failed to load carts: ' + error.message, 'error');
        });
    }

    // renderCarts(carts) {
    //     console.log('Rendering carts:', carts);
    //     this.$cartList.empty();

    //     if (!carts || carts.length === 0) {
    //         this.$cartList.append('<div class="no-carts">No carts available</div>');
    //         return;
    //     }

    //     carts.forEach(cart => {
    //         // UPDATED: Check if this cart is the active one
    //         const isActive = cart.id === this.activeCartId;
    //         const isDefault = cart.is_default || false;
            
    //         const $cartItem = $(`
    //             <div style=" width: 76px; height: 44px; position: relative; color: black; font-weight: 900;overflow:hidden " class="cart-item btn btn-light shadow rounded-pill ${isActive ? 'active' : ''} ${isDefault ? 'default-cart' : ''}" data-id="${cart.id}">
    //                 <span style="font-size:15px;font-weight:900" class="cart-name">
    //                     ${cart.name}
    //                     ${isDefault ? ' <span class="badge badge-primary"></span>' : ''}
    //                 </span>
    //                 <div class="cart-info">
                       
    //                 </div>
                    
    //                 ${!isDefault ? `<button style="width:30px;height:30px;position:relative;bottom: 36px;left: 16px;font-weight: 900;font-size: 20px;color: red;" class="delete-cart-btn  border border-0 bg-transparent " data-cart-id="${cart.id}">×</button>` : ''}
    //             </div>
    //         `);
    //         this.$cartList.append($cartItem);
    //     });
    // }
    renderCarts(carts) {
    console.log('Rendering carts:', carts);
    this.$cartList.empty();

    if (!carts || carts.length === 0) {
        this.$cartList.append('<div class="no-carts">No carts available</div>');
        return;
    }

    carts.forEach(cart => {
        // UPDATED: Check if this cart is the active one
        const isActive = cart.id === this.activeCartId;
        const isDefault = cart.is_default || false;
        
        // UPDATED: Change default cart display name to #1
        let displayName = cart.name;
        if (isDefault && (cart.name === 'Default Cart' || cart.name === 'Default')) {
            displayName = '#1';
        }
        
        const $cartItem = $(`
            <div style=" width: 76px; height: 44px; position: relative; color: black; font-weight: 900;overflow:hidden " class="cart-item btn btn-light shadow rounded-pill ${isActive ? 'active' : ''} ${isDefault ? 'default-cart' : ''}" data-id="${cart.id}">
                <span style="font-size:15px;font-weight:900" class="cart-name">
                    ${displayName}
                    ${isDefault ? ' <span class="badge badge-primary"></span>' : ''}
                </span>
                <div class="cart-info">
                   
                </div>
                
                ${!isDefault ? `<button style="width:30px;height:30px;position:relative;bottom: 36px;left: 16px;font-weight: 900;font-size: 20px;color: red;" class="delete-cart-btn  border border-0 bg-transparent " data-cart-id="${cart.id}">×</button>` : ''}
            </div>
        `);
        this.$cartList.append($cartItem);
    });
}
    
    highlightActiveCart(cartId) {
        // Remove active class from all carts
        this.$cartList.find('.cart-item').removeClass('active');
        // Add active class to current cart
        this.$cartList.find(`.cart-item[data-id="${cartId}"]`).addClass('active');
    }
    
//     createNewCart() {
        
//         //  const cartName = `Cart ${this.$cartList.children().length + 1}`;
//         // const cartName = prompt('Enter cart name:', `Cart ${this.$cartList.children().length + 1}`);
        
//       const existingCartNames = [];
// // Collect current cart names like "Cart 1", "Cart 2", etc.
// this.$cartList.find('.cart-item .cart-name').each(function() {
//     const name = $(this).text().trim();
//     const match = name.match(/^#\s+(\d+)/i);
//     if (match && match[1]) {
//         existingCartNames.push(parseInt(match[1], 10));
//     }
// });

// // Find the highest number and add 1
// const nextNumber = existingCartNames.length === 0 ? 1 : Math.max(...existingCartNames) + 1;

// const cartName = `# ${nextNumber}`;
        
//         if (cartName) {
//             // UPDATED: Use fetch instead of jQuery for consistency
//             fetch('/pos/carts/create', {
//                 method: 'POST',
//                 headers: {
//                     'Accept': 'application/json',
//                     'Content-Type': 'application/json',
//                     'X-Requested-With': 'XMLHttpRequest',
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 body: JSON.stringify({
//                     name: cartName
//                 })
//             })
//             .then(response => response.json())
//             .then(response => {
//                 if (response.success) {
//                     this.renderCarts(response.carts);
                    
//                     // If this is the first cart or no active cart, make it active
//                     if (response.carts.length === 1 || !this.activeCartId) {
//                         this.switchCart(response.cartId);
//                     }
                    
//                     show_toastr('success', 'Cart created successfully', 'success');
//                 } else {
//                     throw new Error(response.message || 'Failed to create cart');
//                 }
//             })
//             .catch(error => {
//                 console.error('Failed to create cart', error);
//                 show_toastr('Error', 'Failed to create cart: ' + error.message, 'error');
//             });
//         }
//     }
createNewCart() {
    const existingCartNames = [];
    // Collect current cart names like "Cart 1", "Cart 2", etc.
    this.$cartList.find('.cart-item .cart-name').each(function() {
        const name = $(this).text().trim();
        // UPDATED: Check for both #1, #2 format and handle default cart
        const match = name.match(/^#\s*(\d+)/i);
        if (match && match[1]) {
            existingCartNames.push(parseInt(match[1], 10));
        }
    });

    // UPDATED: Start from 2 if default cart (#1) exists, otherwise start from 1
    const hasDefaultCart = this.$cartList.find('.default-cart').length > 0;
    const startNumber = hasDefaultCart ? 2 : 1;
    
    // Find the next available number
    let nextNumber = startNumber;
    while (existingCartNames.includes(nextNumber)) {
        nextNumber++;
    }

    const cartName = `# ${nextNumber}`;
    
    if (cartName) {
        // Rest of your existing createNewCart logic...
        fetch('/pos/carts/create', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                name: cartName
            })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                this.renderCarts(response.carts);
                
                // If this is the first cart or no active cart, make it active
                if (response.carts.length === 1 || !this.activeCartId) {
                    this.switchCart(response.cartId);
                }
                
                show_toastr('success', 'Cart created successfully', 'success');
            } else {
                throw new Error(response.message || 'Failed to create cart');
            }
        })
        .catch(error => {
            console.error('Failed to create cart', error);
            show_toastr('Error', 'Failed to create cart: ' + error.message, 'error');
        });
    }
}
    
    switchCart(cartId) {
        console.log("Switching to cart:", cartId);
        
        // UPDATED: Use the new switchCart endpoint with cart_id in body
        fetch('/pos/carts/switch', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                cart_id: cartId
            })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                // UPDATED: Update both selectedCartId and activeCartId
                this.selectedCartId = cartId;
                this.activeCartId = response.active_pos_cart || response.active_cart || cartId;
                
                this.renderCarts(response.carts);
                this.updateActionButtons(true);
                this.loadCartItems(cartId);
                this.highlightActiveCart(cartId);
                
                show_toastr('success', response.message || 'Cart switched successfully.', 'success');
            } else {
               
                show_toastr('error', response.message || 'Failed to switch cart', 'error');
            }
        })
        .catch(error => {
            console.error('Failed to switch cart', error);
            show_toastr('error', 'Failed to switch cart: ' + error.message, 'error');
        });
    }
    
    renameCart() {
        if (!this.selectedCartId) {
            show_toastr('error', 'Please select a cart first', 'error');
            return;
        }
        
        const currentCart = this.$cartList.find(`.cart-item[data-id="${this.selectedCartId}"]`);
        const currentName = currentCart.find('.cart-name').text().replace('Default', '').trim();
        
        const newName = prompt('Rename cart:', currentName);
        
        if (newName && newName !== currentName) {
            $.ajax({
                url: `/pos/carts/rename/${this.selectedCartId}`,
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: { 
                    name: newName,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    if (response.success) {
                        this.renderCarts(response.carts);
                        show_toastr('success', 'Cart renamed successfully', 'success');
                    }
                },
                error: (xhr) => {
                  
                    show_toastr('error', 'Failed to rename cart', 'error');
                }
            });
        }
    }
    
    deleteCart() {
        if (!this.selectedCartId) {
            show_toastr('Error', 'Please select a cart first', 'error');
            return;
        }
        
        // Check if trying to delete default cart
        const currentCart = this.$cartList.find(`.cart-item[data-id="${this.selectedCartId}"]`);
        if (currentCart.hasClass('default-cart')) {
            show_toastr('Error', 'Cannot delete the default cart', 'error');
            return;
        }
        
        if (confirm('Are you sure you want to delete this cart?')) {
            // UPDATED: Use the new deleteCart endpoint
            fetch('/pos/carts/delete', {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    cart_id: this.selectedCartId
                })
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    // UPDATED: Handle active cart change after deletion
                    this.activeCartId = response.active_pos_cart || response.active_cart;
                    this.selectedCartId = this.activeCartId;
                    
                    this.updateActionButtons(!!this.activeCartId);
                    this.renderCarts(response.carts);
                    
                    if (this.activeCartId) {
                        this.loadCartItems(this.activeCartId);
                        this.highlightActiveCart(this.activeCartId);
                    } else {
                        this.clearCartDisplay();
                    }
                    
                    show_toastr('success', 'Cart deleted successfully', 'success');
                } else {
                    throw new Error(response.message || 'Failed to delete cart');
                }
            })
            .catch(error => {
               
                show_toastr('error', 'Failed to delete cart: ' + error.message, 'error');
            });
        }
    }
    
    updateActionButtons(hasSelection) {
        this.$renameCartBtn.prop('disabled', !hasSelection);
        
        // UPDATED: Disable delete button for default cart
        const isDefaultCart = hasSelection && 
            this.$cartList.find(`.cart-item[data-id="${this.selectedCartId}"]`).hasClass('default-cart');
        this.$deleteCartBtn.prop('disabled', !hasSelection || isDefaultCart);
    }
    
    loadCartItems(cartId) {
    if (!cartId) return;

    // UPDATED: Use the new getCartItems endpoint
    fetch('/pos/carts/cart-items?' + new URLSearchParams({ cart_id: cartId }), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
           console.log("cart  data ======>",response.totalWithoutDiscount);
            this.updateCartDisplay(response.items || []);
             $('#displaytotal').text(response.totalWithoutDiscount);
        } else {
            throw new Error(response.message || 'Failed to load cart items');
        }
    })
    .catch(error => {
        console.error('Failed to load cart items', error);
        show_toastr('Error', 'Failed to load cart items: ' + error.message, 'error');
    });
}
   
    clearCartDisplay() {
        $('#tbody').empty();
        $('#displaytotal').text(currency_format_with_sym(0));
        $('.totalamount').text(currency_format_with_sym(0));
        $('.discount').val(0);
    }
    
    updateCartDisplay(items) {
    const $tbody = $('#tbody');
    $tbody.empty();

    const cartItems = Object.values(items); // convert object to array

    if (!cartItems || cartItems.length === 0) {
        $tbody.append('<tr class="text-center no-found"><td colspan="7">No items in cart</td></tr>');
        this.clearCartDisplay();
        return;
    }

    let subtotal = 0;
     var totalDiscount = 0;
    
    cartItems.forEach(item => {
        subtotal += parseFloat(item.subtotal || 0);
         totalDiscount += item.total_discount;
        const $row = $(`
            <tr data-product-id="${item.id}" id="product-id-${item.id}">
                <td class="cart-images">
                    <img src="${item.image}" class="card-image avatar rounded-circle-sale shadow hover-shadow-lg">
                </td>
                <td class="name">${item.name}</td>
                <td>
                    <span class="quantity buttons_added">
                        <button class="minuss">
                            <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-518.000000, -1089.000000)" fill="#000000">
                                        <path d="M540,1106 L528,1106 C527.447,1106 527,1105.55 527,1105 C527,1104.45 527.447,1104 528,1104 L540,1104 C540.553,1104 541,1104.45 541,1105 C541,1105.55 540.553,1106 540,1106 L540,1106 Z M534,1089 C525.163,1089 518,1096.16 518,1105 C518,1113.84 525.163,1121 534,1121 C542.837,1121 550,1113.84 550,1105 C550,1096.16 542.837,1089 534,1089 L534,1089 Z" id="minus-circle" sketch:type="MSShapeGroup">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button>
                            <input type="number" step="1" min="1" max="10" name="quantity" title="Quantity"  class="input-number" size="4"  data-url="/update-cart"  data-id="${item.id}"  data-cart-id="${this.activeCartId}"  value="${item.quantity}" >              
                       <button class="pluss">
                            <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-466.000000, -1089.000000)" fill="#000000">
                                        <path d="M488,1106 L483,1106 L483,1111 C483,1111.55 482.553,1112 482,1112 C481.447,1112 481,1111.55 481,1111 L481,1106 L476,1106 C475.447,1106 475,1105.55 475,1105 C475,1104.45 475.447,1104 476,1104 L481,1104 L481,1099 C481,1098.45 481.447,1098 482,1098 C482.553,1098 483,1098.45 483,1099 L483,1104 L488,1104 C488.553,1104 489,1104.45 489,1105 C489,1105.55 488.553,1106 488,1106 L488,1106 Z M482,1089 C473.163,1089 466,1096.16 466,1105 C466,1113.84 473.163,1121 482,1121 C490.837,1121 498,1113.84 498,1105 C498,1096.16 490.837,1089 482,1089 L482,1089 Z" id="plus-circle" sketch:type="MSShapeGroup">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </span>
                </td>
                <td class="tax">${item.tax || 0}%</td>
                <td class="price">${currency_format_with_sym(item.price || 0)}</td>
                <td class="subtotal">${currency_format_with_sym(item.subtotal || 0)}</td>
                <td>
                    <a href="#" class="action-btn show_confirm-pos" 
                       data-confirm="Are You Sure?" 
                       data-confirm-yes="delete-form-${item.id}">
                        <i class="ti ti-trash bg-danger text-white mx-3 btn btn-sm"></i>
                    </a>
                    <form id="delete-form-${item.id}" action="/pos/carts/${this.activeCartId}/items/${item.id}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                    </form>
                </td>
            </tr>
        `);

        $tbody.append($row);
    });

    
    $('.totalamount').text(currency_format_with_sym(subtotal));
     $('.discount').val(totalDiscount);
}

    
    // UPDATED: Method to get current active cart ID
    getActiveCartId() {
        return this.activeCartId;
    }
    
    // UPDATED: Method to check if cart is active
    isCartActive(cartId) {
        return this.activeCartId === cartId;
    }
    
    refreshCurrentCart() {
    if (this.activeCartId) {
        // Refresh both cart items and cart list
        // this.loadCartItems(this.activeCartId);
        this.loadCarts(); // This will also update the cart counts/totals in the sidebar
    }
}

// NEW: Method to refresh only cart items (faster)
refreshCartItems() {
    if (this.activeCartId) {
        this.loadCartItems(this.activeCartId);
    }
}
}

// Initialize when DOM is ready
$(document).ready(function() {
    // Debug: Check if required elements exist
    if ($('.multi-cart-manager').length === 0) {
        console.error('multi-cart-manager element not found');
        return;
    }
    
    if (!$('meta[name="csrf-token"]').attr('content')) {
        console.error('CSRF token not found');
        return;
    }
    
    window.multiCartManager = new MultiCartManager();
    
    // UPDATED: Update existing cart operations to use active cart
    $(document).on('click', '.toacart', function() {
        const activeCartId = window.multiCartManager.getActiveCartId();
        if (!activeCartId) {
            show_toastr('Error', 'Please select or create a cart first', 'error');
            return;
        }
        
        const url = $(this).data('url') + `?cart_id=${activeCartId}`;
        // ... rest of your existing toacart logic
    });
    
    // UPDATED: Handle delete cart button clicks (if using inline delete buttons)
    $(document).on('click', '.delete-cart-btn', function(e) {
        e.stopPropagation();
        const cartId = $(this).data('cart-id');
        if (cartId && window.multiCartManager) {
            window.multiCartManager.selectedCartId = cartId;
            window.multiCartManager.deleteCart();
        }
    });
});




    </script>
    
<script>
    $(document).ready(function() {
       
        
        // Simple toast function for demo
        
        // Handle quantity changes - FIXED VERSION
        $(document).on('click', '.quantity .pluss, .quantity .minuss', function(e) {
            e.preventDefault();
            console.log('Button clicked:', $(this).hasClass('pluss') ? 'plus' : 'minus');
            
            var $input = $(this).siblings('input.input-number');
            var quantity = parseInt($input.val()) || 1;
            var max = parseInt($input.attr('max')) || Infinity;
            var min = parseInt($input.attr('min')) || 1;
            
             if ($(this).hasClass('pluss')) {
                quantity +=1;
            } else if ($(this).hasClass('minuss')) {
                 quantity -=1;
            }
            console.log('Current:', quantity, 'Min:', min, 'Max:', max);
            
            var productId = $input.data('id');
            var cartId = $input.data('cart-id');
            var url = $input.data('url');
             var discount = $('.discount').val();
            $.ajax({
                    url: $input.data('url'),
                    method: "patch",
                    data: {
                        id: productId,
                        quantity: quantity,
                        discount:discount,
                        session_key: 'pos'
                    },
                    success: function (response) {
                        console.log('succes',response);
                        if (response.code == '200') {
                           
                              window.multiCartManager.updateCartDisplay(response.product || []);
                        //   window.multiCartManager.refreshCartItems();
                        
                        show_toastr('Success', response.success, 'success');
                        // show_toastr('Success', 'Quantity updated successfully', 'success');
                        }
                         if (response.code == '202') {
                          data = response.responseJSON;
                         show_toastr('Error', 'Failed to create cart: ' + data.message, 'error');
                        }
                    },
                    error: function (response) {
                         
                        data = response.responseJSON;
                        console.log('error',data.code);
                        if (data.code == 404) {
                              console.log('error',data.error);
                              alert(data.error)
                        show_toastr('Success', data.error || 'Cart switched successfully', 'success');
                        }

                      
                    }
                });
        
            
            
            // Fixed the class name check here
        
        });
        
        
        // Initialize input values
        $('.quantity input.input-number').each(function() {
            $(this).data('old-value', $(this).val());
        });
        
        console.log('Event handlers attached');
    });
    </script>
    
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
          document.querySelectorAll(".category-scroll").forEach((scrollContainer) => {
            let isDown = false;
            let startX;
            let scrollLeft;
        
            // Pointer down (mouse/touch/pen sab cover karega)
            scrollContainer.addEventListener("pointerdown", (e) => {
              isDown = true;
              scrollContainer.setPointerCapture(e.pointerId);
              scrollContainer.classList.add("dragging");
              startX = e.clientX;
              scrollLeft = scrollContainer.scrollLeft;
            });
        
            // Pointer move
            scrollContainer.addEventListener("pointermove", (e) => {
              if (!isDown) return;
              e.preventDefault();
              const x = e.clientX;
              const walk = (x - startX) * 1.5;
              scrollContainer.scrollLeft = scrollLeft - walk;
            });
        
            // Pointer up / cancel
            scrollContainer.addEventListener("pointerup", () => {
              isDown = false;
              scrollContainer.classList.remove("dragging");
            });
        
            scrollContainer.addEventListener("pointercancel", () => {
              isDown = false;
              scrollContainer.classList.remove("dragging");
            });
          });
        
          // Disable keyboard scroll
          window.addEventListener("keydown", function (e) {
            if (["ArrowLeft", "ArrowRight", " "].includes(e.key)) {
              e.preventDefault();
            }
          });
        });
    </script>

</body>

</html>
