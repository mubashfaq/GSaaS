{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
Become a Reseller
   
@endsection
@section('content')
<!-- wrapper start -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller_Partner</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="https://gsaas.com.au/uploads/logo/favicon.png?1752042036" type="image/x-icon">

    <link rel="stylesheet" href="./public/Css/style.css">


    <style>
     
    
    
    @media (min-width:320px) and (max-width:576px){
        .grow-left-side{
            position:relative;
            top:50px;
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

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-answer.show {
            max-height: 500px;
            padding-top: 10px;
        }

        .faq-question {
            cursor: pointer;
        }

        .faq-question .faq-icon {
            transition: transform 0.3s ease;
        }

        .faq-question.active .faq-icon {
            transform: rotate(45deg);
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

            .faqs-heading {
                font-size: 24px !important;
            }

            .cta-section .btn {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }


        .accordion-header i {
            background-color: black;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }


        ::placeholder {
            color: white !important;

        }

        body {
           
            font-family: 'Inter', sans-serif;
        }

        .navbar {
            background: #12aaf1;
            padding: 15px 0 !important;
        }

        .nav-item .nav-link {
            font-weight: 500;
            color: white !important;
        }

        .fix-it-box {
            background-image: url('./public/Assest/images/fix-it-bg.png');
            background-size: cover;
            background-position: center;
            padding: 40px;
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
            border: 1px solid white !important;
            border-radius: 4px;
            font-family: "Inter", sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: white;
            text-decoration: none;
            padding: 11px 45px;
        }

        .login a {
            border-radius: 10px;
            width: 116px;
        }

        .border-work {
            border: 2px solid black;
            padding: 20px !important;
            border-radius: 4px;
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
            margin: 0 !important;
        }

        .kaushan {
            font-family: "Antonio", sans-serif;
            font-weight: 500;
            font-style: normal;
            font-size: 44px;
            color: white;
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

        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
           
            cursor: pointer;
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .accordion-header:hover {
            background-color: #f9f9f9;
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

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-answer.show {
            max-height: 500px;
            padding-top: 10px;
        }

        .faq-question {
            cursor: pointer;
        }

        .faq-question .faq-icon {
            transition: transform 0.3s ease;
        }

        .faq-question.active .faq-icon {
            transform: rotate(45deg);
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

            .faqs-heading {
                font-size: 24px !important;
            }

            .cta-section .btn {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 0 !important;
            }
        }
    </style>
</head>


<!-- Main-Section -->
     <section class="gsaas-seller p-4">
        <div class="container ">
            <div class="row justify-content-center text-center">
                <div style="margin:14px;" class="col-lg-8">
                    <h2 class="mb-2">Become a GSaaS Reseller Partner</h2>
                    <p class="mb-2">Join our reseller program to expand your business by offering GSaaS to your customers. Enjoy attractive margins, 
                    dedicated support, and seamless onboarding.</p>
                    <button
                        style="background: linear-gradient(90deg, #023850 0%, #0380B6 100%); border: 1px solid white;"
                        class="btn btn-dark mb-2 mt-3">
                        Become a GSaaS Partner <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- grow-business -->
    <section  class="grow-business bg-light py-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 grow-left-side">
                    <h2 class="mb-4 mt-4 fw-bold">Grow your business with the GSaaS Partner Program.</h2>
                    <p class="mb-3">The GSaaS Partner Program is designed to help you increase revenue and build long-term client relationships by reselling proven SaaS solutions. Our comprehensive support ensures you have the tools 
                    and training needed to succeed in today's competitive market.</p>
                    <p class="mb-4">Partner with us to unlock new opportunities and deliver outstanding value to your customers.</p>
                    <button style="background: #108AEA;" class="btn text-white">
                        Become a GSaaS Partner <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="./public/Assest/images/grow-image.png" alt="Grow your business" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>


    <!-- partner-us -->
    <section class="why-us " style="background: #ECF7FF;">
        <div class="container" style="padding-top:6%; padding-bottom: 6%;">
            <div class="row justify-content-center gy-5 gx-md-5">
                <div class="col-md-6 d-flex">
                    <div class="partner-card p-5 bg-white rounded-4 shadow flex-fill d-flex flex-column">
                        <h3 class="mb-3">Why Partner With Us? (Benefits for GSaaS Resellers)</h3>
                        <div class="partner-list-descp  mb-2 ">
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Earn recurring commissions on every subscription sale
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Access a powerful reseller dashboard to manage clients and subscriptions
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Receive marketing and sales resources tailored for SaaS products
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Benefit from priority partner support and onboarding assistance
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Flexible pricing options and customizable packages
                            </p>
                            <p class="mb-0">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Training and certification programs for your sales and technical teams
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="partner-card p-5 bg-white rounded-4 shadow flex-fill d-flex flex-column">
                        <h3 class="mb-3">Who Should Become a Reseller?</h3>
                        <div class="partner-list-descp mb-2 ">
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                IT consultants, VARs, MSPs, digital agencies, and software vendors
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Businesses aiming to expand their portfolio with SaaS offerings
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Companies targeting SMBs, enterprises, or specialized markets needing solutions in:
                                <ul>
                                    <li>Cloud computing and infrastructure management</li>
                                    <li>Cybersecurity and data protection</li>
                                    <li>Collaboration and productivity tools</li>
                                    <li>Customer relationship management (CRM)</li>
                                    <li>Enterprise resource planning (ERP)</li>
                                    <li>Marketing automation and analytics</li>
                                </ul>
                            </p>
                            <p class="mb-2">
                                <img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Industry-specific service providers looking to integrate SaaS products into their offerings
                            </p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reseller Program -->
    <section class="grow-business  bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 ">
                    <h2 class="mb-4 mt-4 fw-bold">How the GSaaS Reseller Program Works?</h2>
                    <!--<p class="mb-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem-->
                    <!--    Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer-->
                    <!--    took a galley of type and scrambled it to make a type specimen book.</p>-->
                    <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Apply online and get
                        approved quickly</p>
                    <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Access your reseller
                        portal to manage client subscriptions and billing</p>
                    <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Sell, track
                        commissions, and receive monthly payouts</p>
                    <button style="background: #108AEA;" class="btn text-white mt-3">
                        Become a GSaaS Partner <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="./public/Assest/images/program-work.png" alt="Grow your business"
                        class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Reseller Requirements -->
    <section class="ResellerRequirements ">
        <div class="container" style="padding-top:6%; padding-bottom: 6%;">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="partner-card p-4 p-lg-5 bg-white rounded-4 shadow h-100">
                        <h3 class=" fw-bold mb-3">Reseller Requirements</h3>
                        <div class="partner-list-descp">
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Valid business
                                registration or license</p>
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Commitment to
                                actively promote and sell the SaaS product</p>
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Basic technical
                                knowledge of SaaS/cloud solutions (recommended)</p>
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Agreement to
                                program terms and conditions</p>
                            
                            <!--<p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">-->
                            <!--    Commitment to-->
                            <!--    actively promote and sell the SaaS product</p>-->
                            <!--<p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">-->
                            <!--    Basic technical-->
                            <!--    knowledge of SaaS/cloud solutions (recommended)</p>-->
                            <!--<p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Agreement to-->
                            <!--    program terms and conditions</p>-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="partner-card p-4 p-lg-5 bg-white rounded-4 shadow h-100">
                        <h3 class="mb-3 fw-bold">Commission Structure</h3>
                        <div class="partner-list-descp">
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Recurring
                                monthly or annual commissions based on subscription revenue</p>
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Bonus
                                incentives for reaching sales milestones</p>
                            <p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">
                                Transparent
                                dashboard to monitor your earnings in real time</p>
                            <!--<p class="mb-2"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">-->
                            <!--    Bonus-->
                            <!--    incentives for hitting sales milestones</p>-->
                            <!--<p class="mb-0"><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon">-->
                            <!--    Transparent-->
                            <!--    dashboard to track your earnings in real time</p>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <!--FAQS_SECTION-->
     <div class="faq-container container bg-white py-3">
         <h1 style="font-size:40px" class="faq-heading mt-2 mb-5">Frequently Asked Questions</h1>
    <div style="background-color:white;padding:10px;" class="faq-card shadow-lg rounded" >
 
  <div class="faq-accordion p-4" id="faqAccordion">

    <!-- FAQ Item Template -->
    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingOne">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
          What Is The GSAAS Reseller Program?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          The GSaaS Reseller Program enables businesses to resell our SaaS products under their own brand name. As a reseller, you purchase licenses or subscriptions at discounted rates and sell them to your customers, earning competitive commissions on every sale. This program helps you build your product portfolio and increase revenue streams while leveraging GSaaS’s reliable software solutions
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingTwo">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
          Who Can Become A Reseller?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseTwo" class="faq-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         Any registered business, organisation, or individual with a professional network interested in marketing and selling GSaaS products can apply. Ideal candidates include IT consultants, managed service providers (MSPs), value-added resellers (VARs), digital agencies, and software vendors. Participants must comply with GSaaS’s reseller agreement and terms of service
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingThree">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false">
          How Do I Apply?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseThree" class="faq-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          To get started, complete the reseller application form on our website. After submission, our sales team will review your details and contact you for the next steps. Once approved, you will receive access to the reseller portal, where you can manage clients, subscriptions, and commissions. Our team is available to provide onboarding support and answer any questions
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFour">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false">
          Are There Any Fees To Join?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFour" class="faq-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
        <div class="faq-body">
        No fees are required to join the GSaaS Reseller Program. You only pay for licenses or subscriptions you purchase for resale. Your earnings come from the margin between your purchase price and your selling price, plus any commissions applicable under the program. This makes it a low-risk opportunity to grow your business
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
         Resellers earn competitive, recurring commissions on all subscription sales made through their accounts. The commission structure is transparent and detailed in your reseller agreement. Commissions are typically paid monthly following verification of sales and payments received from customers
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingSix">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false">
          Do I Need Technical Expertise?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSix" class="faq-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
        <div class="faq-body">
        No, technical expertise is not mandatory. GSaaS offers comprehensive training, sales tools, and marketing resources to help you understand and promote our products effectively. Our support team is always available to assist with technical questions or customer inquiries
        </div>
      </div>
    </div>

    <div class="faq-item">
      <h2 class="faq-header" id="headingSeven">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false">
          Can I White-Label The GSaaS Product?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSeven" class="faq-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         Yes, the program includes white-label options for resellers who wish to brand the GSaaS platform as their own. White-label partners receive additional branding customization, marketing support, and service level agreements tailored to their business needs. White-labeling is subject to specific terms outlined in the reseller contract
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
                    <h2 class="mb-3 redy">Ready to Advance Your Business?</h2>
                    <p class="mb-4">Partner with us for expert guidance and strategies that drive growth and success.
                    </p>
                    <!--<div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">-->
                    <!--    <a href="#" class="btn btn-outline-light rounded">-->
                    <!--        Contact Us Today-->
                    <!--    </a>-->
                        <a href="/contact_us" class="btn btn-light gradient-text px-3 py-2 sm:w-50" style="color: #00a7e9; font-weight: 700;">
                             Get Your Free Consultation
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

  
    

 <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
<!-- wrapper end -->
@endsection

