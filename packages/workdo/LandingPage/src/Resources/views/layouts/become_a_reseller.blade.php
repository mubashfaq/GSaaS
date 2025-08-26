{{-- @extends('marketplace.marketplace') --}}
@extends('landingpage::layouts.marketplace')
@section('page-title')
 Become a Reseller 
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
  <title>GSaaS - Become a Reseller</title>
  <style>
  
   @media (min-width:320px) and (max-width:576px){
      .partnership{
          position:relative;
          padding-bottom:150% !important;
      }
       .pp{
           width:70%;
       }
       .p{
           width:70%;
           position:relative;
           left:60px;
           margin-top:15px;
       }
       .reseller-title{
           font-size:30px !important;
       }
       
        .need{
            position:absolute;
            bottom:30px !important;
        }
        .gsaas-content{
            position:relative;
            
        }
        .partner{
            position:relative;
            top:35%;
            left:0px !important;
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

    body {
      font-family: 'Inter', sans-serif;
    }

    footer {
      background-image: url('./public/Assest/images/footer-bg.png');
      background-size: cover;
      background-position: center;
      color: white;
    }

    .contact-container {
        margin-top:-18px;
      max-width: 1200px;
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

    .cta-section {
      background: linear-gradient(90deg, #0ea5e9, #2563eb);
      color: white;
      padding: 60px 0;
      text-align: center;
    }

    .contact-box {
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .reseller-benefits {
        background: #f8fafc;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .benefit-item i {
        color: #0ea5e9;
        margin-right: 10px;
        font-size: 1.2em;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-check {
        margin-bottom: 0.5rem;
    }

    @media (max-width: 767px) {
        .container-fluid {
            padding-right: 1rem;
            padding-left: 1rem;
        }
        
        .px-md-4 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }
    }
  </style>
</head>

<div>
    <section style="background-image: url('./public/Assest/images/contact-backgroud.jfif'); background-repeat: no-repeat; background-position: right;" class="common-banner-section bg-white">
        <div class="container contact-section py-5">
            <div class="text-center gsaas-content mb-5">
                <h2 style="color:#14293E;font-size:48px" class="fw-bold reseller-title">Become a GSaaS Reseller</h2>
                <p class="p" style="font-size:15px">Join our partner network and grow your business while helping others transform theirs. <br/> Earn competitive commissions and access exclusive resources.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 mb-4 partnership mb-md-0">
                    <div style="padding:28px; background:#F4F8FB;" class="contact-box w-100">
    <h2 class="mb-1">Reseller Application Form</h2>
    <p><small>Please complete all required fields. Our partnership team will review your application within 2-3 business days.</small></p>

    <form id="resellerForm">
        <!-- Personal Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Your full name" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="example@company.com" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+61 000 000 000" autocomplete="off">
        </div>

        <!-- Company Information -->
        <hr class="my-4">
        <h5>Company Information</h5>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_name" class="form-label">Company Name *</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" required placeholder="Your company name" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_website" class="form-label">Company Website</label>
                    <input type="url" class="form-control" id="company_website" name="company_website" placeholder="https://yourcompany.com" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_size" class="form-label">Company Size *</label>
                    <select class="form-control" id="company_size" name="company_size" required>
                        <option value="">Select company size</option>
                        <option value="1-10">1-10 employees</option>
                        <option value="11-50">11-50 employees</option>
                        <option value="51-200">51-200 employees</option>
                        <option value="201-500">201-500 employees</option>
                        <option value="500+">500+ employees</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="industry" class="form-label">Industry *</label>
                    <input type="text" class="form-control" id="industry" name="industry" required placeholder="e.g., Technology, Healthcare, Retail" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Experience & Expertise -->
        <hr class="my-4">
        <h5>Experience & Expertise</h5>

        <div class="form-group">
            <label for="experience_level" class="form-label">Sales/Reseller Experience Level *</label>
            <select class="form-control" id="experience_level" name="experience_level" required>
                <option value="">Select experience level</option>
                <option value="Beginner">Beginner (0-2 years)</option>
                <option value="Intermediate">Intermediate (2-5 years)</option>
                <option value="Advanced">Advanced (5-10 years)</option>
                <option value="Expert">Expert (10+ years)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="why_reseller" class="form-label">Why do you want to become a GSaaS reseller? *</label>
            <textarea class="form-control" id="why_reseller" name="why_reseller" rows="4" required placeholder="Tell us about your motivation and how you plan to promote GSaaS solutions..."></textarea>
        </div>

        <div class="form-group">
            <label for="target_market" class="form-label">Describe your target market</label>
            <textarea class="form-control" id="target_market" name="target_market" rows="3" placeholder="Who are your ideal customers? What industries or business sizes do you focus on?"></textarea>
        </div>

        <!-- Sales Information -->
        <hr class="my-4">
        <h5>Sales Information</h5>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="expected_monthly_sales" class="form-label">Expected Monthly Sales Volume (AUD)</label>
                    <input type="number" class="form-control" id="expected_monthly_sales" name="expected_monthly_sales" min="0" step="0.01" placeholder="10000.00" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Do you have a dedicated sales team?</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="has_sales_team" id="has_team_yes" value="1">
                            <label class="form-check-label" for="has_team_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="has_sales_team" id="has_team_no" value="0" checked>
                            <label class="form-check-label" for="has_team_no">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="team_size" class="form-label">If yes, how many people in your sales team?</label>
            <input type="number" class="form-control" id="team_size" name="team_size" min="0" placeholder="5" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="additional_info" class="form-label">Additional Information</label>
            <textarea class="form-control" id="additional_info" name="additional_info" rows="3" placeholder="Any additional information you'd like to share about your business or partnership goals..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
            Submit Application
        </button>

        <div id="statusMessage" class="alert mt-3 d-none" role="alert"></div>
    </form>
</div>
                </div>
                <div class="col-12 col-md-4 d-flex partner align-items-start">
                    <div class="reseller-benefits need ">
                        <h5 class="fw-bold mb-3" style="color:#14293E">Why Partner with GSaaS?</h5>
                        
                        <div class="benefit-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Competitive recurring commissions</span>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Comprehensive training & support</span>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-users"></i>
                            <span>Dedicated partner success manager</span>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-tools"></i>
                            <span>Marketing materials & resources</span>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Real-time sales tracking dashboard</span>
                        </div>
                        
                        <div class="benefit-item">
                            <i class="fas fa-handshake"></i>
                            <span>Co-marketing opportunities</span>
                        </div>

                        <hr class="my-4">
                        
                        <h6 class="fw-bold mb-2" style="color:#496179">Questions?</h6>
                        <p class="small mb-2">Contact our Partnership Team:</p>
                        <p class="small mb-1"><strong>Email:</strong> <a href="mailto:sales@gsaas.com.au" class="text-decoration-none">sales@gsaas.com.au</a></p>
                        <p class="small mb-1"><strong>Phone:</strong> <a href="tel:+6180056676" class="text-decoration-none">+61 8005 6676</a></p>
                        <p class="small text-muted">Monday - Friday, 9:00 AM - 6:00 PM AEST</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

   <!--FAQS_SECTION-->
     <div class="faq-container container bg-white py-3">
         <h1 style="font-size:40px" class="faq-heading">Reseller Program FAQ</h1>
    <div style="background-color:white;padding:10px;" class="faq-card shadow-lg rounded" >
 
  <div class="faq-accordion p-4" id="faqAccordion">

    <!-- FAQ Item Template -->
    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingOne">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">
          What commission rates do you offer?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
        <div class="faq-body">
         We offer competitive recurring commission rates ranging from 15-30% depending on your sales volume and partnership tier.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingTwo">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">
          How long does the application process take?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseTwo" class="faq-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Our team reviews applications within 2-3 business days. Successful applicants will receive onboarding materials and training schedules.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingThree">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false">
          What support do you provide to resellers?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseThree" class="faq-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          We provide comprehensive training, marketing materials, technical support, dedicated partner manager, and sales tools to ensure your success.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingFour">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false">
          Is there a minimum sales requirement?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseFour" class="faq-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          While we don't have strict minimums, we expect active participation. We'll work with you to set realistic goals based on your market and capacity.
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
          You will receive competitive recurring commissions on all subscription sales from your referrals, with potential for performance bonuses.
        </div>
      </div>
    </div>

    <div class="faq-item mb-3">
      <h2 class="faq-header" id="headingSix">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false">
          Can I sell in multiple territories?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSix" class="faq-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          Yes, our partnership program allows you to sell across Australia and internationally, subject to agreement terms.
        </div>
      </div>
    </div>

    <div class="faq-item">
      <h2 class="faq-header" id="headingSeven">
        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false">
          What training is provided?
          <span class="faq-icon">
            <i class="fas fa-plus"></i>
          </span>
        </button>
      </h2>
      <div id="collapseSeven" class="faq-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
        <div class="faq-body">
          We provide comprehensive product training, sales methodology, technical demos, and ongoing education to keep you updated on new features.
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
                    <h2 class="mb-3">Ready to Join Our Partner Network?</h2>
                    <p class="mb-4">Start earning recurring commissions while helping businesses transform their operations with GSaaS solutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

   <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
document.getElementById('resellerForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const statusMessage = document.getElementById('statusMessage');
    statusMessage.classList.add('d-none');
    statusMessage.innerHTML = '';

    submitBtn.disabled = true;
    submitBtn.innerText = 'Submitting Application...';

    // Collect form data
    const formData = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        company_name: document.getElementById("company_name").value,
        company_website: document.getElementById("company_website").value,
        company_size: document.getElementById("company_size").value,
        industry: document.getElementById("industry").value,
        experience_level: document.getElementById("experience_level").value,
        why_reseller: document.getElementById("why_reseller").value,
        target_market: document.getElementById("target_market").value,
        expected_monthly_sales: document.getElementById("expected_monthly_sales").value,
        has_sales_team: document.querySelector('input[name="has_sales_team"]:checked').value,
        team_size: document.getElementById("team_size").value,
        additional_info: document.getElementById("additional_info").value,
    };

    fetch("/become-reseller", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Submit Application';

        statusMessage.classList.remove('d-none');
        statusMessage.classList.remove('alert-danger', 'alert-success');

        if (data.success) {
            statusMessage.classList.add('alert-success');
            statusMessage.innerHTML = data.message;
            document.getElementById('resellerForm').reset();
        } else {
            statusMessage.classList.add('alert-danger');
            if (data.errors) {
                let errorMessages = '';
                Object.keys(data.errors).forEach(key => {
                    errorMessages += data.errors[key].join('<br>') + '<br>';
                });
                statusMessage.innerHTML = errorMessages;
            } else {
                statusMessage.innerHTML = data.message || 'An error occurred';
            }
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Submit Application';
        statusMessage.classList.remove('d-none', 'alert-success');
        statusMessage.classList.add('alert-danger');
        statusMessage.innerHTML = 'Something went wrong. Please try again.';
        console.error('Error:', error);
    });
});

// Show/hide team size field based on sales team selection
document.querySelectorAll('input[name="has_sales_team"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const teamSizeField = document.getElementById('team_size');
        if (this.value === '1') {
            teamSizeField.disabled = false;
            teamSizeField.required = true;
        } else {
            teamSizeField.disabled = true;
            teamSizeField.required = false;
            teamSizeField.value = '';
        }
    });
});

// Initialize team size field state
document.addEventListener('DOMContentLoaded', function() {
    const hasTeamNo = document.getElementById('has_team_no');
    if (hasTeamNo.checked) {
        document.getElementById('team_size').disabled = true;
    }
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