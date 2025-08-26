@php

    $currentBusiness = Workdo\VCard\Entities\Business::currentBusiness();

@endphp
@extends('layouts.main')

<style>
    .shareqrcode img {
        width: 65%;
        height: 65%;
    }
    .shareqrcode canvas {
        width: 65%;
        height: 65%;
    }
    /* Social Sharing  */
    .sharingButtonsContainer {
        position: absolute;
        top: 95%;
        left: 20px;
        transform: translateY(-50%);
        z-index: 9999;
    }

    .sharingButtonsContainer {
        position: absolute;
        top: 95%;
        left: 20px;
        z-index: 1;
    }
    .socialJS {
        display: flex;
        gap: 0 10px;
    }
    .sharingButtonsContainer .Demo1 {
        margin-bottom: 0px !important;
    }
    .sharingButtonsContainer a {
        background-color: #ddd;
        display: flex;
        justify-content: center;
        min-width: 13px;
        padding: 7px;
        border-radius: 4px;
        width: 30px;
    }
    @media screen and (max-width: 575px) {
        .sharingButtonsContainer {
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('page-breadcrumb')
    {{ __('vCard') }}
@endsection
@push('css')
<link rel="stylesheet" href="{{asset('packages/workdo/VCard/src/Resources/assets/custom/css/custom.css')}}">
@endpush
@section('page-action')
    <div class="d-flex align-items-center justify-content-end gap-2"> 
        <ul class="list-unstyled mb-0 m-2 form-control">
            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false" id="dropdownLanguage">
                    @foreach ($businesses as $key => $value)
                        <span
                            class="drp-text hide-mob text-primary">{{ $currentBusiness == $key ? Str::ucfirst($value) : '' }}</span>
                    @endforeach
                    <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                </a>
                <div class="vcard-appointment-list dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                    @foreach ($businesses as $key => $business_val)
                        <a href="{{ route('business.current', $key) }}" class="dropdown-item">
                            <i class="@if ($currentBusiness == $key) ti ti-checks text-primary @endif "></i>
                            <span>{{ ucfirst($business_val) }}</span>
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>

    </div>
@endsection
@section('content')
    @php
        $workspace = App\Models\WorkSpace::where('id', getActiveWorkSpace())->first();
    @endphp
    <div class="row row-gap mb-4">
        <div class="col-xxl-6 col-12 d-xxl-flex">
            <div class="row row-gap">
                <div class="col-md-9 col-12">
                    <div class="dashboard-card">
                        <img src="{{ asset('assets/images/layer.png')}}" class="dashboard-card-layer" alt="layer">
                        <div class="card-inner">
                            <div class="card-content">
                                <h2>{{ !empty($businessData) ? __(ucfirst($businessData->title)) : '-' }}</h2>
                                <p>{{__('Seamless project management with streamlined task assignment.')}}</p>
                                @if(isset($businessData) && !empty($businessData->slug))
                                    <div class="btn-wrp d-flex gap-3">
                                        <a href="#" class="btn btn-primary d-flex align-items-center gap-1 cp_link" tabindex="0" data-link="{{ route('get.vcard', ['slug' => $businessData->slug]) }}" data-bs-whatever="{{ __('Copy Link') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Copy Link') }}" data-bs-placement="bottom" title="{{ __('Click to copy link') }}">
                                            <i class="ti ti-link text-white"></i>
                                        <span>{{ __('Business Link') }}</span></a>
                                        <a href="javascript:" class="btn btn-primary socialShareButton share-btn" id="socialShareButton" tabindex="0">
                                            <i class="ti ti-share text-white"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="card-icon  d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="69" viewBox="0 0 54 69" fill="none">
                                    <path opacity="0.6" d="M48.6358 15.1328H45.9533V52.7411C45.9533 54.8785 45.1054 56.9283 43.5962 58.4397C42.0869 59.951 40.04 60.8001 37.9056 60.8001H11.0801V63.4864C11.0801 64.9113 11.6453 66.2778 12.6515 67.2854C13.6576 68.2929 15.0223 68.859 16.4452 68.859H48.6358C50.0587 68.859 51.4234 68.2929 52.4295 67.2854C53.4357 66.2778 54.0009 64.9113 54.0009 63.4864V20.5054C54.0009 19.0805 53.4357 17.714 52.4295 16.7064C51.4234 15.6989 50.0587 15.1328 48.6358 15.1328Z" fill="#18BF6B"/>
                                    <rect width="43.4783" height="53.5117" rx="5.72723" fill="#18BF6B"/>
                                </svg>
                            </div>
                            <div id="sharingButtonsContainer" class="sharingButtonsContainer" style="display: none;">
                                <div class="Demo1 gap-2 d-flex align-items-center justify-content-center hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="qr-card">
                        <div class="qr-card-inner">
                            <div class="shareqrcode"></div>
                            @if(isset($businessData) && !empty($businessData->slug))
                                <div class="qr-card-content">
                                    <div class="qr-btn">
                                        <span>{{ $workspace->name }}</span>
                                        <a href="#" tabindex="0" class="cp_link" data-link="{{ route('get.vcard', ['slug' => $businessData->slug]) }}" data-bs-whatever="{{ __('Copy Link') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Copy Link') }}" data-bs-placement="bottom" title="{{ __('Click to copy link') }}">
                                            <i class="ti ti-layers-linked text-primary"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-12">
            <div class="row d-flex dashboard-wrp">
                <div class="col-md-4 col-sm-6 col-12 d-flex flex-wrap">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-briefcase text-danger"></i>
                                </div>
                                <a href="{{ route('business.index') }}"><h3 class="mt-3 mb-0 text-danger">{{ __('Total Business') }}</h3></a>
                            </div>
                            <h3 class="mb-0">{{ $total_bussiness }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 d-flex flex-wrap">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-calendar-time"></i>
                                </div>
                                <a href="{{ route('appointment.index') }}"><h3 class="mt-3 mb-0">{{ __('Total Appointments') }}</h3></a>
                            </div>
                            <h3 class="mb-0">{{ $total_app }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 d-flex flex-wrap">
                    <div class="dashboard-project-card">
                        <div class="card-inner  d-flex justify-content-between">
                            <div class="card-content">
                                <div class="theme-avtar bg-white">
                                    <i class="ti ti-clipboard-check"></i>
                                </div>
                                <a href="{{ route('contacts.index') }}"><h3 class="mt-3 mb-0">{{ __('Total Contacts') }}</h3></a>
                            </div>
                            <h3 class="mb-0">{{ $total_contact }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="col-lg-12 ">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-end">
                                    <span class="mb-0 float-right">{{ __('Last 7 Days') }}</span>
                                </div>
                                <h5>{{ __('Appointments') }}</h5>
                            </div>
                            <div class="card-body">
                                <div id="apex-storedashborad" data-color="primary" data-height="280"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <img src="{{ isset($qr_detail->image) ? get_file($qr_detail->image) : '' }}" id="image-buffers"
            style="display: none">
    @endsection

    @push('scripts')
        <script src="{{ asset('packages/workdo/VCard/src/Resources/assets/custom/js/purpose.js') }}"></script>
        <script src="{{ asset('packages/workdo/VCard/src/Resources/assets/custom/js/jquery.qrcode.min.js') }}"></script>
        <script src="{{ asset('packages/workdo/VCard/src/Resources/assets/custom/js/socialSharing.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
        <script type="text/javascript">
            $('.cp_link').on('click', function() {
                var value = $(this).attr('data-link');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(value).select();
                document.execCommand("copy");
                $temp.remove();
                toastrs('{{ __('Success') }}', '{{ __('Link Copy on Clipboard') }}', 'success');
            });
        </script>

        <script>
            $(document).ready(function() {
                @if ($businessData)
                    var slug = '{{ $businessData->slug }}';
                    var url_link = `{{ route('get.vcard', ['slug' => '__SLUG__']) }}`.replace('__SLUG__', slug);

                    $(`.qr-link`).text(url_link);
                    var foreground_color =
                        `{{ isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000' }}`;
                    var background_color =
                        `{{ isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff' }}`;
                    var radius = `{{ isset($qr_detail->radius) ? $qr_detail->radius : 26 }}`;
                    var qr_type = `{{ isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0 }}`;
                    var qr_font = `{{ isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'VCard' }}`;
                    var qr_font_color =
                        `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
                    var size = `{{ isset($qr_detail->size) ? $qr_detail->size : 9 }}`;

                    $('.shareqrcode').empty().qrcode({
                        render: 'image',
                        size: 500,
                        ecLevel: 'H',
                        minVersion: 3,
                        quiet: 1,
                        text: url_link,
                        fill: foreground_color,
                        background: background_color,
                        radius: .01 * parseInt(radius, 10),
                        mode: parseInt(qr_type, 10),
                        label: qr_font,
                        fontcolor: qr_font_color,
                        image: $("#image-buffers")[0],
                        mSize: .01 * parseInt(size, 10)
                    });
                @endif
            });
        </script>
        <script>
            (function() {
                var options = {
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: {!! json_encode($chartData['data']) !!},
                    xaxis: {
                        labels: {
                            format: "MMM",
                            style: {
                                colors: PurposeStyle.colors.gray[600],
                                fontSize: "14px",
                                fontFamily: PurposeStyle.fonts.base,
                                cssClass: "apexcharts-xaxis-label"
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        type: "text",
                        categories: {!! json_encode($chartData['label']) !!}
                    },
                    yaxis: {
                        labels: {
                            style: {
                                color: PurposeStyle.colors.gray[600],
                                fontSize: "12px",
                                fontFamily: PurposeStyle.fonts.base
                            }
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !0,
                            borderType: "solid",
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        }
                    },

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                    },

                };
                var chart = new ApexCharts(document.querySelector("#apex-storedashborad"), options);
                chart.render();
            })();
        </script>
        <script type="text/javascript">
            @if ($businessData)
                $(document).ready(function() {
                    var slug = '{{ $businessData->slug }}';
                    var customURL = `{{ route('get.vcard', ['slug' => '__SLUG__']) }}`.replace('__SLUG__', slug);
                    $('.Demo1').socialSharingPlugin({
                        url: customURL,
                        title: $('meta[property="og:title"]').attr('content'),
                        description: $('meta[property="og:description"]').attr('content'),
                        img: $('meta[property="og:image"]').attr('content'),
                        enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
                    });

                    $('.socialShareButton').click(function(e) {
                        e.preventDefault();
                        $('.sharingButtonsContainer').toggle();
                    });
                });
            @endif
        </script>
    @endpush
