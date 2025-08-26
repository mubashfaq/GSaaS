{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
 Contact Us 
   
@endsection
@section('content')
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
  <title>GSaaS</title>
  <style>
  
   @media (min-width:320px) and (max-width:576px){
       .common-banner-section{
           background:transparent !important;
       }
       body{
           overflow-x:hidden !important;
       }
       .days{
           font-size:15px !important;
       }
       hr{
           display:none !important;
       }
       .pp{
           width:70%;
       }
       .need{
           overflow-x:hidden !important;
          position:relative !important;
       }
       .p{
           width:70%;
           position:relative;
           left:60px;
           margin-top:15px;
       }
       .contact{
           font-size:30px !important;
          
       }
       
        .need{
            position:absolute;
            bottom:30px !important;
        }
       
   }
  
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
           
    .common-banner-section{
        background-image:url('./public/Assest/images/contact-background.jfif');
    }
     

        .ResellerRequirements {
            background-image: url('./public/Assest/images/Rectangle16.png');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .partner-card {
            height: 100%;
        }

        .partner-list-descp p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .cta-section {
            background: linear-gradient(90deg, #0ea5e9, #2563eb);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .cta-section .btn-outline-light {
            margin-right: 10px;
            width: 211px;
            height: 56px;
            border-width: 1px;
            gap: 8px;
            border-radius: 4px;
            padding: 16px;
        }

        /* Responsive adjustments */
        @media (max-width: 1199.98px) {
            .fix-it-box h2 {
                font-size: 36px;
            }

            .border-work>h2 {
                font-size: 32px;
                line-height: 1.3;
            }

            .border-work>p {
                font-size: 20px;
            }
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: white;
                padding: 20px;
                margin-top: 15px;
                border-radius: 10px;
            }

            .navbar-collapse .nav-link {
                color: black !important;
                padding: 10px 0;
            }

            .login {
                margin-top: 15px;
            }

            .login a:first-child {
                background-color: #e7e7e7 !important;
            }

            .company-links,
            .product-links {
                padding-left: 15px !important;
                margin-top: 30px;
            }

            .partner-card {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 767.98px) {
            .fix-it-box {
                padding: 30px;
            }

            .fix-it-box h2 {
                font-size: 32px;
            }

            .fix-it-box p {
                font-size: 16px;
            }

            .kaushan {
                font-size: 32px;
            }

            

            .free {
                justify-content: flex-start !important;
                margin-top: 20px;
            }

            .seller-title h1 {
                font-size: 32px;
            }

            .seller-descp p {
                font-size: 16px;
            }
        }

        @media (max-width: 575.98px) {
            .fix-it-box h2 {
                font-size: 28px;
            }

            .border-work>h2 {
                font-size: 24px;
            }

            .border-work>p {
                font-size: 18px;
            }

            .kaushan {
                font-size: 24px;
            }

            .seller-title h1 {
                font-size: 28px;
            }


            .cta-section .btn {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }


       


        ::placeholder {
            color: rgba(185, 194, 203, 0.8) !important;

        }

        body {
            font-family: 'Inter', sans-serif;
        }

       



        .company-links h6,
        .product-links h6,
        .newsletter h6 {
            color: white;
        }

        .company-links ul,
        .product-links ul {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-left: 0;
            list-style: none;
        }

        .company-links ul li a,
        .product-links ul li a {
            color: #EAEAEA;
            text-decoration: none;
        }

       

        .foot-logo {
            width: 200px;
            max-width: 100%;
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

       
        .accordion-question {
            font-family: "Inter", sans-serif;
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }

        .newsletter input {
            padding: 12px 10px !important;
            border-radius: 10px !important;
            background-color: transparent;
            color: white;
        }

        .newsletter input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .foot-sub {
            width: 100% !important;
            padding: 10px !important;
            font-weight: 500 !important;
            border-radius: 10px !important;
        }

        .gsaas-seller {
            background-color: #108AEA;
            background-image: url('./public/Assest/images/BackgroundPatterns.png');
            background-repeat: no-repeat;
            background-size: 70% auto;
            background-position: right center;
            color: white;
        }

      

        .ResellerRequirements {
            background-image: url('./public/Assest/images/Rectangle16.png');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .partner-card {
            height: 100%;
        }

        .partner-list-descp p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .cta-section {
            background: linear-gradient(90deg, #0ea5e9, #2563eb);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .cta-section .btn-outline-light {
            margin-right: 10px;
            width: 211px;
            height: 56px;
            border-width: 1px;
            gap: 8px;
            border-radius: 4px;
            padding: 16px;
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
          
        .ResellerRequirements {
            background-image: url('./public/Assest/images/Rectangle16.png');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .partner-card {
            height: 100%;
        }

        .partner-list-descp p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .cta-section {
            background: linear-gradient(90deg, #0ea5e9, #2563eb);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .cta-section .btn-outline-light {
            margin-right: 10px;
            width: 211px;
            height: 56px;
            border-width: 1px;
            gap: 8px;
            border-radius: 4px;
            padding: 16px;
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

    .faqs-heading {
      font-size: 30px !important;
      font-weight: 700;
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

  

    .big-card {
      position: relative;
      bottom: 100px;
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

      .para {
        color: #496179;
      }

      .form-heading {
        font-family: Inter;
        font-weight: 500;
        font-style: Medium;
        font-size: 32px;
        line-height: 40px;
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
     
      font-family: 'Segoe UI', sans-serif;
    }

    .contact-container {
        margin-top:-18px;
      max-width: 1200px;
      /*margin: 60px auto;*/
      background: #ffffff00;
      border-radius: 8px;
      padding: 10px;
    }

    
    .form-section {
      background-color: #f1f5f9;
      padding: 30px;
      border-radius: 8px;
    }

    .container-fluid {
      width: 100%;
      padding-right: var(--bs-gutter-x, 4.75rem);
      padding-left: var(--bs-gutter-x, 4.75rem);
      margin-right: auto;
      margin-left: auto;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
      padding: 1.175rem .75rem;
      line-height: 1.0;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }

    .support-info {
      margin-top: 45px;
    }

    .support-info a {
      text-decoration: none;
      color: #0d6efd;
    }

    .support-info a:hover {
      text-decoration: underline;
    }

    

    .cta-para {
      font-family: inter;
      font-weight: 400;
      font-style: Regular;
      font-size: 18px;
      line-height: 28px;
      letter-spacing: 0%;
      text-align: center;

    }

    .icon-text {
      margin-left: 10px;
    }

    text-muted {
      color: #14293E !important;
    }

    .text-primary {
      margin-top: 2px;
      width: 245px;
      height: 56px;
      left: 227px;
      gap: 8px;
      border-radius: 4px;
      padding: 16px;

    }

  

    .email-support {
      font-weight: 600;
      font-style: Semibold;
      line-height: 32px;
      letter-spacing: 0%;


    }

    .cta-section {
      background: linear-gradient(90deg, #0ea5e9, #2563eb);
      color: white;
      padding: 60px 0;
      text-align: center;
    }

    .cta-section .btn-outline-light {
      margin-right: 10px;
      width: 211px;
      height: 56px;
      border-width: 1px;
      gap: 8px;
      border-radius: 4px;
      padding: 16px;
      /* color: #FBFDFE; */

    }

    /* For Contact form content section  */
    @media (min-width: 768px) {
      .px-md-4 {
        padding-right: 1.5rem !important;
        padding-left: 6.5rem !important;
      }
    }

    /* contact us form title heading */
    .contact-heading {
      font-family: 'Inter', sans-serif;
      font-weight: 500;
      font-style: normal;
      /* "Medium" is a weight, not a valid CSS font-style */
      font-size: 20px;
      /* mobile base */
      line-height: 28px;
      letter-spacing: 0;
    }

    @media (min-width: 576px) {
      .contact-heading {
        font-size: 24px;
        line-height: 32px;
      }
    }

    @media (min-width: 768px) {
      .contact-heading {
        font-size: 28px;
        line-height: 36px;
      }
    }

    @media (min-width: 992px) {
      .contact-heading {
        font-size: 30px;
        line-height: 38px;
      }
    }

    @media (min-width: 1200px) {
      .contact-heading {
        font-size: 32px;
        line-height: 40px;
      }
    }

    /* end section of contact title heading  */

    @media only screen and (max-width: 600px) {
     
    }

    .wrapper {
      background-image: url('./public/Assest/images/contact-backgroud.jfif');
    }

   
   
     

        .contact-box {
            background: #ffffff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }
        .a{
            color:black !important;
        }
        .a:hover{
            color:black !important;
        }
        
        
       
       
</style>

    
    
    
  </style>
  
  
</head>

 <div>
    <section style="background-image: url('./public/Assest/images/contact-backgroud.jfif'); background-repeat: no-repeat; background-position: right;" class="common-banner-section bg-white">
        <div class="container contact-section py-5">
            <div class="text-center mb-5">
                <h2 style="color:#14293E;font-size:48px" class="fw-bold contact">Contact & Support</h2>
                <p class="p" style="font-size:15px">We’re here to assist you. Whether you have questions, need a consultation, or require <br/> support, don’t hesitate to get in touch.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 mb-4 mb-md-0">
                    <div style="padding:48px; background:#F4F8FB;" class="contact-box w-100">
    <h2 class="mb-1">Get in Touch with Us</h2>
    <p><small>Please fill out the form below, and one of our friendly team members will respond promptly.</small></p>

    <form id="contactForm">
        <div class="mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Your name" autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="example@company.com" autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+61 000 000 000" autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message *</label>
            <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Leave us a message"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
            Send Message
        </button>

        <div id="statusMessage" class="alert mt-3 d-none" role="alert"></div>
    </form>
</div>
                </div>
                <div class="col-12 col-md-5 d-flex align-items-start need">
                    <div style="position:relative;left:10%;font-weight:500 need mt-5" class="w-100 mt-4 mt-md-0 ps-md-4">
                        <h6 style="color:#496179"  class="fw-bold">Need Immediate Assistance?</h6>
                        <p class="pp" >Chat to Support: Available 24/7 for instant help via our live chat.</p>
                        <hr>
                        <h6 style="color:#496179"  class="fw-bold">Call Us</h6>
                        <p class="days">Monday - Friday, 9:00 AM - 6:00 PM AEST</p>
                        <span class="mb-1 fw-bold ">Phone:</span> <a href="tel:+6180056676" class="text-decoration-none text-dark">+61 8005 6676</a>
                        <!--<span class="fw-bold">Alternate:</span> <a href="tel:+611619876543" class="text-decoration-none text-dark">+61 161 987 6543</a>-->
                        <hr>
                        <h6 style="color:#496179"  class="fw-bold">Email Support</h6>
                        <p class="pp" >Send your enquiry anytime and expect a reply within 24 hours.</p>
                        <span class="fw-bold">Email: </span><a href="mailto:sales@gsaas.com.au" class="text-decoration-none text-dark">sales@gsaas.com.au</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

  
  
  
   <!--FAQS_SECTION-->
     <div class="faq-container container bg-white py-3">
         <h1 style="font-size:40px" class="faq-heading">Frequently Asked Questions</h1>
    <div style="background-color:white;padding:10px;" class="faq-card shadow-lg rounded" >
 
  <div class="faq-accordion p-4" id="faqAccordion">

    <!-- FAQ Item Template -->
    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingOne">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
          What services do you offer?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         We provide comprehensive business management solutions including CRM, HRM, invoicing, project management, and more.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingTwo">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
          How do I schedule a consultation?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseTwo" class="faq-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Use our contact form or call us during office hours to book a free consultation.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingThree">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false">
          What industries do you specialise in?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseThree" class="faq-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Our platform supports over 50 industries including retail, healthcare, hospitality, manufacturing, and supply chain.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFour">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false">
          What is your typical project timeline?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFour" class="faq-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Project timelines vary depending on scope; we work closely with clients to set realistic milestones.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFive">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false">
          What Kind Of Commission Can I Earn?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFive" class="faq-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          You will receive competitive recurring commissions on all subscription sales from your referrals.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingSix">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false">
          Do you provide ongoing support after the project?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSix" class="faq-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Yes, we offer ongoing support packages tailored to your business needs.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <h2 class="faq-header" id="headingSeven">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false">
          How are your consultants qualified?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSeven" class="faq-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Our team consists of experienced professionals with deep expertise in business operations and software solutions.
        </div>
      </div>
    </div>

  </div>
  </div>
</div>



<!--CTA-->
 <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">Ready to Transform Your Business?</h2>
                    <p class="mb-4">Partner with GSaaS for expert guidance and strategies designed to drive growth and success.
                    </p>
                    <!--<div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">-->
                    <!--    <a href="#" class="btn btn-outline-light rounded">-->
                    <!--        Contact Us Today-->
                    <!--    </a>-->
                    <!--    <a href="#" class="btn btn-light gradient-text px-3 py-2" style="color: #00a7e9; font-weight: 700;">-->
                    <!--        Request Your Free Consultation-->
                    <!--    </a>-->
                    <!--</div>-->

                </div>
            </div>
        </div>
    </section>



 
  
  
   <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!--FORM_STATUS-->


<script>
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const statusMessage = document.getElementById('statusMessage');
    statusMessage.classList.add('d-none');
    statusMessage.innerHTML = '';

    submitBtn.disabled = true;
    submitBtn.innerText = 'Sending...';

    fetch("/contact", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            message: document.getElementById("message").value,
        })
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Send Message';

        statusMessage.classList.remove('d-none');
        statusMessage.classList.remove('alert-danger', 'alert-success');

        if (data.success) {
            statusMessage.classList.add('alert-success');
            statusMessage.innerHTML = data.message;
            document.getElementById('contactForm').reset();
        } else {
            statusMessage.classList.add('alert-danger');
            statusMessage.innerHTML = data.message || 'An error occurred';
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Send Message';
        statusMessage.classList.remove('d-none', 'alert-success');
        statusMessage.classList.add('alert-danger');
        statusMessage.innerHTML = 'Something went wrong. Please try again.';
    });
});
</script>




    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // FAQ functionality
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(question => {
                question.addEventListener('click', function () {
                    const icon = this.querySelector('.faq-icon');

                    // Toggle icon
                    if (icon.classList.contains('fa-plus')) {
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus');
                    } else {
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                    }
                });
            });

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection

