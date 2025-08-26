{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
Referral Programme
   
@endsection
@section('content')
<!-- wrapper start -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral_Partner</title>

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
     .step-two{
            position:relative;
            left:30px;
           
        }
    
    
    @media (min-width:320px) and (max-width:576px){
        .step-two{
            position:relative;
            left:0px;
           
        }
        .step-one{
            position:relative;
            
        }
        .dots{
            display:none;
        }
         .redy{
                margin-left:13% ;
            }
       
        
        
    }
    @media (min-width:766px) and (max-width:1023px){
        .step-to{
            position:relative;
            top:40px;
        }
        
    }
   
    
    /*FAQS*/
    .referral-btn:focus {
    outline: none !important;
    
    box-shadow: none !important;
}

        
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
      margin-bottom:2px solid black;
        margin-top:none;
        margin-left:none;
        margin-right:none;
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


 @media (max-width: 991.98px) {
  

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
     

     .seller-title h1 {
         font-size: 28px;
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

      

     


        /* first-section */
        .gsaas-seller {
            background-color: #108AEA;
            background-image: url('./public/Assest/images/BackgroundPatterns.png');
            background-repeat: no-repeat;
            background-size: 70% auto;
            background-position: right center;
            color: white;
        }

        .table {
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 1rem;
        }

        .dots {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dot {
            height: 8px;
            width: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 6px;
        }

        .dot.pink {
            background: #f472b6;
        }

        .dot.green {
            background: #22c55e;
        }

        .dot.blue {
            background: #3b82f6;
        }

        .dot.yellow {
            background: #facc15;
        }
    </style>
</head>

 <!-- Main-Section -->
    <section class="gsaas-seller p-4">
        <div class="container ">
            <div class="row justify-content-center text-center">
                <div style="margin:14px;" class="col-lg-8">
                    <h2 class="mb-2">GSAAS Referral Program — Grow <br>
                        Together & Earn Rewards</h2>
                    <p class="mb-2">Looking to expand your business? Join our <b>Referral Program</b> and offer GSaaS to your clients with competitive margins, dedicated support, and straightforward onboarding.</p>
                    <a href="/register" style="background: #108AEA; border: 1px solid white;" class="btn  btn-dark mb-4 referral-btn">
                    Join the Referral Program
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
                </div>
            </div>
        </div>
    </section>

    <!-- second-section -->
    <div class="invite-section position-relative overflow-hidden">
        <div class="invite text-center container  p-5 position-relative">
            <!-- Dots Images -->
            <img src="./public/Assest/images/dots.png" alt="Dots Top Left" class="position-absolute top-30 start-0 dots"
                style="max-width: 80px; height: auto;">
            <img src="./public/Assest/images/dots.png" alt="Dots Bottom Right" class=" "
                style="max-width: 80px; height: auto;position:absolute;bottom:60px;right:0px">

            <!-- Content -->
            <div  style="margin-top:25px" class="invite-content">
                <h3>
                    Invite, Earn, and Grow with <br>
                    <span style="color: #14C4F6;">GSaaS</span> Referral Program
                </h3>
                <p>
                    Help us spread the word about GSaaS and get rewarded every <br>
                    time someone you refer becomes a customer
                </p>
               
                    <a style="background: #108AEA; border: 1px solid white;" href="/register"  class="btn  btn-dark mb-4 referral-btn">
                    Join the Referral Program
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
                   
                
            </div>
        </div>
    </div>


    <!-- third-section -->

    <section class="container">

        <div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold mb-5 text-center">How It Works?</h4>
        </div>

        <!-- Step 1 -->
        <div class="col-12 col-md-4 mb-4 position-relative">
            <div class="step-one d-flex align-items-center justify-content-center text-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3"
                    style="width: 70px; height: 70px; flex-shrink: 0; background: #EBF5FF; color: #0070E2;">
                    <i class="fa-solid fa-link fa-lg"></i>
                </div>
                <div class="text-start ">
                    <h6 class="mb-1">Step 1</h6>
                    <p class="mb-0">Share your unique <br> referral link or code with your network</p>
                </div>
            </div>
            <!-- Vertical line -->
            <div class="d-none d-md-block position-absolute top-50 end-0 translate-middle-y"
                style="height: 60px; border-right: 2px solid #000000;"></div>
        </div>

        <!-- Step 2 -->
        <div class="col-12 col-md-4 mb-4 position-relative">
            <div  class="d-flex  step-two  text-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center step-to me-3"
                    style="width: 70px; height: 70px; flex-shrink: 0; background: #EBF5FF; color: #0070E2;">
                    <i class="fa-solid fa-user-plus fa-lg"></i>
                </div>
                <div class="text-start">
                    <h6 class="mb-1">Step 2</h6>
                    <p class="mb-0">
                        Your referrals <a href="/register/en" class="text-decoration-none text-primary">sign up</a> for <br>
                        <a href="https://dev.gsaas.com.au" class="text-decoration-none text-primary">GSaaS</a> using your link
                    </p>
                </div>
            </div>
            <!-- Vertical line -->
            <div class="d-none d-md-block position-absolute top-50 end-0 translate-middle-y"
                style="height: 60px; border-right: 2px solid #000000;"></div>
        </div>

        <!-- Step 3 -->
        <div class="col-12 col-md-4 mb-4 position-relative">
            <div class="d-flex align-items-center justify-content-center text-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3"
                    style="width: 70px; height: 70px; flex-shrink: 0; background: #EBF5FF; color: #0070E2;">
                    <i class="fa-solid fa-signal fa-lg"></i>
                </div>
                <div class="text-start">
                    <h6 class="mb-1">Step 3 (Earn)</h6>
                    <p class="mb-0">
                        Earn Rewards when your referrals <br> become paying
                        <a href="https://dev.gsaas.com.au" class="text-decoration-none text-primary">GSaaS</a> customers
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>



    <section class="py-3">
        <div class="container p-4 rounded" style="background-color: #f0f8ff;">
            <div style="margin:10px;" class="row align-items-center ">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h4 class="fw-bold mb-4">Why Join the Referral Program?</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-primary me-2"></i>
                           Earn ongoing commissions on every successful referral subscription
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-primary me-2"></i>
                            No limits — refer as many customers as you like and keep earning
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-primary me-2"></i>
                           Easily track referrals and commissions through your partner dashboard
                        </li>
                        <li class="mb-2">
                            <i class="fa-solid fa-check text-primary me-2"></i>
                            Help colleagues and clients discover a reliable SaaS platform tailored for business growth
                        </li>
                       
                    </ul>
                    <div class="mt-2">
                       <a style="background: #108AEA; border: 1px solid white;" href="/register"  class="btn  btn-dark mb-4 referral-btn">
                    Join the Referral Program
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
                   
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="./public/Assest/images/joinn.png" alt="Join Referral Program" class="img-fluid">
                </div>
            </div>
        </div>
    </section>


    <!--  -->
    <div class="container position-relative">
        <div class="dots mb-5">
            <img src="./public/Assest/images/dots.png" class="" alt="">
        </div>

        <h4 class="fw-bold mb-4">Referral Rewards</h4>

        <div class="table-responsive mt-5">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Referral Action</th>
                        <th>Reward Type</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>New signup using your referral</td>
                        <td>$20 account credit</td>
                        <td>Credited once per new user sign-up</td>
                    </tr>
                    <tr>
                        <td>New subscription purchase</td>
                        <td>10% recurring commission</td>
                        <td>Earn 10% of subscription payments</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>





    <!-- FAQ Section -->
     
     <div class="faq-container container bg-white py-3">
         <h1 style="font-size:40px" class="faq-heading">Frequently Asked Questions</h1>
    <div style="background-color:white;padding:10px;" class="faq-card shadow-lg rounded" >
 
  <div class="faq-accordion p-4" id="faqAccordion">

    <!-- FAQ Item Template -->
    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingOne">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
          What Is The GSAAS Referral Program?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="faq-body">
        The GSaaS Referral Program is a partnership initiative designed to reward individuals or businesses who refer new customers to GSaaS. By sharing your unique referral link or code, you can earn commissions on every successful subscription sale made through your referrals. This program offers an easy way to generate passive income while helping others discover our SaaS solutions.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingTwo">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
          Who Can Become A Referral?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseTwo" class="faq-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         Anyone with a registered business, professional network, or online presence interested in promoting GSaaS products can join. This includes IT consultants, managed service providers (MSPs), digital agencies, VARs, software vendors, and even freelancers or entrepreneurs with relevant contacts. There are no geographic restrictions, but participants must comply with GSaaS’s terms and conditions
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
          To join, simply complete the online application form available on our website. After submitting your details, our team will review your application for eligibility. Once approved, you will receive access to your referral dashboard where you can generate referral links and track your earnings. If you need help during the process, our dedicated partner support team is available to assist you
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFour">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false">
          Are There Any Fees?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFour" class="faq-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         No, there are no upfront or ongoing fees to join the GSaaS Referral Program. Participation is completely free of charge. You only earn commissions from the sales generated by your referrals. This makes it a risk-free opportunity to increase your revenue streams
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFive">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false">
          What commissions can I earn?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFive" class="faq-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          You will earn a recurring commission of 10% on all subscription payments made by customers who sign up through your referral link. Commissions are paid monthly based on verified transactions. This means you continue to earn as long as your referred customers maintain their paid subscriptions. Commission payments are subject to the program’s payment terms and minimum payout thresholds
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
          No technical knowledge or prior experience with SaaS products is required. GSaaS provides comprehensive training materials, marketing resources, and ongoing support to help you succeed. Whether you’re new to SaaS or a seasoned professional, our program is designed to be straightforward and easy to manage
        </div>
      </div>
    </div>

    <div class="faq-item">
      <h2 class="faq-header" id="headingSeven">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false">
          Can I White-Label The Product?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSeven" class="faq-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Yes, the GSaaS Referral Program offers white-labeling options for qualified resellers. This allows you to brand the GSaaS platform as your own when presenting it to your customers. White-label partners receive additional support and customization options under a separate reseller agreement governed by specific terms regarding branding, licensing, and service level commitments
        </div>
      </div>
    </div>

  </div>
  </div>
</div>



    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mb-3">Ready to Start Earning?</h2>
                    <p class="mb-4">Join the GSaaS Referral Program today and take the next step in growing your business.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        <!--<a href="#" class="btn btn-outline-light rounded">-->
                        <!--    Contact Us Today-->
                        <!--</a>-->
                        <a href="/contact_us" class="btn btn-light gradient-text px-3 py-2" style="color: #00a7e9; font-weight: 700;">
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
    
<!-- wrapper end -->
@endsection

