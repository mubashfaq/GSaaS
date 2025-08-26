@php
    $admin_settings = getAdminAllSetting();
    $company_settings = getCompanyAllSetting($company_id,$workspace_id);
    $favicon = isset($company_settings['favicon'])
        ? $company_settings['favicon']
        : (isset($admin_settings['favicon'])
            ? $admin_settings['favicon']
            : 'uploads/logo/favicon.png');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="">
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

<head>

    <title>@yield('page-title') |
        {{ !empty($company_settings['title_text']) ? $company_settings['title_text'] : (!empty($admin_settings['title_text']) ? $admin_settings['title_text'] : 'WorkDo') }}
    </title>

    <meta name="title"
        content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta name="keywords"
        content="{{ !empty($admin_settings['meta_keywords']) ? $admin_settings['meta_keywords'] : 'WorkDo Dash,SaaS solution,Multi-workspace' }}">
    <meta name="description"
        content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title"
        content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="og:description"
        content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.' }} ">
    <meta property="og:image"
        content="{{ get_file(!empty($admin_settings['meta_image']) ? (check_file($admin_settings['meta_image']) ? $admin_settings['meta_image'] : 'uploads/meta/meta_image.png') : 'uploads/meta/meta_image.png') }}{{ '?' . time() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title"
        content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="twitter:description"
        content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.' }} ">
    <meta property="twitter:image"
        content="{{ get_file(!empty($admin_settings['meta_image']) ? (check_file($admin_settings['meta_image']) ? $admin_settings['meta_image'] : 'uploads/meta/meta_image.png') : 'uploads/meta/meta_image.png') }}{{ '?' . time() }}">

    <meta name="author" content="Workdo.io">
    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{ get_file(favicon())}}{{'?'.time()}}" type="image/x-icon" /> --}}
    <link rel="icon"
        href="{{ check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png') }}{{ '?' . time() }}"
        type="image/x-icon" />

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/css/yellow-style.css') }}">
</head>

