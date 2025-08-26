{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
Contact Us

@endsection

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- fontawesome cdnjs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap-4 link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://gsaas.com.au/uploads/logo/favicon.png?1752042036" type="image/x-icon" />
    <style>
        @media (min-width:320px) and (max-width:576px) {
            .about-gsaas {
                font-size: 40px !important;
            }
            .redy{
                margin-left:13% ;
            }
            .stas{
               margin-left:7%;
               
            }
           

            .highlights-circle{
                font-size:20px;
            }
            .highlights-circl{
                font-size:20px;
            }
            .bb {
                            
                border-bottom: 1px solid white;
                margin-bottom: 20px;                 
                padding-left: 2%;                     
                padding-right: 2%;                   
                padding-bottom: 40px;                   
                width: 50px important;                          
            }

        }

        @font-face {
            font-family: 'CustomFont';
            /* Name of your font */
            src: url('../public/Assest/fonts//Cavolini-Bold.woff') format('woff'),
                url('../public/Assest/fonts/Cavolini-Bold.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');


        /*FAQS*/

        .faq-item:last-child .faq-button {
            border-bottom: none !important;
        }

        .faq-button::after {
            display: none !important;
        }

        .faq-item,
        .faq-button,
        .faq-collapse {
            border: none !important;
            box-shadow: none !important;
        }

        .faq-button {
            border-bottom: 1px solid black !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem 1rem;
            background: none;
            font-size: 1rem;
            width: 100%;
            text-align: left;
        }

        .faq-icon {
            background-color: black;
            color: white;
            padding: 5px;
            border-radius: 2px;
            margin-left: auto;
            transition: transform 0.3s;
            font-size: 1rem;
        }

        .faq-body {
            padding: 0.4rem 1rem;
            font-size: 0.95rem;
        }

        .faq-heading {
            margin-bottom: 0.8rem !important;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .faq-button:focus {
            box-shadow: none;
        }

        /*FAQS_END*/

        .navbar {
            background: #12aaf1;
            width: 100%;
            z-index: 10;
            padding: 15px 0px !important;
        }

        .nav-item .nav-link {
            font-weight: 500;
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            background-image: url('./public/Assest/images/Vector.png');
            background-size: cover;
            background-position: bottom;
            height: 990px;
        }

        .lead {
            font-family: "Inter", sans-serif;
            font-weight: 400;
        }

        .hero-section-btn {
            background: linear-gradient(90deg, #023850 0%, #0380B6 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            font-family: "Inter", sans-serif;
            font-weight: 500 !important;
            font-size: 16px;
            padding: 11px 45px !important;
            text-decoration: none;
        }

        .hero-section-btn-two {
            border: none !important;
            border-radius: 10px !important;
            font-family: "Inter", sans-serif;
            font-weight: 500 !important;
            font-size: 16px;
            padding: 11px 35px !important;
            text-decoration: none;
        }

        .dashboardimg-section {
            margin-top: -430px;
            margin-bottom: 100px;
        }

        .work-broken-section {
            background: #F9F9F9;
            padding: 80px 0px;
            margin-top: 80px;
            box-shadow: 0px -1px 10px #B8B8B840;
        }


        .work-broken-section .col-md-5 {
            width: 47% !important;
        }

        .work-broken-section .col-md-6 {
            width: 45% !important;
        }

        .fix-it-box {
            background-image: url('./public/Assest/images/fix-it-bg.png');
            background-size: cover;
            background-position: center;
            padding: 40px 60px;
            border-radius: 10px;
        }

        .fix-it-box h2 {
            font-family: "Inter", sans-serif;
            font-weight: 600;
            font-size: 48px;
            color: white;
        }

        .fix-it-box p {
            font-family: "Inter", sans-serif;
            font-weight: 500;
            font-size: 18px;
            color: white;
        }

        .fix-it-box a {
            background: linear-gradient(90deg, #023850 0%, #0380B6 100%) !important;
            border: 1px solid white;
            border-radius: 4px;
            font-family: "Inter", sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: white;
            text-decoration: none;
            padding: 11px 45px;
        }

        .fix-it-box a:hover {
            color: white;
        }

        .solving-bubble {
            top: -35px;
            right: 0px;
        }

        .benefit-section {
            background: #F9F9F9;
            box-shadow: 0px -1px 10px #B8B8B840;
        }

        .benefits-cards {
            background-color: white;
            border-radius: 24px;
            padding: 30px 20px;
            height: 170px;
        }

        .benefits-bubble {
            top: -7px;
            right: -95px;
        }



        .leading-heading {
            font-size: 40px;
            font-family: "Inter", sans-serif;
            font-weight: 600 !important;
        }

        .leading-company-logo {
            width: 225px !important;
        }

        .clients-logos {
            gap: 40px 10px;
            padding-bottom: 50px;
            border-bottom: 1px solid #14202E66;
        }

        .benefits-cards-title {
            font-family: "Inter", sans-serif;
            font-weight: 700;
            font-size: 24px;
        }

        .benefits-cards-text {
            font-family: "Inter", sans-serif;
        }

        /* Navbar */
        .navbar-nav {
            gap: 20px !important;
        }

        .login a {
            border-radius: 10px;
            width: 116px;
        }

        .mini-heading {
            font-size: 14px;
            font-weight: 500;
        }

        /* frist-section */
        .main-titl>h1 {
            font-size: 48px;
        }

        /* fourth-section */
        .work-broken {
            text-align: end;
        }

        .border-work {
            border: 2px solid black;
            padding: 20px !important;
            border-radius: 4px;
            border-width: 2px;
        }

        /* problem-section */
        .problem-main-img {
            position: absolute;
            left: 90%;
            top: -90px;
        }

        .features-main-img {
            position: absolute;
            right: 0px;
            top: -65px;
            width: 150px;
            height: 150px;
        }

        .border-work>h2 {
            font-family: "Inter", sans-serif;
            font-weight: 600;
            font-size: 40px;
            line-height: 52px;
            letter-spacing: -2.5%;
            text-align: center;
        }

        .border-work>p {
            font-family: "Inter", sans-serif;
            font-weight: 500;
            font-size: 24px;
            letter-spacing: -2.5%;
            text-align: center;
            color: #108AEA;
            margin: 0px !important;
        }

        .work {
            padding: 10px;

        }

        .industry-card {
            width: 116px;
            padding: 10px;
            border-radius: 10px;
        }

        .industry-titl {
            text-align: initial;
            font-size: 16px;
        }

        .whygsaas {
            background-color: rgba(240, 248, 255, 0.884);
        }

        .right-col {
            padding-right: 20px;
        }

        .sec-heading h2 {
            font-size: 40px;
        }

        /* Now use the custom font */
        .font {
            font-family: 'CustomFont', sans-serif;
            /* Apply your font to body */
        }

        input::placeholder {
            color: white !important;
        }

        .random-column {
            width: 166px !important;
            height: 156px !important;
            border: 1px solid #CCCCCC;
            box-shadow: 0px 8px 4px #E4E4E426;
            padding: 20px !important;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .random-column-2 {
            width: 260px !important;
            height: 250px !important;
            border: 1px solid #CCCCCC;
            box-shadow: 0px 8px 4px #E4E4E426;
            padding: 20px !important;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(0deg, #FFFFFF 0%, #F3FCFF 100%) !important;
        }

        .random-column:hover {
            border: 1px solid #108AEA;
            box-shadow: 0px 8px 24px #14C4F633;
        }

        .random-column-2:hover {
            border: 1px solid #108AEA;
            box-shadow: 0px 8px 24px #14C4F633;
        }

        .random-column p {
            font-family: "Inter", sans-serif;
            font-weight: 500;
            font-size: 16px;
        }

        .random-column img {
            width: 48px;
        }

        /* problem-solving */
        .pm-card {
            overflow: hidden;
        }

        .pm-img {
            position: relative;
            top: 20px;
        }

        /* industry */
        .industry-title {
            font-size: 48px;
            font-weight: 600;
        }

        .kaushan-script-regular {
            font-family: "Kaushan Script", cursive;
            font-weight: 400;
            font-style: italic;
            font-size: 19px;

        }

        .bars {
            position: relative !important;
            top: 10px;
        }

        .bars li {
            background-color: black !important;
        }

        .kaushan {
            font-family: "Antonio", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-size: 44px;
            color: white;
        }

        .big-card {
            position: relative;
            bottom: 100px;
        }

        footer {
            /*padding: 50px 32px 30px !important;*/
            background-image: url('./public/Assest/images/footer-bg.png');
            background-size: cover;
            background-position: center;
        }

        .worksec-img {
            position: relative;
            right: 140px;
        }

        .feat {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            background-color: white;
        }

        .feat img {
            width: 50px;
            height: 50px;

        }

        .footer-btn {
            background-color: white;
            padding: 11px 30px;
            border: none;
            border-radius: 10px;
            font-family: "Inter", sans-serif;
            font-weight: 16px;
            font-weight: 500;
        }

        .footer-btn-2 {
            padding: 11px 20px;
            border: 2px solid white;
            border-radius: 10px;
            font-family: "Inter", sans-serif;
            font-weight: 16px;
            font-weight: 500;
            color: white;
            background-color: transparent;
        }

        .mr {
            margin-right: 10%;
        }

        .heading-problem-solve {
            right: 90PX;
        }

        .bg-light {
            box-shadow: 0px -9px 14px 0px #00000033;
            background-color: aliceblue;
            box-shadow: 0px 4px 6px 0px #0000004D;

        }

        .company-links {
            padding-left: 160px !important;
        }

        .company-links h6 {
            color: white;
        }

        .company-links ul {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .company-links ul li a {
            color: #EAEAEA;
            text-decoration: none;
        }

        .product-links {
            padding-left: 100px !important;
        }

        .product-links h6 {
            color: white;
        }

        .product-links ul {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .product-links ul li a {
            color: #EAEAEA;
            text-decoration: none;
        }

        .newsletter h6 {
            color: #EAEAEA;
        }

        .footer-main-section {
            border-bottom: 1px solid #EAEAEA;
            padding: 30px 0px 50px;

        }

        .our-plans {
            position: relative;
            right: 150px;
        }

        .main-image {
            background: transparent !important;
        }

        .big {
            border-radius: 10px;
        }

        .bg-industry-section {
            background: linear-gradient(#eff8ffe6, rgba(239, 248, 255, 0.9)),
                url('/Assest/') center/cover no-repeat;
        }

        .foot-logo {
            width: 200px;
        }

        .footer-first-section {

            border-bottom: 1px solid #FFFFFF;
        }

        .accordion-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .accordion-item {
            border: none !important;
            border-bottom: 1px solid #e0e0e0 !important;
        }

        .accordion-item:first-of-type {
            border-top-left-radius: .50rem !important;
            border-top-right-radius: .50rem !important;
        }

        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            cursor: pointer;
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .accordion-header:hover {
            background-color: #f9f9f9;
        }

        .accordion-header {
            border-top-left-radius: 0.50rem !important;
            border-top-right-radius: .50rem !important;
            border-bottom-left-radius: 0.50rem !important;
            border-bottom-right-radius: .50rem !important;
        }

        .accordion-question {
            font-family: "Inter", sans-serif;
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            padding: 0 20px;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .accordion-content.active {
            max-height: 200px;
            padding: 10px 20px 10px;
        }

        .accordion-answer {
            color: #666;
            line-height: 1.5;
            font-size: 16px;
        }

        .content-creation-bg {
            height: 650px;
            background: url(../public/Assest/images/content-creation-bg.png), linear-gradient(to right, #F9F9F9 50%, #F9F9F9 50%);
            background-repeat: no-repeat;
            background-size: 42%, 100%;
            background-position: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .content-creation-badge {
            background-color: #14C4F6;
            font-family: "Inter", sans-serif;
            font-weight: 500;
            color: white;
            font-size: 14px;
            padding: 5px 20px;
        }

        .content-creation-box {
            width: 75%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .content-creation-box h2 {
            font-family: "Inter", sans-serif;
            font-weight: 600;
            font-size: 36px;
            color: #000;
            width: 410px;
        }

        .content-creation-box p {
            font-family: "Inter", sans-serif;
            font-weight: 400;
            font-size: 18px;
            color: #000;
        }

        .content-creation-box ul {
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .content-creation-box ul li {
            list-style: none;
            font-family: "Inter", sans-serif;
            font-weight: 400;
            font-size: 18px;
            color: #000;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .contact-us-btn {
            background: linear-gradient(90deg, #0070E2 0%, #108AEA 100%) !important;
            border: none !important;
            border-radius: 50px !important;
            font-family: "Inter", sans-serif;
            font-weight: 500 !important;
            font-size: 16px;
            color: white;
            padding: 11px 35px !important;
        }

        .contact-us-btn-2 {
            background-color: transparent;
            border: 1px solid #000 !important;
            border-radius: 50px !important;
            font-family: "Inter", sans-serif;
            font-weight: 500 !important;
            font-size: 16px;
            color: #000;
            padding: 11px 35px !important;
        }

        .slider-container {
            width: 100%;
            height: 600px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .gsaas_para {
            width: 85%;
            line-height: 1.6;
        }

        .myslider-container {
            width: 100%;
            height: 430px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .myslide {
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ddd;
        }

        .myslide.active {
            opacity: 1;
        }

        .slide-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dots-container {
            position: absolute;
            bottom: -40px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }

        .dot {
            width: 49px;
            height: 5px;
            border-radius: 3px;
            background-color: #EDEBEB;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dot.active {
            background-color: #14202E9E;
        }

        .newslider-container {
            width: 100%;
            height: 420px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .newmyslide {
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .newmyslide.active {
            opacity: 1;
        }

        .newslide-image {
            width: 100%;
            height: 100%;
        }

        .newdots-container {
            position: absolute;
            bottom: -15px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }

        .newdot {
            width: 49px;
            height: 5px;
            border-radius: 3px;
            background-color: #EDEBEB;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .newdot.active {
            background-color: #FFFFFF9E;
        }


        .slider {
            position: relative;
            overflow: hidden;
        }

        .slider__track {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-inline: 1rem;
            scroll-behavior: smooth;
            list-style-type: none;
            padding: 0;
            margin-right: calc(0.8rem * -1);
            gap: 15px;
        }

        .slider__buttons {
            .slider__button {
                border: none;
                cursor: pointer;
                background-color: transparent;

                &[disabled] {
                    opacity: 0.5;
                }
            }
        }

        .slider__button--prev {
            rotate: 180deg;
        }

        .slide {
            width: 170px;
            text-align: center;
        }

        .category-box {
            width: 115px;
            height: 115px;
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #eaeaea;
            margin: auto;
        }

        .category-box-title {
            font-family: "Inter", sans-serif;
            font-weight: 400;
            font-size: 18px;
            color: #000;
        }

        .slider__track::-webkit-scrollbar {
            display: none;
        }

        .slider__track {
            scrollbar-width: none;
        }

        .heading {
            padding: 20px !important;
        }

        .features-bubble {
            top: -25px;
            right: -95px;
        }

        .feature-boxes-1 {
            justify-content: space-between;
        }

        .tablet-box-1 {
            display: none;
        }

        .free {
            justify-content: space-between;
        }

        .newsletter input {
            padding: 12px 10px !important;
            border-radius: 10px !important;
        }

        .foot-sub {
            border-radius: 12px !important;
            border-radius: 10px !important;
            font-weight: 500;
        }

        .free {
            justify-content: center;
        }

        .invoice-sales {
            height: 350px !important;
            object-fit: fill;
        }

        .foot-sub {
            width: 100% !important;
            padding: 10px !important;
            font-weight: 500 !important;
        }

        @media only screen and (max-width: 1300px) {
            .navbar-nav {
                gap: 0px !important;
            }
        }


        /* Media */
        @media only screen and (max-width: 1024px) {
            .benefits-cards {
                height: auto;
            }

            .navbar {
                padding-top: 20px !important;
            }

            .navbar-toggler {
                border-color: #fff !important;
                background-color: #fff !important;
            }

            .slider-container {
                height: 400px;
            }

            .dashboardimg-section {
                margin-top: -365px;
                margin-bottom: 50px;
            }

            .fix-it-box {
                padding: 30px;
            }

            .features-bubble {
                display: none;
            }

            .features-main-img {
                right: 0px;
            }

            .feature-boxes-1 {
                justify-content: start;
                gap: 18px;
            }

            .tablet-box-1 {
                display: block;
            }

            .tablet-box-2 {
                display: none;
            }

            .newslider-container {
                height: 300px;
            }

            .newslide-image {
                height: 340px;
            }

            .content-creation-box {
                width: 100%;
            }

            .contact-us-btn,
            .contact-us-btn-2 {
                padding: 11px 20px !important;
            }

            .free {
                justify-content: start;
                margin-top: 20px !important;
            }

            .free-quote-badge {
                display: none;
            }

            .company-links,
            .product-links,
            .newsletter {
                padding: 10px !important;
            }

            .footer-main-section {
                padding: 10px 0px 35px;
            }

            .newdots-container {
                bottom: 90px;
            }

            .border-work>h2 {
                font-size: 30px;
            }

            .border-work>p {
                font-size: 20px;
            }

            .benefits-bubble {
                right: -65px;
            }

            .slider__track {
                gap: 13px;
            }
        }



        @media only screen and (max-width: 600px) {
            .tablet-box-1 {
                display: none;
            }

            .newdots-container {
                bottom: -15px;
            }

            .free {
                margin-top: 0px !important;
            }

            .main-titl>h1 {
                font-size: 36px;
                padding: 0 !important;
            }

            .lead {
                font-size: 21px !important;
            }

            .main-titl .d-flex {
                flex-wrap: wrap !important;
            }

            .dashboardimg-section {
                margin-top: -360px !important;
                margin-bottom: 70px;
            }

            .hero-section-btn-two {
                padding: 10px 85px !important;
            }

            .slider-container {
                height: 190px;
            }

            .leading-heading,
            .border-work>h2 {
                font-size: 32px;
            }

            .leading-company-logo {
                width: 180px !important;
            }

            .leading-company-logo img {
                width: 100%;
            }

            .work-broken-section {
                padding: 40px 0px;
                margin-top: 40px;
                background: black;
            }


            .fix-it-box {
                padding: 30px;
                margin-top: 25px;
            }

            .heading-problem-solve {
                right: inherit;
                position: unset !important;
            }

            .problem-parag p:first-child {
                font-size: 21px !important;
            }

            .heading.py-5 {
                padding: 0px 0px 20px !important;
            }

            .problem-para {
                font-size: 16px !important;
                margin-top: 0 !important;
            }

            .problem-main-img,
            .solving-bubble {
                display: none;
            }

            .heading-problem-solve .display-4 {
                font-size: 32px !important;
                width: 100% !important;
            }

            .sec-heading h2 {
                font-size: 32px !important;
            }

            .benefits-cards {
                height: auto !important;
            }

            .industry-title {
                font-size: 32px;
            }

            .features-main-img {
                display: none;
            }

            .heading h2 {
                font-size: 31px !important;
            }

            .whygsaas .heading h2 {
                font-size: 32px !important;
            }

            .whygsaas .heading h2 br {
                display: none;
            }

            .whygsaas .heading h2 span {
                padding: 0px !important;
            }

            .heading .feature-section {
                right: 0px !important;
            }

            .feature-section p,
            .border-work>p {
                font-size: 21px !important;
            }

            .feature-section p br {
                display: none;
            }

            .feature-boxes-section .row {
                justify-content: center !important;
                gap: 0px 15px;
            }

            .feature-boxes-section-2 {
                width: 100% !important;
                flex-wrap: wrap;
            }

            .random-column {
                width: 156px !important;
            }

            .random-column-2 {
                width: 93% !important;
            }

            .content-creation-bg {
                height: 100% !important;
                background: #f9f9f9 !important;
                padding-bottom: 50px;
            }

            .content-creation-box {
                width: 100%;
            }

            .content-creation-box div {
                flex-wrap: wrap;
            }

            .newslider-container {
                height: 200px;
                margin-top: 50px;
            }

            .newslide-image {
                height: 222px;
            }



            .free-quote-badge {
                display: none;
            }


            .footer-first-section .d-flex {
                flex-wrap: wrap !important;
                justify-content: flex-start !important;
                margin-top: 10px;
            }

            .footer-main-section {
                padding: 0px 0px 50px !important;
            }

            .company-links,
            .product-links {
                padding-left: 15px !important;
                padding-top: 15px !important;
            }

            .newsletter {
                padding-top: 15px;
            }

            .dots-container,
            .newdots-container {
                width: 95% !important;
            }

            .benefits-cards-title {
                font-size: 21px !important;
            }

            .content-creation-box ul li,
            .content-creation-box p {
                font-size: 16px !important;
            }

            .footer-first-section p {
                font-size: 18px !important;
            }

            .footer-first-section .kaushan {
                font-size: 32px !important;
            }

            .whygsaas .heading img {
                display: none;
            }

            .clients-logos {
                padding-bottom: 0px !important;
                border-bottom: none !important;
            }

            .whygsaas .heading.p-3 {
                padding: 0px !important;
            }

            .content-creation-bg {
                padding: 30px 0px !important;
            }

            .problem-solving-section.py-5 {
                padding-top: 0px !important;
                padding-bottom: 20px !important;
            }

            #navbarNav {
                background: white;
                padding: 20px;
            }

            #navbarNav ul li a {
                color: black !important;
            }

            #navbarNav .login {
                margin-top: 20px;
            }

            #navbarNav .login a:first-child {
                background-color: #e7e7e7 !important;
            }

            .features-bubbl {
                display: none;
            }

            .supply-chain {
                width: 60%;
            }

            .fix-it-box h2 {
                font-size: 36px;
            }

            .fix-it-box p {
                font-size: 16px;
            }

            .heading {
                padding: 10px !important;
            }

        }

        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }

        .contact-container {
            max-width: 1200px;
            margin: 60px auto;
            background: #ffffff00;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 40px;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .form-section {
            background-color: #f1f5f9;
            padding: 30px;
            border-radius: 8px;
        }

        .container-fluid {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        .vision-container {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left: var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left: auto;
        }

        .text-muted {
            color: #2A2A2A !important;
        }

        .btn-primary {
            border: none;
            padding: 1.175rem 0.75rem;
            line-height: .5;
            Width: 186px;
            height: 42px;
            Top: 375px;
            Left: 88px;
            border-radius: 10px;
            background-image: linear-gradient(90deg, #023850 0%, #0380B6 100%);
            color: white;
            /* ensure text is visible */

        }


        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .icon-text {
            margin-left: 10px;
        }

        .cta-section {
            background: linear-gradient(90deg, #13B5F3 0%, #108AEA 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            height: auto;
        }

        .cta-section .btn-outline-light {
            margin-right: 10px;
        }


        h4.fw-bold {
            width: 268px;
            height: 48px;
            top: 196px;
            left: 88px;


            font-family: Inter;
            font-weight: 600;
            font-style: Semi Bold;
            font-size: 40px;
            line-height: 100%;
            letter-spacing: 0%;
        }

        @media (min-width: 1200px) {

            .h2,
            h2 {
                font-size: 3rem;
            }
        }

        p.para {
            width: 496px;
            height: 224px;
            opacity: 1;
            top: 8px;
            left: 26.5px;
            font-family: Inter;
            font-weight: 400;
            font-style: Regular;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: 0%;
            color: #1C3A57;
        }

        .fw-bold-heading {
            width: 659px;
            height: 192px;
            top: 571px;
            left: 88px;

            font-family: Inter;
            font-weight: 600;
            font-style: Semi Bold;
            font-size: 48px;
            line-height: 64px;
            letter-spacing: 0%;

        }

        .responsive-heading {
            /*font-size: clamp(1.75rem, 3vw, 3rem);*/
            /*line-height: 1.3;*/
        }



        .stats-section {
            background: linear-gradient(to right, #1496ff, #2d9cdb);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .stats-section h2 {
            font-size: 4.5rem;
            margin-bottom: 10px;
            font-family: Inter;
            font-weight: 500;
            font-style: Medium;
            font-size: 80px;
            line-height: 88px;
            letter-spacing: 0%;
            text-align: center;

        }

        .stats-section p {
            margin-bottom: 0;
            font-size: 1.1rem;
            font-family: Inter;
            font-weight: 500;
            font-style: Medium;
            font-size: 24px;
            line-height: 32px;
            letter-spacing: 0%;
            text-align: center;

        }

        .info-section {
            padding: 60px 0;
        }

        .info-box {
            padding: 20px;
        }

        .info-box_2 {
            padding: 40px;

        }

        .info-box h3 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-custom {
            background-color: #1496ff;
            color: white;
            width: 186px;
            height: 41px;
            top: 1853px;
            left: 96px;
            border-radius: 10px;
        }

        .btn-custom:hover {
            background-color: #0f7bd1;
        }

        .border-primary {
            border-color: #108AEA !important;
        }

        .custom-img {
            width: 100%;
            height: 480px;
            object-fit: cover;
        }



        .meeting-about {
            width: 728;
            height: 480;
            top: 1491px;
            left: 712px;
        }

        .misson-section {
            margin-left: px;
        }

        .mission_heading {
            width: 67%;
            height: 40px;
            top: 1550px;
            left: 96px;
            font-family: Inter;
            font-weight: 600;
            font-style: Semi Bold;
            font-size: 32px;
            line-height: 40px;
            letter-spacing: 0%;
            color: #14293E;
        }



        .heading_vision {
            width: 50%;
            height: 40px;
            top: 25px;
            font-family: Inter;
            font-weight: 600;
            font-style: Semi Bold;
            font-size: 32px;
            line-height: 40px;
            letter-spacing: 0%;
        }


        .vision_para {
            max-width: 100%;
            width: 551px;
            /* Will be overridden at smaller breakpoints */
            height: auto;
            line-height: 1.6;

        }

        /* Large screens (<= 1440px) */
        @media (max-width: 1440px) {
            .vision_para {
                width: 500px;
                font-size: 19px;
                left: 28px;
            }
        }

        /* Medium screens (<= 1024px) */
        @media (max-width: 1024px) {
            .vision_para {
                width: 450px;
                font-size: 18px;
                left: 24px;
            }
        }

        /* Tablets (<= 768px) */
        @media (max-width: 768px) {
            .vision_para {
                width: 100%;
                font-size: 16px;
                left: 20px;
                padding-right: 20px;
            }
        }

        /* Mobile (<= 425px) */
        @media (max-width: 425px) {
            .vision_para {
                width: 100%;
                font-size: 15px;
                left: 15px;
                padding-right: 15px;
            }
        }

        /* Small mobile (<= 375px) */
        @media (max-width: 375px) {
            .vision_para {
                font-size: 14px;
                left: 12px;
            }
        }

        /* Extra small devices (<= 320px) */
        @media (max-width: 320px) {
            .vision_para {
                font-size: 13px;
                left: 10px;
            }
        }


        .section-title {
            font-weight: 600;
            font-size: 40px;
            text-align: center;
            margin-bottom: 40px;
            position: relative;



        }



        .highlights-circle {

            position: relative;
            background-image: url(./public/Assest/images/Ellipse_1.png);
            background-size: cover;
        }

        .partner-icon {
            color: #14202E66;
            font-weight: 700;
            font-family: 'Sen', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: bold;
            size: 28px;
            letter-spacing: 2px;
            margin-bottom: 10px;

        }

        .partner-icon::before {
            content: '✴';
            margin-right: 8px;
            font-size: 1.2rem;
            color: #999;
        }

        .dots {
            position: absolute;
            width: 80px;
            height: 80px;
            background-repeat: no-repeat;
            background-size: contain;
            z-index: 2;
        }

        .dot-pink {
            background-image: url(./public/Assest/images/Star_Left_1.png);
            top: 50px;
            left: 5%;
        }

        .dot-yellow {
            background-image: url(./public/Assest/images/star-right_2.png);
            top: 100px;
            right: 5%;
        }

        .dot-blue {
            background-image: url(./public/Assest/images/blue-star.png);
            bottom: 100px;
            left: 10%;
        }

        .dots {
            position: absolute;
            width: 80px;
            height: 80px;
            background-repeat: no-repeat;
            background-size: contain;
            z-index: 2;
        }

        .dot-pink {
            background-image: url(./public/Assest/images/Star_Left_1.png);
            top: 50px;
            left: 5%;
        }

        .dot-yellow {
            background-image: url(./public/Assest/images/star-right_2.png);
            top: 100px;
            right: 5%;
        }

        .dot-blue {
            background-image: url(./public/Assest/images/blue-star.png);
            bottom: 100px;
            left: 10%;
        }

        /* Large Desktops / 4K */
        @media (min-width: 1441px) {
            .dots {
                width: 100px;
                height: 100px;
                position: absolute;
                top: 61%;
                right: -5%;
            }

            .dot-pink {
                top: 28%;
                left: -5%;
                position: absolute;
            }

        }

        /* Full HD Desktop */
        @media (max-width: 1440px) and (min-width: 1281px) {
            .dots {
                width: 90px;
                height: 90px;
            }
        }

        /* Laptops */
        @media (max-width: 1280px) and (min-width: 1025px) {
            .dots {
                width: 80px;
                height: 80px;
            }
        }

        /* Tablets (Landscape) */
        @media (max-width: 1024px) and (min-width: 769px) {
            .dot-yellow {
                width: 60px;
                height: 60px;
            }

            .dot-pink {
                top: 40px;
                left: 3%;
            }

            .dot-yellow {
                top: 80px;
                right: 3%;
            }

            .dot-blue {
                bottom: 80px;
                left: 8%;
            }
        }

        /* Tablets (Portrait) */
        @media (max-width: 768px) and (min-width: 426px) {
            .dots {
                width: 50px;
                height: 50px;
            }

            .dot-pink {
                top: 30px;
                left: 2%;
            }

            .dot-yellow {
                top: 60px;
                right: 2%;
            }

            .dot-blue {
                bottom: 60px;
                left: 5%;
            }
        }

        /* Mobile Phones */
        @media (max-width: 425px) and (min-width: 320px) {
            .dots {
                width: 35px;
                height: 35px;
            }

            .dot-pink {
                top: 20px;
                left: 2%;
            }

            .dot-yellow {
                top: 40px;
                right: 2%;
            }

            .dot-blue {
                bottom: 40px;
                left: 4%;
            }
        }

        /* Extra Small Phones */
        @media (max-width: 319px) {
            .dots {
                width: 30px;
                height: 30px;
            }

            .dot-pink {
                top: 15px;
                left: 1%;
            }

            .dot-yellow {
                top: 30px;
                right: 1%;
            }

            .dot-blue {
                bottom: 30px;
                left: 3%;
            }
        }


        .row {
            --bs-gutter-x: 0.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x) * -.5);
            margin-left: calc(var(--bs-gutter-x) * -.5);
        }

        @media only screen and (max-width: 600px) {
            .footer-first-section .d-flex {
                flex-wrap: wrap !important;
                justify-content: flex-start !important;
                margin-top: 7px;
                padding: 10px;
            }
        }

        @media only screen and (max-width: 600px) {
            .footer-first-section .kaushan {
                font-size: 23px !important;
            }
        }

        .fw-bold-heading {
            font-size: 1.25rem;
            font-weight: 700;
        }

        @media (min-width: 992px) {
            .fw-bold-heading {
                font-size: 1.5rem;
            }
        }

        .fw-bold {
            font-weight: 700;
        }

        @media (max-width: 576px) {
            h2 {
                font-size: 1.25rem;
                line-height: 1.4;
                width: 294px;
            }
        }

        .mission_heading {
            font-size: 1.5rem;
            font-weight: 700;
        }

        @media (min-width: 768px) {
            .mission_heading {
                font-size: 2rem;
                width: 294px;
            }

        }

        @media (min-width: 768px) {
            .mission-section {
                padding-right: 1.5rem !important;
                padding-left: 11.5rem !important;
            }
        }

        .vision_col {
            padding-left: 76px;
        }

        @media (max-width: 1440px) {
            .vision_col {
                padding-left: 40px;
            }
        }

        @media (max-width: 1024px) {
            .vision_col {
                padding-left: 50px;
            }
        }

        @media (max-width: 768px) {
            .vision_col {
                padding-left: 20px;
            }
        }

        @media (max-width: 425px) {
            .vision_col {
                padding-left: 15px;
            }
        }

        @media (max-width: 375px) {
            .vision_col {
                padding-left: 10px;
            }
        }

        @media (max-width: 320px) {
            .vision_col {
                padding-left: 5px;
            }
        }


        @media (max-width: 425px) {
            .heading_vision {
                font-size: 1.4rem;
                width: 233px;
            }
        }

        .mission_heading {
            font-size: 1.5rem;
            font-weight: 600;
            width: 228px;
        }

        @media (min-width: 768px) {
            .mission_heading {
                font-size: 2rem;
            }

            .heading_vision {
                width: 297px;
            }

        }


        .mission_para {
            line-height: 1.6;
            width: 100%;
            max-width: 476px;
            height: auto;
        }

        @media (max-width: 1440px) {
            .mission_para {
                font-size: 18px;
                margin-left: 28px;
            }
        }

        @media (max-width: 1024px) {
            .mission_para {
                font-size: 17px;
                margin-left: 24px;
            }
        }

        @media (max-width: 768px) {
            .mission_para {
                font-size: 16px;
                margin-left: 20px;
            }
        }

        @media (max-width: 425px) {
            .mission_para {
                font-size: 15px;
                margin-left: 16px;
            }
        }

        @media (max-width: 375px) {
            .mission_para {
                font-size: 14px;
                margin-left: 12px;
            }
        }

        @media (max-width: 320px) {
            .mission_para {
                font-size: 13px;
                margin-left: 8px;
            }
        }
    </style>
</head>
@section('content')
<!-- wrapper start -->
<div class="wrapper">
    <!-- Bootstrap 5 About GSAAS Section -->
    <section class="py-5" style="background-color: #f3fcff;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Text Column -->
                <div class="col-lg-6 mb-4 mb-lg-0 ">
                    <h2 class="fw-bold about-gsaas"
                        style="color: #2A2A2A; font-size: 47px; font-weight: 600; line-height: 100%; ">About GSAAS
                    </h2>
                    <p class="gsaas_para mt-4" style="color: #2A2A2A;">
                        GSaaS provides flexible SaaS solutions that help businesses across Australia operate more
                        efficiently and grow sustainably. With over 10 years of experience, support has been offered to
                        organisations from startups in Brisbane to established enterprises in Melbourne by delivering
                        software designed to meet diverse business needs and ambitions.
                    </p>
                    <a href="/contact_us" class="btn btn-primary mt-3 border border-0"
                        style="border-radius: 10px; font-weight: 500;">
                        Contact us Today →
                    </a>
                </div>

                <!-- Image Column -->
                <div class="col-lg-6 text-center">
                    <img src="./public/Assest/images/Rectangle 1702.png" alt="Person working on computer"
                        class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Business Success Section -->


    <div class="section-row  align-items-center p-3">
        <!-- Heading and Subheading -->
        <section class="py-2 bg-white">
            <div class="container">
                <div class="row gx-2 gy-4 align-items-center">
                    <!-- Heading and Subheading -->
                    <div class="col-12 col-md-6">
                        <h1 class="fw-bold text-center text-md-start responsive-heading">
                            Driving Business Success <br/>
                            through  <span style="color:#108AEA" class="text-">Expertise</span> <br/> &amp; <span 
                                    style="color:#108AEA" class="text-">Innovation</span>
                        </h1>
                    </div>


                    <!-- Paragraph Content -->
                    <div class="col-12 col-md-6">
                        <div style="border-left: 3px solid #108AEA" class="ps-0 ps-md-4  ">
                            <h6 class="fw-bold text-black ms-4">Why Choose GSaaS?</h6>
                            <p class="ps-2 ps-md-3 text-center text-md-start mb-0">
                            <ul>
                                <li>Local Expertise: Proudly Australian-based, with a deep understanding of the
                                    country’s diverse business landscape and regulatory environment.</li>
                                <li>LocalFlexible Solutions: Software designed to adapt to businesses of all sizes and
                                    industries across Australia.</li>
                                <li>Trusted by Industry: Serving over 50 sectors with a strong client retention rate of
                                    80%.</li>
                                <li>Commitment to Innovation: Investing in cutting-edge technology and actively
                                    incorporating client feedback.</li>
                            </ul>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!-- Banner and counter Section -->
    <!-- Hero Image -->
    <div class="position-relative">
        <img src="./public/Assest/images/banner_1.jpg" class=" custom-img" alt="Office">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 123, 255, 0.5);">
        </div>
    </div>


    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container-fluid">
            <div class="row text-center d-flex">
                <div class="col-md-4 mb-4 mb-md-0 ">
                    <h2 class="stas">10+</h2>
                    <p>Years of Experience</p>
                    <div class="bb" ></div>
                </div>
                
                <div class="col-md-4 px-4 mb-4 mb-md-0 ">
                    <h2 class="stas">80%</h2>
                    <p>Client Retention Rate</p>
                    <div class="bb" ></div>
                </div>
                
                <div class="col-md-4">
                    <h2 class="stas">50+</h2>
                    <p>Industries Served</p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Mission Section -->

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <!-- Left Content Column -->
            <div class="col-12 col-md-6 d-flex flex-column align-items-center align-items-md-start text-center text-md-start px-3 px-md-5 py-4 mission-section mt-3 mb-3">
                <h3 class="mission_heading">
                    Our Mission
                </h3>
    
                <div class="ps-0 ps-md-4 mt-3 mt-md-0 w-100" style="max-width: 500px; border-left: 3px solid #0070E2;">
                    <p class="mission_para mb-0" style="font-style: medium;">
                        To empower Australian businesses with innovative, reliable software that drives growth,
                        streamlines operations, and fosters lasting success. Building strong partnerships based on trust
                        and excellence is at the core of what we do, working closely with clients to unlock their full
                        potential.
                    </p>
                </div>
                <!--<a href="contact_us" >-->
                <!--<button class="btn text-white mt-5" style="background: #108AEA;">-->
                <!--    Contact Us Today-->
                <!--    <i class="fa-solid fa-arrow-right"></i>-->
                <!--</button>-->
                <!--</a>-->
            </div>
    
            <!-- Right Image Column -->
            <div class="col-12 col-md-6 p-0">
                <img src="./public/Assest/images/meeting_about.jpg" class="img-fluid w-100"
                    style="height: 480px; object-fit: cover;" alt="meeting">
            </div>
        </div>
    </div>



    <!-- Vision Section -->

    <div class="container-fluid vision-container py-0 px-3">
        <div class="row align-items-center">
            <!-- Text Column -->
            <div class="col-12 col-md-6 order-1 order-md-2 vision_col d-flex flex-column align-items-center align-items-md-start text-center text-md-start px-3 px-md-5 mt-4 mb-3">
                <h3 style="margin-bottom:12px" class="heading_vision">Our Vision</h3>
    
                <div class="ps-0 ps-md-4 mt-1 mt-md-0 w-100" style="max-width: 500px; border-left: 3px solid #0070E2;">
                    <p class="vision_para mb-0">
                        To become Australia’s leading SaaS provider through pioneering technology and customer-focused
                        solutions. Continuous innovation and responsiveness ensure clients have the tools needed to stay
                        competitive in a rapidly evolving market.
                    </p>
                </div>
    
               <!--<a href="contact_us" >-->
               <!-- <button class="btn text-white mt-5 mb-4" style="background: #108AEA;">-->
               <!--     Contact Us Today-->
               <!--     <i class="fa-solid fa-arrow-right"></i>-->
               <!-- </button>-->
               <!-- </a>-->
            </div>
    
            <!-- Image Column -->
            <div class="col-12 col-md-6 order-2 order-md-1  mb-md-0 text-center text-md-start p-0">
                <img src="./public/Assest/images/about_design.jpg" class="img-fluid w-100"
                    style="height: 480px; object-fit: cover;" alt="Buildings">
            </div>
        </div>
    </div>





    <!--End Section banner and counter  -->
</div>
<!-- Conatact us wrapper end -->
<!-- Start of partner Section -->
<div class="container  position-relative">

    <!-- Dots for decoration -->
    <!--<span class="dots dot-pink"></span>-->
    <!--<span class="dots dot-yellow"></span>-->
    <!--<span class="dots dot-blue"></span>-->
    <!--<div class="dots dots"></div>-->


    <!-- Title -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">

                <!--<h4 class="section-title d-flex align-items-center justify-content-center">-->
                <!--    <div class="highlights-circle  d-inline-flex align-items-center justify-content-center me-2"-->
                <!--        style="height: 50px; width: 80px; border-radius: 50%;">-->
                <!--        Our-->
                <!--    </div>-->
                <!--    <span class="highlights-circl" >Trusted Partners</span>-->
                <!--</h4>-->
            </div>
        </div>
    </div>

    <!-- <h3 style="position: relative; left: 5%; background:black;padding:10px;width:40%;color:white" class="fw-bold mb-3">-->
    <!--    We Work Alongside Industry Such as:-->
    <!--</h3>-->




    <!-- Partner Grid -->
    <!--<div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 text-center g-4">-->
        <!-- Repeat as needed -->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">InnoTech</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">ByteCorp</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">DataWave</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">NetFusion</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">CloudSync</div>-->
    <!--    </div>-->

    <!--    <div class="col">-->
    <!--        <div class="partner-icon">InnoTech</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">ByteCorp</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">DataWave</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">NetFusion</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">CloudSync</div>-->
    <!--    </div>-->

    <!--    <div class="col">-->
    <!--        <div class="partner-icon">InnoTech</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">ByteCorp</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">DataWave</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">NetFusion</div>-->
    <!--    </div>-->
    <!--    <div class="col">-->
    <!--        <div class="partner-icon">CloudSync</div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
<!-- End of partner Section -->
<!-- CTA Section -->



<!--CTA-->
 <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3 redy">Ready to Advance Your Business?</h2>
                    <p class="mb-4">Partner with GSaaS for expert guidance and strategies designed to drive growth and success.
                    </p>
                    <!--<div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">-->
                    <!--    <a href="#" class="btn btn-outline-light rounded">-->
                    <!--        Contact Us Today-->
                    <!--    </a>-->
                        <a href="/contact_us" class="btn btn-light gradient-text " style="color: #00a7e9; font-weight: 700;">
                            Request Your Free Consultation
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection