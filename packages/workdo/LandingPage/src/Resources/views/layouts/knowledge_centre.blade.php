{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
knowledge Centre
   
@endsection
@section('content')
<!-- wrapper start -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>knowledge_Centre</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Antonio:wght@100..700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="https://gsaas.com.au/uploads/logo/favicon.png?1752042036" type="image/x-icon">

    <style>
    
    @media (min-width:320px) and (max-width:576px){
       .nav-link {
            position: relative;
            color: #14202E66 !important;
            opacity: 1;
           
            padding: 10px 15px; /* optional for clean clickable area */
            display: inline-block; /* ensures background covers content */
        }
        .tab a{
            width:90% !important;
            margin-left:5% !important;
            margin-right:5% !important;
        }
       
        
        .nav-link span {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 3px;
            background: transparent;
            width: 0;
            border-radius: 50px;
          
        }
        
        .nav-link.active {
             background: linear-gradient(180deg, #0E1520 0%, #0580DD 100%) !important;      
            color: white !important;               
                   
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
       
        .gsaas-seller {
            background-color: #108AEA;
            background-image: url('./public/Assest/images/BackgroundPatterns.png');
            background-repeat: no-repeat;
            background-size: 70% auto;
            background-position: right center;
            color: white;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            
        }

        .nav-link.active span {
            height: 3px;
            background: #0070E2;
            width:70%;
        }



        /*  */
        .video-box {
           
            border-radius: 8px;
           
            width: 100%;
            max-width: 700px;
            position: relative;
            background-color: white;
        }

        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 40px;
            color: #007bff;
            border: 2px solid #007bff;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        .gradient-bg {
            background: linear-gradient(180deg, #0E1520 0%, #0580DD 100%);
            color: white;
        }

    

        .top-articles h5 {
            font-size: 16px;
            font-weight: bold;
        }

        .top-articles p {
            font-size: 13px;
        }

        .view-all {
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /*  */
        .cta-section {
            padding-top: 6%;
            padding-bottom: 6%;
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


        .accordion-header i {
            background-color: black;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }



        /*  */
        .video-placeholder {
            background-color: #ccc;

            position: relative;
            border-radius: 4px;
        }

        .video-placeholder .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 12px;
            border-radius: 50%;
        }

        .video-description {
            text-align: left;
            font-size: 14px;
            color: #333;
            margin-top: 10px;
        }
        
        .accordion-header {
            padding-bottom:5px;
            
            border-top:none;
            border-left:none;
            border-right:none;
        }
    </style>
</head>


 <!-- first-section -->
    <section class="gsaas-seller py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="mb-4">Getting started</h2>
                    <p class="lead mb-4">
                        All the essentials to help you get started and work efficiently with GSAAS.
                        Explore guides, tips, and resources designed to streamline your experience and boost
                        productivity.
                    </p>
                    <div class="d-flex justify-content-center">
                        <div class="position-relative mb-4" style="width: 600px;">
                            <input type="search" placeholder="Search for articels " class="form-control form-control-lg p-3" style="padding-right: 60px;">

                            <span
                                class="position-absolute top-50 end-0 translate-middle-y me-2 d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px; background: linear-gradient(180deg, #14C4F6 0%, #0070E2 100%); border-radius: 6px; cursor: pointer;">
                                <i class="fa-solid fa-magnifying-glass text-white"></i>
                            </span>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tab Navigation -->
   <div class="bg-light py-3">
    <div class="container">
        <div class="row gap-0"> 

            <ul class="nav nav-tabs border border-0 w-100" id="gsaasTabs">
                <li class="nav-item tab col-12 col-sm-6 col-md-2 col-lg-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab1" href="#">
                        Getting Started
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
                <li class="nav-item tab col-12 col-sm-6 col-md-2 col-lg-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab2" href="#">
                        Using GSAAS
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
                <li class="nav-item tab col-12 col-sm-6 col-md-2 col-lg-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab3" href="#">
                        Your Profile
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
                <li class="nav-item tab col-12 col-sm-6 col-md-2 col-lg-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab4" href="#">
                        Connect Tools
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
                <li class="nav-item tab col-12 col-sm-6 col-md-2 col-lg-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab5" href="#">
                        Administration
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
                <li class="nav-item tab col-12 col-sm-4 col-md-2">
                    <a class="nav-link text-secondary border-0 position-relative w-100 text-center" data-tab="tab6" href="#">
                        Tutorials & Videos
                        <span class="position-absolute bottom-0  w-100"></span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>





    <!-- Tab Content -->
    <div class="container" >
        <!-- Tab 1 Content -->
        <div class="tab-pane active" id="tab1">
            <!-- First section with titles -->
            <div style="padding-left: 3%;" class="container-fluid my-4">
                <div class="mb-3">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
            </div>


            <section style="background: #ECF7FF;" class="grow-business py-5 ">
                <div style="padding-left: 4%;padding-right: 4%;" class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h2 class="mb-4 fw-bold">Instructions About GSAAS</h2>
                            <p class="mb-3">Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia <br>
                                id
                                sed. Id vulputate sed massa adipiscing sit nam tortor diam justo. </p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>
                            <p><img src="./public/Assest/images/Group.png" class="me-2" alt="tick-icon"> Lorem Ipsum is
                                simply dummy text of the printing</p>

                        </div>
                        <div class="col-lg-6 text-center">
                            <img src="./public/Assest/images/termsofuse.png" alt="Grow your business"
                                class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </section>


            <div style="padding-left: 3%;" class="container-fluid my-4">
                <div class="mb-3">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>
                <div class=" mt-5">
                    <h4 class="fw-bold">This Is a title</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed
                        massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus. <br>
                        Lorem
                        ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed. Id vulputate sed massa
                        adipiscing sit nam tortor diam justo. Tortor scelerisque velit pulvinar venenatis ut purus.</p>
                    <!-- Repeat as needed -->
                </div>

            </div>

            <div class="container-fluid p-4">
                <div class="row">
                    <!-- Video Center -->
                    <div class="col-12 col0sm-12 col-md-12 col-lg-7 bg-light p-4 d-flex flex-column justify-content-center align-items-center">
                        <div class="d-flex justify-content-between w-100 mb-3" style="max-width: 700px;">
                            <h5 class="text-black mb-0">Video Center</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary view-all">
                                View all <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="video-box">
                            <video style="width: 100%;" src="./public/Assest/images/video.mp4" controls></video>
                        </div>
                    </div>

                    <!-- Top Articles -->
                    <div class="col-12 col0sm-12 col-md-12 col-lg-5 gradient-bg p-4">
                        <h4 class="ms-4 mt-3 mb-4">Top Articles</h4>
                        <ul class="list-unstyled top-articles">
                         
                            <li class="d-flex mb-4 px-4">
                                <div class="article-icon mt-1 me-3">
                                    <img src="./public/Assest/images/link.png" alt="">
                                </div>
                                <div>
                                    <h5>Lorem ipsum dolor sit amet consectetur.</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed.
                                        Id
                                        vulputate sed massa adipiscing sit nam tortor diam justo.
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex mb-4 px-4">
                                <div class="article-icon mt-1 me-3">
                                    <img src="./public/Assest/images/link.png" alt="">
                                </div>
                                <div>
                                    <h5>Lorem ipsum dolor sit amet consectetur.</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed.
                                        Id
                                        vulputate sed massa adipiscing sit nam tortor diam justo.
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex mb-4 px-4">
                                <div class="article-icon mt-1 me-3">
                                    <img src="./public/Assest/images/link.png" alt="">
                                </div>
                                <div>
                                    <h5>Lorem ipsum dolor sit amet consectetur.</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed.
                                        Id
                                        vulputate sed massa adipiscing sit nam tortor diam justo.
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex mb-4 px-4">
                                <div class="article-icon mt-1 me-3">
                                    <img src="./public/Assest/images/link.png" alt="">
                                </div>
                                <div>
                                    <h5>Lorem ipsum dolor sit amet consectetur.</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed.
                                        Id
                                        vulputate sed massa adipiscing sit nam tortor diam justo.
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex mb-4 px-4">
                                <div class="article-icon mt-1 me-3">
                                    <img src="./public/Assest/images/link.png" alt="">
                                </div>
                                <div>
                                    <h5>Lorem ipsum dolor sit amet consectetur.</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur. Proin odio consectetur lacinia id sed.
                                        Id
                                        vulputate sed massa adipiscing sit nam tortor diam justo.
                                    </p>
                                </div>
                            </li>
                            
                          
                            <!-- Add more items here -->
                        </ul>
                    </div>
                </div>
            </div>






        </div>

        <!-- Placeholder tabs -->
        <div class="tab-pane mt-4" id="tab2">
            <h4>Using GSAAS</h4>
        </div>
        <div class="tab-pane mt-4" id="tab3">
            <h4>Your Profile</h4>
        </div>
        <div class="tab-pane mt-4" id="tab4">
            <h4>Connect Tools</h4>
        </div>
        <div class="tab-pane mt-4" id="tab5">
            <h4>Administration</h4>
        </div>
        <div class="tab-pane" id="tab6">
            <div class="container text-center my-5">
                <!-- Heading -->
                <h2 class="fw-bold">Lorem Ipsum is</h2>
                <p class="text-muted mb-5 w-75 mx-auto">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has <br> been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took <br> a galley of type and scrambled it.
                </p>

                <!-- Video Grid -->
                <div class="container my-5">
                   

                    <div id="videoContainer" class="row justify-content-center"></div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
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
          What Is The GSAAS Reseller Program?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          It is a program that allows you to earn commissions by referring customers to GSaaS.
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
          Any business or individual with a network interested in promoting GSaaS can join.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingThree">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false">
          How Do I Apply To Become A Reseller?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseThree" class="faq-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Complete our online application form or contact our sales team for assistance.
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
          No, joining the program is free. You earn commissions only on sales generated.
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
          Do I Need Technical Expertise To Become A Reseller?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSix" class="faq-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          No technical knowledge is required; we provide comprehensive training and support.
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
          Yes, our program supports white-labeling so you can brand the product for your clients.
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
                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        <!--<a href="#" class="btn btn-outline-light rounded">-->
                        <!--    Contact Us Today-->
                        <!--</a>-->
                        <a href="/contact_us" class="btn btn-light gradient-text px-3 py-2" style="color: #00a7e9; font-weight: 700;">
                            Request Your Free Consultation
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


    <script>
    // Select only nav-links inside #gsaasTabs
    document.querySelectorAll('#gsaasTabs .nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active from all tab links inside #gsaasTabs
            document.querySelectorAll('#gsaasTabs .nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            // Show correct tab content
            const targetId = this.getAttribute('data-tab');
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(targetId).classList.add('active');
        });
    });
</script>




<!-- videos -->
  <script>
    const videos = [
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        { src: "./public/Assest/images/video.mp4", description: "is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, conte" },
        
    ];

    const videosPerPage = 10; // 5 rows of 2 videos per page
    let currentPage = 1;

    function displayVideos(page) {
        const start = (page - 1) * videosPerPage;
        const end = start + videosPerPage;
        const videosToShow = videos.slice(start, end);

        const container = document.getElementById("videoContainer");
        container.innerHTML = "";

        for (let i = 0; i < videosToShow.length; i += 2) {
            const row = document.createElement("div");
            row.className = "row justify-content-center";

            for (let j = i; j < i + 2 && j < videosToShow.length; j++) {
                const col = document.createElement("div");
                col.className = "col-md-6 mb-4";

                col.innerHTML = `
                    <div class="video-placeholder bg-white rounded shadow-sm p-2">
                        <video style="width: 100%; border-radius: 8px;" src="${videosToShow[j].src}" controls></video>
                    </div>
                    <p class="video-description text-left mt-2">
                        ${videosToShow[j].description}
                    </p>
                `;

                row.appendChild(col);
            }

            container.appendChild(row);
        }
    }

    function setupPagination() {
        const pagination = document.getElementById("pagination");
        pagination.innerHTML = "";
        const pageCount = Math.ceil(videos.length / videosPerPage);

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === currentPage ? "active" : ""}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

            li.addEventListener("click", (e) => {
                e.preventDefault();
                currentPage = i;
                displayVideos(currentPage);
                setupPagination();
            });

            pagination.appendChild(li);
        }
    }

    displayVideos(currentPage);
    setupPagination();
    </script>
<!-- wrapper end -->
@endsection