<body class="{{ 'theme-1' }}">
    <!-- header start here -->
    <header class="site-header">
        <div class="main-navigationbar sticky_header" id="header-sticky">
            <div class="container">
                <div class="navigationbar-row d-flex align-items-center justify-content-between">
                    <div class="logo-col">
                        <h1>
                            <a href="#" tabindex="0">
                                <img src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/images/logo.png') }}"
                                    alt="activewear-logo" loading="lazy">
                            </a>
                        </h1>
                    </div>
                    <div class="order-btn-wrp">
                        <a href="{{route('restaurant-store-cart',['workspace' => $workspace,'table_id' => $diningTable->id])}}" class="cart-button">
                            <div class="cart-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"
                                    fill="none">
                                    <path
                                        d="M6.98141 20.3867C6.64547 20.388 6.32275 20.2559 6.08425 20.0193C5.84576 19.7827 5.71102 19.461 5.70967 19.1251C5.70833 18.7891 5.84049 18.4664 6.07709 18.2279C6.31368 17.9894 6.63533 17.8547 6.97127 17.8534H6.98141C7.31735 17.8534 7.63953 17.9868 7.87708 18.2243C8.11462 18.4619 8.24807 18.7841 8.24807 19.12C8.24807 19.456 8.11462 19.7781 7.87708 20.0157C7.63953 20.2532 7.31735 20.3867 6.98141 20.3867ZM16.3547 19.12C16.3547 18.7841 16.2213 18.4619 15.9837 18.2243C15.7462 17.9868 15.424 17.8534 15.0881 17.8534H15.0779C14.8279 17.8554 14.584 17.9313 14.377 18.0717C14.17 18.2121 14.0093 18.4106 13.9149 18.6423C13.8206 18.8739 13.797 19.1283 13.847 19.3733C13.897 19.6183 14.0184 19.8431 14.196 20.0192C14.3735 20.1953 14.5992 20.315 14.8447 20.363C15.0901 20.4111 15.3443 20.3854 15.5751 20.2893C15.806 20.1931 16.0032 20.0308 16.142 19.8227C16.2807 19.6146 16.3547 19.3701 16.3547 19.12ZM19.0796 6.31149L18.0561 12.5739C18.043 12.9409 17.9527 13.3011 17.7911 13.6308C17.6295 13.9606 17.4002 14.2526 17.1181 14.4878C16.8361 14.723 16.5076 14.8961 16.1542 14.9959C15.8007 15.0956 15.4302 15.1198 15.0668 15.0667H6.68653C6.19788 15.0679 5.72534 14.892 5.35644 14.5715C4.98754 14.2511 4.74727 13.8078 4.68013 13.3238L3.15911 2.73645C3.11936 2.4321 2.96985 2.15274 2.73866 1.95085C2.50747 1.74895 2.21052 1.63842 1.90359 1.64002H1.64013C1.43856 1.64002 1.24525 1.55995 1.10273 1.41742C0.960198 1.2749 0.880127 1.08159 0.880127 0.880022C0.880127 0.678457 0.960198 0.485148 1.10273 0.34262C1.24525 0.200093 1.43856 0.120022 1.64013 0.120022H1.90359C2.576 0.115707 3.22695 0.356537 3.73464 0.797453C4.24232 1.23837 4.57196 1.84916 4.66189 2.51554L4.87367 3.92002H17.0935C17.3899 3.92111 17.6824 3.9872 17.9505 4.11365C18.2186 4.24009 18.4557 4.4238 18.6451 4.65184C18.8345 4.87987 18.9716 5.14667 19.0466 5.43342C19.1217 5.72018 19.1329 6.01991 19.0796 6.31149ZM13.5539 7.6045C13.4833 7.53388 13.3995 7.47785 13.3073 7.43963C13.215 7.4014 13.1162 7.38173 13.0163 7.38173C12.9165 7.38173 12.8176 7.4014 12.7254 7.43963C12.6331 7.47785 12.5493 7.53388 12.4787 7.6045L10.3143 9.76898L9.50359 8.95831C9.36032 8.81981 9.16838 8.74311 8.96911 8.74475C8.76984 8.74638 8.57918 8.82622 8.4382 8.96707C8.29723 9.10791 8.21721 9.29849 8.21538 9.49776C8.21356 9.69703 8.29007 9.88904 8.42845 10.0324L9.77922 11.3842C9.92202 11.5264 10.1153 11.6062 10.3168 11.6062C10.5183 11.6062 10.7116 11.5264 10.8544 11.3842L13.5539 8.68269C13.625 8.61205 13.6814 8.52806 13.7199 8.43554C13.7584 8.34302 13.7782 8.2438 13.7782 8.14359C13.7782 8.04339 13.7584 7.94417 13.7199 7.85165C13.6814 7.75913 13.625 7.67514 13.5539 7.6045Z"
                                        fill="#0CAF60" />
                                </svg>
                            </div>
                            <p>
                                <span>
                                    @php
                                        $addCart = session()->get($workspace->slug);
                                        $total_item = 0;
                                        if (isset($addCart['products'])) {
                                            foreach ($addCart['products'] as $item) {
                                                if (isset($addCart) && !empty($addCart['products'])) {
                                                    $total_item = count($addCart['products']);
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ $total_item }}
                                </span> {{ __('Order') }}
                            </p>
                        </a>
                        <a href="{{route('restaurant-order-status',['workspace' => $workspace,'table_id' => $diningTable->id])}}" class="cart-button order-status">
                                <span>{{__('Order status')}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end here -->
    <main>
        @yield('content')
    </main>
    <!-- footer start here -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-row d-flex align-items-center justify-content-between">
                <span>
                    @if (!empty($company_settings['footer_text']))
                        {{ $company_settings['footer_text'] }} @else{{ __('Copyright') }} &copy;
                        {{ config('app.name', 'WorkDo') }}
                    @endif{{ date('Y') }}
                </span>
            </div>
        </div>
    </footer>
    <!-- footer end here -->
    {{-- model --}}
    <div class="order-popup" id="commonModal">
        <div class="order-wrapper">
            <div class="order-inner">
                <button class="order-close-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 34 34"
                        fill="none">
                        <path
                            d="M22.9373 12.7963L18.6742 17L22.9373 21.2038C23.0559 21.3148 23.1505 21.4491 23.2152 21.5982C23.2798 21.7473 23.3132 21.9081 23.3132 22.0706C23.3132 22.2332 23.2798 22.3939 23.2152 22.5431C23.1505 22.6922 23.0559 22.8264 22.9373 22.9375C22.8263 23.0476 22.6947 23.1346 22.55 23.1937C22.4054 23.2528 22.2504 23.2828 22.0942 23.2819C21.7826 23.2806 21.4841 23.1569 21.2629 22.9375L16.9998 18.6744L12.796 22.9375C12.5748 23.1569 12.2763 23.2806 11.9648 23.2819C11.8085 23.2828 11.6536 23.2528 11.5089 23.1937C11.3642 23.1346 11.2326 23.0476 11.1217 22.9375C10.9005 22.715 10.7763 22.414 10.7763 22.1003C10.7763 21.7866 10.9005 21.4856 11.1217 21.2631L15.3254 17L11.1217 12.7963C10.9271 12.5691 10.8255 12.2769 10.837 11.978C10.8485 11.6791 10.9724 11.3956 11.1839 11.1841C11.3954 10.9727 11.6789 10.8488 11.9778 10.8372C12.2766 10.8257 12.5689 10.9273 12.796 11.1219L16.9998 15.3256L21.2035 11.1219C21.3135 11.008 21.4448 10.917 21.5899 10.8539C21.735 10.7908 21.8912 10.7569 22.0494 10.7541C22.2076 10.7514 22.3649 10.7798 22.5121 10.8378C22.6594 10.8958 22.7937 10.9822 22.9076 11.0922C23.0214 11.2021 23.1125 11.3334 23.1756 11.4786C23.2387 11.6237 23.2726 11.7798 23.2754 11.9381C23.2781 12.0963 23.2497 12.2535 23.1917 12.4008C23.1337 12.548 23.0472 12.6824 22.9373 12.7963ZM28.756 28.7562C26.4309 31.0811 23.4686 32.6643 20.2437 33.3057C17.0188 33.947 13.6762 33.6177 10.6385 32.3593C7.60075 31.101 5.00438 28.9701 3.17768 26.2362C1.35097 23.5022 0.375977 20.288 0.375977 17C0.375977 13.712 1.35097 10.4978 3.17768 7.76382C5.00438 5.02989 7.60075 2.89902 10.6385 1.64067C13.6762 0.382308 17.0188 0.0529786 20.2437 0.69432C23.4686 1.33566 26.4309 2.91887 28.756 5.24375C30.3 6.78755 31.5247 8.62035 32.3603 10.6375C33.1959 12.6546 33.626 14.8166 33.626 17C33.626 19.1834 33.1959 21.3454 32.3603 23.3625C31.5247 25.3797 30.3 27.2125 28.756 28.7562ZM27.0817 6.91813C25.0868 4.93018 22.5476 3.57791 19.7847 3.03208C17.0219 2.48625 14.1592 2.77133 11.5582 3.85133C8.95726 4.93133 6.73464 6.75781 5.17101 9.10014C3.60739 11.4425 2.77289 14.1956 2.77289 17.0119C2.77289 19.8282 3.60739 22.5813 5.17101 24.9236C6.73464 27.2659 8.95726 29.0924 11.5582 30.1724C14.1592 31.2524 17.0219 31.5375 19.7847 30.9917C22.5476 30.4458 25.0868 29.0936 27.0817 27.1056C28.4101 25.7817 29.4642 24.2087 30.1834 22.4765C30.9027 20.7444 31.2729 18.8874 31.2729 17.0119C31.2729 15.1364 30.9027 13.2793 30.1834 11.5472C29.4642 9.8151 28.4101 8.242 27.0817 6.91813Z"
                            fill="#060606" />
                    </svg>
                </button>
                <div class="body">

                </div>
            </div>
        </div>
    </div>

    <!--scripts start here-->
    <script src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('packages/workdo/RestaurantMenu/src/Resources/assets/js/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>


    <!--scripts end here-->
    @if ($message = Session::get('success'))
        <script>
            show_toastr('{{ __('Success') }}', '{{ __($message) }}', 'success');
        </script>
    @endif
    @if ($message = Session::get('error'))
        <script>
            show_toastr('{{ __('Error') }}', '{{ __($message) }}', 'error');
        </script>
    @endif

</body>

</html>
