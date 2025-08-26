
@php
    $settings = \Workdo\LandingPage\Entities\LandingPageSetting::settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
     <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- fontawesome cdnjs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
  <link rel="icon" href="{{ (!empty($settings['favicon']) && check_file($settings['favicon'])) ? get_file($settings['favicon']) : get_file('uploads/logo/favicon.png')}}{{'?'.time()}}" type="image/x-icon" />
  <title>GSaaS</title>
  <style>

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
  position: absolute !important;
  width: 100%;
  z-index: 10;
  padding-top: 40px !important;
}

.nav-item .nav-link {
  font-weight: 500;
}

.hero-section {
  position: relative;
  overflow: hidden;
  background-image: url('../public/Assest/images/Vector.png');
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
  margin-top: -600px;
  margin-bottom: 100px;
}

.work-broken-section {
  background: #F9F9F9;
  padding: 80px 0px;
  margin-top: 80px;
  box-shadow: 0px -1px 10px #B8B8B840;
}

 
  .work-broken-section .col-md-5{
      width:47% !important;
  }
  
  .work-broken-section .col-md-6{
      width:45% !important;
  }

.fix-it-box {
  background-image: url('../public/Assest/images/fix-it-bg.png');
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
  font-size: 32px;
  color: white;
}

.big-card {
  position: relative;
  bottom: 100px;
}

footer {
  padding: 50px 0px 30px !important;
  background-image: url('../public/Assest/images/footer-bg.png');
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
  margin-bottom: 20px;
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
  margin-bottom: 50px;
  padding-bottom: 30px;
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
  border-radius: 5px;
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

.slider__buttons{
    display:none;
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

.heading{
  padding: 20px !important;
}

.features-bubble{
  top: -25px;
  right: -95px;
}

.feature-boxes-1{
  justify-content: space-between;
}

.tablet-box-1 {
  display: none;
}

.free{
  justify-content: space-between;
 }

 .newsletter input{
  padding: 12px 10px 12px 50px !important;
  border-radius: 10px !important;
 }

 .foot-sub{
  border-radius: 12px !important;
  border-radius: 10px !important;
  font-weight: 500;
 }
 
 .foot-sub:hover{
     background:transparent !important;
     color: #fff !important;
     border:1px solid #fff !important;
 }
 
 .foot-sub:focus{
     box-shadow:none !important;
 }
 
 .form-control:focus{
     box-shadow:none !important;
     border-color:#fff !important;
 }

 .free {
  justify-content: center;
 }

 .invoice-sales{
  height: 350px !important;
  object-fit: fill;
 }

 .foot-sub{
  width: 100% !important;
  padding: 10px !important;
  font-weight: 500 !important; 
}

 .company-links ul li a:hover, .product-links ul li a:hover{
      color:#fff !important;
  }
   @media (min-width: 1300px) and (max-width: 1400px) {
         .feature-boxes-section{
             padding:0px !important;
         }
          .random-column{
              width:153px !important;
              height:136px !important;
           
          }
          .random-column-2{
              width:210px !important;
              
          }
        
          
        }
@media only screen and (max-width: 1297px) {
    .random-column{
        width:145px !important;
    }
    .random-column-2 {
        width:220px !important;
        height:220px !important;
        margin-bottom:0px !important;
    }
    .content-creation-bg{
        height:610px;
        background-size: 52%, 100%;
    }
    .company-links {
        padding-left:130px !important;
    }
    .navbar-nav {
        gap:0px !important;
    }
    .benefits-cards{
        height:190px;
    }
    
}

/* Media */
@media only screen and (max-width: 1024px) {
  .benefits-cards{
    height: auto;
  }
  .navbar {
    padding-top: 20px !important;
  }

  .navbar-toggler {
    border-color: #fff !important;
    background-color: #fff !important;
  }
  .slider-container{
    height: 400px;
  }
  .dashboardimg-section{
    margin-top: -365px;
    margin-bottom: 50px;
  }
  .fix-it-box{
    padding: 30px;
  }
  .features-bubble{
    display: none;
  }

  .features-main-img{
    right: 0px;
  }
  .feature-boxes-1{
    justify-content: start;
    gap: 18px;
  }
  .tablet-box-1{
    display: block;
  }

  .tablet-box-2{
    display: none;
  }

  .newslider-container{
    height: 300px;
  }

  .newslide-image{
    height: 340px;
  }
  .content-creation-box{
    width: 100%;
  }
  .contact-us-btn, .contact-us-btn-2{
    padding: 11px 20px !important;
  }
  .free{
   justify-content: start;
   margin-top: 20px !important;
  }
  .free-quote-badge{
    display: none;
  }
  .company-links, .product-links, .newsletter{
    padding: 10px !important;
  }
  .footer-main-section{
    padding: 10px 0px 35px;
  }
  .newdots-container{
    bottom: 90px;
  }
  .border-work>h2{
    font-size: 30px;
  }
  .border-work>p{
    font-size: 20px;
  }
  .benefits-bubble{
    right: -65px;
  }
  .slider__track{
    gap: 13px;
  }
  .invoice-sales{
     height: 170px !important;
  }
  .random-column {
        width: 166px !important;
    }
    .random-column-2 {
    width: 260px !important;
    height: 250px !important;
    }
    .content-creation-bg{
        background:transparent;
    }
    .content-creation-box h2{
        width:100%;
    }
    .invoice-sales {
    height: 300px !important;
    }
    .work-broken-section .col-md-5, .work-broken-section .col-md-6{
        width:100% !important;
    }
    .work-broken-section .col-md-6{
        padding-top:20px !important;
    }
}

@media only screen and (max-width: 990px) {
    #navbarNav{
    background: white;
    padding: 20px;
  }

  #navbarNav ul li a {
    color: black !important;
  }
}



@media only screen and (max-width: 600px) {
    .hero-section{
        height:890px;
    }
  .tablet-box-1{
    display: none;
  }

.work-broken-section .col-md-6{
        padding-top:0px !important;
    }

  .newdots-container{
    bottom: -15px;
  }

  .free{
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
  
  .work-broken-section .col-md-6, .work-broken-section .col-md-5{
      width:100% !important;
  }

  .slider-container {
    height: 190px;
  }
  
  .content-creation-box h2 {
      font-size:32px;
      width:100%;
  }

  .leading-heading, .border-work>h2 {
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
    margin-top: 130px;
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

  .heading.py-5{
    padding: 0px 0px 20px !important;
  }

  .problem-para {
    font-size: 16px !important;
    margin-top: 0 !important;
  }

  .problem-main-img, .solving-bubble {
    display: none;
  }

  .heading-problem-solve .display-4{
    font-size: 27px !important;
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

  .whygsaas .heading h2{
    font-size: 32px !important;
  }

  .whygsaas .heading h2 br{
    display: none;
  }

  .whygsaas .heading h2 span{
    padding: 0px !important;
  }

  .heading .feature-section {
    right: 0px !important;
  }

  .feature-section p, .border-work>p {
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
  width: 160px !important;
  height:150px !important;
  border: 1px solid #CCCCCC;
  box-shadow: 0px 8px 4px #E4E4E426;
  padding: 20px !important;
  
  margin-top:10px;
  margin-bottom:10px !important;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

  .content-creation-bg {
    height: 100% !important;
    background:#f9f9f9 !important;
    padding-bottom: 50px;
  }

  .content-creation-box{
    width: 100%;
  }

  .content-creation-box div{
    flex-wrap: wrap;
  }

  .newslider-container{
    height: 200px;
    margin-top: 50px;
  }

  .newslide-image{
    height: 222px;
  }

  .faq-section h2{
    font-size: 32px !important;
  }

  .free-quote-badge{
    display: none;
  }

  .footer-first-section .d-flex{
    flex-wrap: wrap !important;
    justify-content: flex-start !important;
    margin-top: 10px;
  }

  .footer-main-section{
    padding: 0px 0px 50px !important;
  }

  .company-links, .product-links{
    padding-left: 15px !important;
    padding-top: 15px !important;
  }

  .newsletter{
    padding-top: 15px;
  }

  .dots-container, .newdots-container {
    width: 95% !important;
  }

  .benefits-cards-title {
    font-size: 21px !important;
  }

  .content-creation-box ul li, .content-creation-box p {
    font-size: 16px !important;
  }
  .footer-first-section p{
    font-size: 18px !important;
  }

  .footer-first-section .kaushan{
    font-size: 32px !important;
  }

  .whygsaas .heading img{
    display: none;
  }

  .clients-logos {
    padding-bottom: 0px !important;
    border-bottom: none !important;
  }

  .whygsaas .heading.p-3{
    padding: 0px !important;
  }

  .content-creation-bg{
    padding: 30px 0px !important;
  }

  .problem-solving-section.py-5{
    padding-top: 20px !important;
    padding-bottom: 20px !important;
  }

  #navbarNav{
    background: white;
    padding: 20px;
  }

  #navbarNav ul li a {
    color: black !important;
  }

  #navbarNav .login{
    margin-top: 20px;
  }

  #navbarNav .login a:first-child{
    background-color: #e7e7e7 !important;
  }

  .features-bubbl{
    display: none;
  }

  .supply-chain{
    width: 60%;
  }
  .fix-it-box h2{
      font-size:36px;
  }
  .fix-it-box p {
      font-size:16px;
  }
  .heading{
      padding:10px !important;
  }
 
  
}
  </style>
</head>




<body>
  <!-- Navbar Section -->
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand" href="{{url('/')}}">
            <img src="../public/Assest/images/logo.png" alt="GSAAS" height="50" class="text-white">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
             @if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))
                                    <!--@foreach (json_decode($settings['menubar_page']) as $key => $value)-->
                                    <!--    @if ($value->header == 'on')-->
                                    <!--        @if($value->template_name == 'page_content')-->
                                    <!--            <li class="nav-item">-->
                                    <!--                <a class="nav-link text-white" href="{{ route('custom.page',$value->page_slug) }}">{{ $value->menubar_page_name }}</a>-->
                                    <!--            </li>-->
                                    <!--        @else-->
                                    <!--            <li class="nav-item">-->
                                    <!--                <a class="nav-link text-white" target="_blank" href="{{ $value->page_url }}">{{ $value->menubar_page_name }}</a>-->
                                    <!--            </li>-->
                                    <!--        @endif-->
                                    <!--    @endif-->
                                    <!--@endforeach-->
                                <li class="nav-item">
                                    <a class="nav-link text-white"  href="/about_us">About Us</a>
                                </li>
                                <!--<li class="nav-item">-->
                                <!--    <a class="nav-link text-white"  href="/knowledge_centre">Knowledge Centre</a>-->
                                <!--</li>-->
                                <li class="nav-item">
                                    <a class="nav-link text-white"  href="/contact_us">Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white"  href="/referral_programme">Referral Programme</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white"  href="/become_a_reseller">Become a Reseller</a>
                                </li>
                                @endif
            </ul>
            <div class="d-flex login gap-4">
              <a href="{{ (Auth::check()) ? route('home') :route('login') }}" class="btn btn-light d-flex justify-content-center align-items-center gap-2"
                style="font-weight: 500;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M10.5309 0.851807H13.7079C14.1292 0.851807 14.5332 1.01916 14.8311 1.31706C15.129 1.61496 15.2963 2.019 15.2963 2.44029V13.5597C15.2963 13.981 15.129 14.385 14.8311 14.6829C14.5332 14.9808 14.1292 15.1482 13.7079 15.1482H10.5309"
                    stroke="#1B2128" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M6.55969 11.9712V11.9712C8.75294 9.77796 8.75294 6.22201 6.55969 4.02877V4.02877"
                    stroke="#1B2128" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M10.5309 8H1" stroke="#1B2128" stroke-width="1.3" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
                {{ (Auth::check()) ? __('Home') :__('Login') }}
              </a>
              <a href="/register/en"
                style="background: linear-gradient(180deg, #023850 0%, #0380B6 100%); border: none;font-weight: 500;"
                class="btn btn-dark ">Sign Up</a>
            </div>
          </div>
        </div>
      </nav>

  <!-- First Section - Hero with background image -->
  <section class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
      <!-- Main content -->
      <div class=" main-titl text-center text-white pt-5 mt-5">
        <h1 class="font display-4 font-weight-bold pt-5 mt-3">Your All-in-One Business <span
            class="d-inline-block text-white px-1"
            style="background: url('../public/Assest/images/third-brush.png') center center/contain;">
            Management
          </span> Platform</h1>
        <p style="font-size: 26px;" class="lead my-4">Smart, Affordable Solutions for Australian Businesses of All Sizes</p>
        <!--<p class="kaushan-script-regular mb-4">Starting at just AUD$7.25/month for all apps.</p>-->

        <!--<div class="d-flex justify-content-center align-items-center gap-3">-->
        <!--  <a href="#" class="hero-section-btn text-white d-flex justify-content-center align-items-center gap-2">-->
        <!--    Start Your Free Trial Today-->
        <!--    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">-->
        <!--      <path d="M1 7H13" stroke="white" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--      <path d="M7 1L13 7L7 13" stroke="white" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--    </svg>-->
        <!--  </a>-->
        <!--  <a style="border-radius: 10px;" href="#" class="btn-light btn-block hero-section-btn-two">-->
        <!--    Limited-Time Offer-->
        <!--  </a>-->
        <!--</div>-->
      </div>
    </div>
  </section>

  <!-- Second Section - Dashboard Image (overlapping first section) -->
  <section class="py-0 dashboardimg-section">
    <div class="container position-relative">
      <div class="slider-container">
        <div class="myslide active">
          <img src="../public/Assest/images/1738302109-home_banner 1.png" alt="Nature" class="slide-image">
        </div>
        <div class="myslide">
          <img src="../public/Assest/images/hero-section-pos-dashboard.png" alt="City" class="slide-image">
        </div>
        <div class="myslide">
          <img src="../public/Assest/images/hero-section-hrm.png" alt="Beach" class="slide-image">
        </div>
        <div class="myslide">
          <img src="../public/Assest/images/hero-section-accounting.png" alt="Mountains" class="slide-image">
        </div>
      </div>
      <div class="dots-container"></div>
    </div>
  </section>

  <!-- Third Section - Trusted Companies -->
  <!--<section class="pt-5 bg-white mt-5">-->
  <!--  <div class="container text-center">-->
  <!--    <h3 class="mb-5 text-dark font-weight-normal leading-heading"><span class="d-inline-block text-dark"-->
  <!--        style="background: url('../public/Assest/images/rounded.png') no-repeat center center; background-size: 100% 100%;">-->
  <!--        Trusted-->
  <!--      </span> by Leading Companies</h3>-->

  <!--    <div class="row justify-content-center flex-wrap clients-logos">-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--      <div class="leading-company-logo">-->
  <!--        <img src="../public/Assest/images/client-logo.png" alt="">-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--</section>-->


  <!-- Fourth-section Multiple software -->
  <section class="work-broken-section overflow-hidden">
    <div class="container">
      <div class="row justify-content-between">
        <!-- Left Column -->
        <div class="col-12 col-md-5 text-center">
          <div class="border-work work border-dark d-inline-block mb-5">
            <h2>Stop Juggling Multiple</h2>
            <p class=""> Software Tools</p>
          </div>
          <img src="../public/Assest/images/work-broken.png" alt="" width="100%">
        </div>

        <!-- Right Column -->
        <div class="col-12 col-md-6">
          <div class="fix-it-box">
            <div class="pb-4 mb-5 border-bottom">
              <h2>Simplify Your Business Now</h2>
              <p class="mb-3">Using many disconnected software tools slows your team down. Your business needs to run smoother and faster.
              </p>
              <!--<a href="#" class="d-inline-block">-->
              <!--  Get Started for Free-->
              <!--  <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">-->
              <!--    <path d="M1 7H13" stroke="white" stroke-linecap="round" stroke-linejoin="round" />-->
              <!--    <path d="M7 1L13 7L7 13" stroke="white" stroke-linecap="round" stroke-linejoin="round" />-->
              <!--  </svg>-->
              <!--</a>-->
            </div>
            <img src="../public/Assest/images/fix-it-img.png" alt="" width="100%">
          </div>
        </div>
      </div>
    </div>
  </section>



  <!-- Fivth-section Problem Solving-->
  <section class="py-5 bg-white overflow-hidden problem-solving-section position-relative">
    <div class="container position-relative">
      <div class="heading">
        <div class="">
          <div class="heading-problem-solve text-center w-100">
            <div class="d-inline-block position-relative">
              <h2 class="font display-4" style="width: 80%;margin: auto;">Tailor Your Workspace to Solve Real Business Problems</h2>
              <img src="../public/Assest/images/problem-bubble.png" alt="" class="position-absolute solving-bubble">
            </div>
            <div class="problem-parag">
              <p style="font-size: 20px;" class="problem-para">
                Set up exactly what your business needs and customise it as you grow:
              </p>
            </div>
          </div>

        </div>
      </div>
      <!-- Cards Grid -->
      <div class="row">

        <!-- Card 1 -->
        <div class="col-md-6 col-lg-6 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px; overflow: hidden; "
            class="card h-100 p-3">
            <div class=" d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/hrm-icon.png" alt="HRM Icon" class="mr-2 " style="width: 30px; height: 30px;">
              <h5 class="mb-0">HR Management</h5>
            </div>
            <p>Streamline employee records, payroll, and leave requests.</p>
            <img src="../public/Assest/images/hrm-sample.png" alt="HRM Sample" class="img-fluid shadow-sm pm-img">
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 col-lg-6 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px;overflow: hidden"
            class="card h-100 p-3">
            <div class=" d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/crm-icon.png" alt="CRM Icon" class="mr-2 " style="width: 30px; height: 30px;">
              <h5 class="mb-0">CRM</h5>
            </div>
            <p>Track leads, customers, and sales pipelines easily.</p>
            <img src="../public/Assest/images/crm-sample.png" alt="CRM Sample" class="img-fluid mt-auto pm-img">
          </div>
        </div>

        <!-- Card 3 -->
        <div class=" col-md-4 col-lg-4 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px; overflow: hidden"
            class="card h-100 p-3">
            <div class="d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/task-icon.png" alt="Task Icon" class="mr-2 " style="width: 30px; height: 30px;">
              <h5 class="mb-0">Task & Project Management</h5>
            </div>
            <p>Assign tasks, set deadlines, monitor progress.</p>
            <img src="../public/Assest/images/task-sample.png" alt="Task Sample" class="img-fluid mt-auto pm-img">
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4 col-lg-4 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px; overflow: hidden"
            class="card h-100 p-3">
            <div class=" d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/sales-icon.png" alt="Sales Icon" class="mr-2 "
                style="width: 30px; height: 30px;">
              <h5 class="mb-0">Invoicing & Sales</h5>
            </div>
            <p>Generate quotes and invoices quickly to get paid faster.</p>
            <img src="../public/Assest/images/sales-sample.png" alt="Sales Sample" class="img-fluid mt-auto pm-img invoice-sales">
          </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4 col-lg-4 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px;overflow: hidden"
            class="card h-100 p-3">
            <div class=" d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/manage-icon.png" alt="Manage Icon" class="mr-2 "
                style="width: 30px; height: 30px;">
              <h5 class="mb-0">Lead Management</h5>
            </div>
            <p>Organise and nurture prospects to grow revenue.</p>
            <img src="../public/Assest/images/manage-sample.png" alt="Manage Sample" class="img-fluid mt-auto pm-img">
          </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-6 col-lg-6 mb-4 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px;overflow: hidden"
            class="card h-100 p-3">
            <div class=" d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/project-icon.png" alt="Accounting Icon" class="mr-2 "
                style="width: 30px; height: 30px;">
              <h5 class="mb-0">Accounting</h5>
            </div>
            <p>Automate financial reporting and tax compliance with real-time insights.</p>
            <img src="../public/Assest/images/project-sample.png" alt="Accounting Sample" class="img-fluid mt-auto pm-img">
          </div>
        </div>
        <!-- Card7 -->
        <div class="col-md-6 col-lg-6 mb-4 mb-4 pm-card">
          <div
            style="background: linear-gradient(121.49deg, #FFFFFF 8.99%, #EBF6FF 97.19%); border-radius: 20px;overflow: hidden"
            class="card h-100 p-3">
            <div class="  d-flex align-items-center mb-3 gap-3">
              <img src="../public/Assest/images/accounting-icon.png" alt="Accounting Icon" class="mr-2 "
                style="width: 30px; height: 30px;">
              <h5 class="mb-0">Purchasing</h5>
            </div>
            <p>Manage purchase orders, supplier data, and procurement workflows efficiently.</p>
            <img src="../public/Assest/images/accounting-sample.png" alt="Accounting Sample" class="img-fluid mt-auto pm-img">
          </div>
        </div>

      </div> <!-- row end -->
    </div>
      <img src="../public/Assest/images/tech.png" alt="corner image" class="problem-main-img img-fluid ml-3 techimg">
  </section>


  <!-- sixth-section Befefits from GSaaS -->
  <section class="py-5 benefit-section overflow-hidden">
    <div class="container ">
      <div class="text-center">
        <div class="sec-heading position-relative d-inline-block">
          <h2 style="font-family: Inter;
        font-weight: 600;
        font-size: 40px;
        line-height: 52px;
        letter-spacing: -2.5px;
        text-align: center;         ">
            <span class="d-inline-block text-dark"
              style="background: url('../public/Assest/images/rounded.png') no-repeat center center; background-size: 100% 100%;">
              Who
            </span>
            Benefits from
            <span class="d-inline-block text-white px-1"
              style="background: url('../public/Assest/images/brush.png') no-repeat center center/contain; position: relative; right: 5px; width: 150px;">
              GSaaS?
            </span>
          </h2>
          <img src="../public/Assest/images/benefit-bubble.png" alt="" class="position-absolute benefits-bubble">
        </div>
      </div>
      <div class="position-relative">
        <!-- Cards Grid -->
        <div class="row  mt-5">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#F23685" />
                    <path
                      d="M26.5833 35.9583C26.5833 36.5312 26.1146 37 25.5416 37H13.0416C12.4687 37 12 36.5312 12 35.9583C12 31.9271 15.2604 28.6667 19.2916 28.6667C23.3229 28.6667 26.5833 31.9271 26.5833 35.9583ZM23.4583 22.4167C23.4583 20.1146 21.5937 18.25 19.2916 18.25C16.9896 18.25 15.125 20.1146 15.125 22.4167C15.125 24.7188 16.9896 26.5833 19.2916 26.5833C21.5937 26.5833 23.4583 24.7188 23.4583 22.4167ZM31.7916 12H21.375C18.5729 12 16.3021 14.2292 16.1875 17C17.1041 16.4688 18.1562 16.1667 19.2916 16.1667C22.1458 16.1667 24.5416 18.0833 25.2916 20.6979L27.625 23.0312L31.3646 19.2917H29.7083C29.1354 19.2917 28.6666 18.8229 28.6666 18.25C28.6666 17.6771 29.1354 17.2083 29.7083 17.2083H32.8333C33.9791 17.2083 34.9166 18.1458 34.9166 19.2917V22.4167C34.9166 22.9896 34.4479 23.4583 33.875 23.4583C33.3021 23.4583 32.8333 22.9896 32.8333 22.4167V20.7604L29.0937 24.5C28.2812 25.3125 26.9583 25.3125 26.1458 24.5L25.3958 23.75C25.3958 23.75 25.3958 23.7604 25.3958 23.7708C25.0729 25.2396 24.2291 26.5104 23.0729 27.3854C24.7083 28.1042 26.0937 29.2812 27.0833 30.75H31.8021C34.6771 30.75 37.0104 28.4167 37.0104 25.5417V17.2083C37.0104 14.3333 34.6771 12 31.8021 12H31.7916Z"
                      fill="#FE6293" />
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Small to Medium Business Owners</h5>
                  <p class="benefits-cards-text m-0"> Cut costs and scale efficiently with fewer headaches.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
              <div class="shadow-sm benefits-cards">
                <div class="d-flex gap-3">
                  <div>
                    <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle opacity="0.2" cx="25" cy="25" r="25" fill="#F23936" />
                      <path
                        d="M37 21V19C37 16.243 34.757 14 32 14H18C15.243 14 13 16.243 13 19V21H37ZM21.5 16C22.328 16 23 16.672 23 17.5C23 18.328 22.328 19 21.5 19C20.672 19 20 18.328 20 17.5C20 16.672 20.672 16 21.5 16ZM17.5 16C18.328 16 19 16.672 19 17.5C19 18.328 18.328 19 17.5 19C16.672 19 16 18.328 16 17.5C16 16.672 16.672 16 17.5 16ZM13 23V31C13 33.757 15.243 36 18 36H32C34.757 36 37 33.757 37 31V23H13ZM21.026 29.722L23.188 31.776C23.588 32.156 23.605 32.789 23.224 33.189C22.844 33.59 22.21 33.606 21.811 33.225L19.63 31.154C18.739 30.264 18.739 28.846 19.611 27.974L21.792 25.793C22.183 25.402 22.815 25.402 23.206 25.793C23.597 26.184 23.597 26.816 23.206 27.207L21.025 29.388C20.933 29.48 20.933 29.63 21.025 29.722H21.026ZM30.387 31.136L28.217 33.24C27.821 33.624 27.188 33.615 26.803 33.219C26.418 32.823 26.428 32.189 26.824 31.805L28.983 29.712C29.064 29.631 29.064 29.481 28.972 29.389L26.791 27.208C26.4 26.817 26.4 26.185 26.791 25.794C27.182 25.403 27.814 25.403 28.205 25.794L30.386 27.975C31.258 28.847 31.258 30.265 30.386 31.137L30.387 31.136Z"
                        fill="#FC8C76" />
                    </svg>
                  </div>
                  <div>
                    <h5 class="benefits-cards-title">IT & Developers</h5>
                    <p class="benefits-cards-text m-0">Automate workflows and focus on innovation, not upkeep.</p>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_460_61)">
                      <path
                        d="M40 24C40 32.275 33.275 39 25 39C16.725 39 10 32.275 10 24C10 15.725 16.725 9 25 9C25.9125 9 26.8375 9.0875 27.725 9.25C28.4 9.375 28.85 10.025 28.725 10.7C28.6 11.375 27.95 11.825 27.275 11.7C26.5375 11.5625 25.7625 11.5 25 11.5C18.1125 11.5 12.5 17.1125 12.5 24C12.5 30.8875 18.1125 36.5 25 36.5C31.8875 36.5 37.5 30.8875 37.5 24C37.5 23.2375 37.425 22.475 37.3 21.725C37.175 21.05 37.625 20.4 38.3 20.275C38.9875 20.15 39.625 20.6 39.75 21.275C39.9125 22.1625 40 23.0875 40 24ZM26.075 16.575C26.7625 16.675 27.3875 16.2 27.4875 15.5125C27.5875 14.825 27.1125 14.2 26.425 14.1C25.95 14.0375 25.475 14 25 14C19.4875 14 15 18.4875 15 24C15 29.5125 19.4875 34 25 34C30.5125 34 35 29.5125 35 24C35 23.525 34.9625 23.05 34.9 22.575C34.8 21.8875 34.175 21.4125 33.4875 21.5125C32.8 21.6125 32.325 22.2375 32.425 22.925C32.475 23.275 32.5 23.6375 32.5 24C32.5 28.1375 29.1375 31.5 25 31.5C20.8625 31.5 17.5 28.1375 17.5 24C17.5 19.8625 20.8625 16.5 25 16.5C25.3625 16.5 25.725 16.525 26.075 16.575ZM23.3375 22.1375C23.85 21.675 23.9 20.8875 23.4375 20.375C22.975 19.8625 22.1875 19.8125 21.675 20.275C20.6125 21.225 20.0125 22.5875 20.0125 24C20.0125 26.7625 22.25 29 25.0125 29C26.4375 29 27.7875 28.3875 28.7375 27.3375C29.2 26.825 29.15 26.0375 28.6375 25.575C28.125 25.1125 27.3375 25.1625 26.875 25.675C26.4 26.2 25.725 26.5125 25.0125 26.5125C23.6375 26.5125 22.5125 25.3875 22.5125 24.0125C22.5125 23.3 22.8125 22.625 23.35 22.15L23.3375 22.1375ZM25.375 21.8625C24.8875 22.35 24.8875 23.1375 25.375 23.625C25.625 23.875 25.9375 23.9875 26.2625 23.9875C26.5875 23.9875 26.9 23.8625 27.15 23.625L33.0375 17.7375H36.275C36.6125 17.7375 36.925 17.6 37.1625 17.375L39.6625 14.875C40.025 14.5125 40.125 13.975 39.9375 13.5125C39.75 13.05 39.2875 12.7375 38.7875 12.7375H36.2875V10.25C36.2875 9.75 35.9875 9.2875 35.5125 9.1C35.0375 8.9 34.5125 9.0125 34.15 9.375L31.65 11.875C31.4125 12.1125 31.2875 12.425 31.2875 12.7625V16L25.4 21.8875L25.375 21.8625Z"
                        fill="#3AA3FE" />
                    </g>
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#36A3F2" />
                    <defs>
                      <clipPath id="clip0_460_61">
                        <rect width="30" height="30" fill="white" transform="translate(10 9)" />
                      </clipPath>
                    </defs>
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Sales & Marketing Teams</h5>
                  <p class="benefits-cards-text m-0">
                    Run integrated campaigns with CRM and analytics tools.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#13C1F6" />
                    <path
                      d="M34.864 19.6811H34.3905C34.351 19.6811 34.3117 19.6318 34.3018 19.5923C34.1325 19.054 33.9145 18.5323 33.6506 18.0336C33.6309 17.9942 33.6212 17.935 33.6605 17.9054L33.996 17.5699C34.2873 17.2721 34.4502 16.8719 34.4498 16.4553C34.4518 16.2487 34.4128 16.0437 34.3349 15.8523C34.257 15.6609 34.1418 15.487 33.996 15.3405L32.102 13.4465C31.8054 13.1526 31.4048 12.9878 30.9873 12.9878C30.5698 12.9878 30.1691 13.1526 29.8726 13.4465L29.537 13.782C29.5075 13.8213 29.4484 13.8115 29.4089 13.7918C28.9101 13.528 28.3884 13.3101 27.8502 13.1406C27.8107 13.1307 27.7614 13.0914 27.7614 13.052V12.5784C27.7602 12.1602 27.5935 11.7594 27.2978 11.4637C27.0021 11.1679 26.6014 11.0012 26.1831 11H23.5194C23.1012 11.0012 22.7004 11.1679 22.4047 11.4637C22.109 11.7594 21.9424 12.1602 21.9412 12.5784V13.052C21.9412 13.0914 21.8918 13.1307 21.8523 13.1406C21.3141 13.3101 20.7924 13.5281 20.2936 13.7919C20.2543 13.8115 20.195 13.8214 20.1654 13.782L19.8302 13.4465C19.5335 13.1526 19.1329 12.9878 18.7153 12.9878C18.2978 12.9878 17.8971 13.1526 17.6005 13.4465L15.7065 15.3405C15.5607 15.487 15.4455 15.6609 15.3676 15.8523C15.2897 16.0437 15.2506 16.2487 15.2527 16.4553C15.2522 16.8719 15.4152 17.2721 15.7065 17.5699L16.042 17.9054C16.0812 17.935 16.0716 17.9943 16.0518 18.0336C15.788 18.5324 15.57 19.0541 15.4006 19.5923C15.391 19.6318 15.3515 19.6812 15.312 19.6812H14.8385C14.4202 19.6824 14.0195 19.849 13.7237 20.1448C13.428 20.4405 13.2613 20.8412 13.26 21.2595V23.923C13.2596 24.156 13.3117 24.3861 13.4124 24.5962C13.5132 24.8063 13.6601 24.991 13.8421 25.1364C14.1169 24.4285 14.5933 23.8166 15.2122 23.3765C15.8311 22.9364 16.5655 22.6875 17.3244 22.6604C18.2446 22.6698 19.1265 23.0296 19.7906 23.6666C19.7112 23.3137 19.6715 22.953 19.6722 22.5912C19.6722 21.2176 20.2178 19.9003 21.1891 18.9291C22.1604 17.9578 23.4777 17.4122 24.8512 17.4122C26.2248 17.4122 27.5421 17.9578 28.5134 18.9291C29.4846 19.9003 30.0303 21.2176 30.0303 22.5912C30.031 22.953 29.9913 23.3137 29.9118 23.6666C30.5759 23.0296 31.4579 22.6698 32.378 22.6604C33.137 22.6875 33.8714 22.9365 34.4903 23.3765C35.1093 23.8166 35.5857 24.4285 35.8606 25.1364C36.0425 24.9909 36.1893 24.8062 36.2901 24.5961C36.3908 24.3861 36.4429 24.156 36.4425 23.923V21.2595C36.4412 20.8412 36.2745 20.4405 35.9788 20.1447C35.683 19.849 35.2822 19.6823 34.864 19.6811Z"
                      fill="#14C4F6" />
                    <path
                      d="M28.8713 34.4009L26.9069 33.7466C26.8474 33.726 26.7945 33.6896 26.754 33.6413C26.7134 33.593 26.6867 33.5347 26.6768 33.4724C26.6668 33.4102 26.6739 33.3464 26.6973 33.2878C26.7207 33.2293 26.7595 33.1782 26.8097 33.14C27.2962 32.713 27.6833 32.1847 27.9438 31.5922C28.2042 30.9996 28.3317 30.3572 28.3173 29.71C28.3173 27.4129 26.7656 25.5508 24.8513 25.5508C22.937 25.5508 21.3852 27.4129 21.3852 29.71C21.3708 30.3572 21.4983 30.9996 21.7588 31.5922C22.0192 32.1847 22.4063 32.713 22.8929 33.14C22.943 33.1782 22.9819 33.2293 23.0053 33.2878C23.0287 33.3464 23.0358 33.4102 23.0258 33.4724C23.0158 33.5347 22.9891 33.593 22.9486 33.6413C22.9081 33.6896 22.8552 33.726 22.7956 33.7466L20.8312 34.4009C20.3532 34.5601 19.9156 34.8217 19.549 35.1673C19.1824 35.5129 18.8956 35.9343 18.7084 36.4021L18.2995 37.4244C18.2574 37.5296 18.2417 37.6435 18.2539 37.7562C18.266 37.8688 18.3056 37.9767 18.3691 38.0705C18.4326 38.1643 18.5181 38.2411 18.6182 38.2942C18.7183 38.3473 18.8298 38.3751 18.9431 38.3751H30.7595C30.8727 38.3751 30.9843 38.3473 31.0844 38.2942C31.1844 38.2411 31.27 38.1643 31.3335 38.0705C31.397 37.9767 31.4365 37.8688 31.4487 37.7562C31.4608 37.6435 31.4452 37.5296 31.4031 37.4244L30.9941 36.4021C30.807 35.9343 30.5201 35.5129 30.1535 35.1673C29.7869 34.8217 29.3494 34.5601 28.8713 34.4009Z"
                      fill="#14C4F6" />
                    <path
                      d="M21.5267 33.1265L20.5205 33.462C19.9151 33.6642 19.3601 33.9939 18.8929 34.4288H12.3525C12.2577 34.4283 12.1644 34.4046 12.0809 34.3596C11.9973 34.3147 11.9261 34.2499 11.8735 34.171C11.8209 34.092 11.7885 34.0014 11.7791 33.907C11.7698 33.8126 11.7838 33.7174 11.8198 33.6296L12.1551 32.7715C12.3146 32.3789 12.5565 32.0251 12.8646 31.734C13.1726 31.443 13.5396 31.2215 13.9407 31.0846L15.5981 30.5322C15.6487 30.5164 15.6938 30.4867 15.7284 30.4466C15.763 30.4064 15.7857 30.3574 15.7939 30.3051C15.8021 30.2527 15.7955 30.1992 15.7748 30.1504C15.7541 30.1016 15.7202 30.0596 15.6769 30.029C15.2691 29.6679 14.9449 29.2222 14.7268 28.723C14.5088 28.2239 14.4021 27.6832 14.4142 27.1386C14.3433 26.2909 14.6089 25.4493 15.1535 24.7959C15.6981 24.1424 16.478 23.7295 17.3246 23.6465C18.1721 23.729 18.9533 24.1413 19.4996 24.7946C20.0459 25.4479 20.3134 26.2898 20.2446 27.1386C20.2572 27.6842 20.1498 28.2259 19.9298 28.7254C19.7099 29.2249 19.3828 29.67 18.9718 30.029C18.9305 30.0608 18.8986 30.1031 18.8793 30.1515C18.86 30.1999 18.8541 30.2525 18.8622 30.304C18.8702 30.3554 18.892 30.4038 18.9252 30.4439C18.9584 30.4841 19.0018 30.5145 19.0508 30.5321L20.5599 31.0352C20.7226 31.7956 21.0528 32.51 21.5267 33.1265Z"
                      fill="#14C4F6" />
                    <path
                      d="M37.35 34.4287H30.8097C30.3425 33.9938 29.7875 33.6642 29.1821 33.462L28.1759 33.1265C28.6498 32.5101 28.9801 31.7956 29.1426 31.0352L30.6517 30.5321C30.7008 30.5145 30.7441 30.4841 30.7773 30.4439C30.8105 30.4038 30.8323 30.3554 30.8404 30.304C30.8485 30.2525 30.8425 30.1999 30.8232 30.1515C30.804 30.1031 30.772 30.0608 30.7307 30.029C30.3198 29.6699 29.9927 29.2249 29.7728 28.7254C29.5529 28.2259 29.4455 27.6842 29.4582 27.1386C29.3893 26.2898 29.6568 25.4479 30.2031 24.7946C30.7494 24.1413 31.5306 23.729 32.3782 23.6465C33.2247 23.7295 34.0046 24.1424 34.5492 24.7959C35.0938 25.4494 35.3593 26.2909 35.2884 27.1386C35.3006 27.6832 35.1939 28.2239 34.9758 28.7231C34.7578 29.2222 34.4335 29.6679 34.0257 30.029C33.9824 30.0596 33.9486 30.1016 33.9279 30.1504C33.9072 30.1991 33.9006 30.2527 33.9088 30.305C33.917 30.3574 33.9397 30.4064 33.9742 30.4465C34.0088 30.4866 34.0539 30.5163 34.1045 30.5321L35.7619 31.0845C36.163 31.2214 36.53 31.4429 36.8381 31.734C37.1461 32.025 37.3881 32.3788 37.5475 32.7715L37.8828 33.6296C37.9189 33.7173 37.9329 33.8126 37.9235 33.907C37.9141 34.0014 37.8817 34.092 37.8291 34.171C37.7765 34.2499 37.7053 34.3147 37.6217 34.3596C37.5382 34.4046 37.4449 34.4283 37.35 34.4287Z"
                      fill="#14C4F6" />
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Project Managers</h5>
                  <p class="benefits-cards-text m-0">Keep projects on track with clear visibility over teams and tasks.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M19.6844 29.4644C20.3444 30.2284 21.1612 30.8412 22.0792 31.2613C22.9972 31.6813 23.9949 31.8987 25.0044 31.8987C26.0139 31.8987 27.0116 31.6813 27.9296 31.2612C28.8476 30.8412 29.6644 30.2283 30.3243 29.4644C30.3065 29.0409 30.1608 28.6327 29.9064 28.2937C29.6519 27.9547 29.3007 27.7007 28.899 27.5654L26.1782 26.6598C25.4159 26.4083 24.5929 26.4083 23.8306 26.6598L21.1098 27.5654C20.7081 27.7007 20.3569 27.9547 20.1024 28.2937C19.8479 28.6327 19.7022 29.0409 19.6844 29.4644Z"
                      fill="#FB8771" />
                    <path
                      d="M27.5784 23.0589C27.5769 22.3767 27.3052 21.7229 26.8228 21.2405C26.3404 20.7581 25.6866 20.4864 25.0044 20.4849C21.5997 20.6077 21.5966 25.5138 25.0044 25.6329C25.6871 25.6328 26.3417 25.3615 26.8244 24.8788C27.307 24.3961 27.5783 23.7415 27.5784 23.0589Z"
                      fill="#FB8771" />
                    <path
                      d="M32.0306 24.8906C31.6436 15.5694 18.3635 15.5725 17.9781 24.8907C17.979 26.1853 18.3405 27.454 19.0221 28.5547C19.1718 28.1388 19.4136 27.7621 19.7294 27.4529C20.0452 27.1436 20.4268 26.9098 20.8457 26.7688L23.2353 25.9722C22.5988 25.5861 22.1063 25.0023 21.8327 24.3101C21.5591 23.6178 21.5195 22.855 21.7199 22.1381C21.9204 21.4212 22.3499 20.7896 22.943 20.3396C23.536 19.8897 24.2599 19.6462 25.0043 19.6462C25.7487 19.6462 26.4727 19.8897 27.0657 20.3396C27.6587 20.7896 28.0883 21.4212 28.2887 22.1381C28.4892 22.855 28.4496 23.6178 28.176 24.3101C27.9024 25.0023 27.4098 25.5861 26.7734 25.9722L29.1631 26.7688C29.582 26.9098 29.9636 27.1436 30.2794 27.4529C30.5952 27.7621 30.837 28.1388 30.9867 28.5547C31.6683 27.454 32.0297 26.1852 32.0306 24.8906Z"
                      fill="#FB8771" />
                    <path
                      d="M14.9681 27.9597C15.0757 27.9304 15.1674 27.8598 15.2232 27.7632C15.2789 27.6666 15.2942 27.5518 15.2658 27.444C13.728 21.9715 17.4368 16.046 23.0257 15.014C23.1769 15.5038 23.5045 15.9201 23.9449 16.1823C24.3853 16.4446 24.9074 16.5342 25.4101 16.4338C25.9127 16.3334 26.3603 16.0501 26.6662 15.6388C26.9721 15.2275 27.1146 14.7173 27.0661 14.207C27.0176 13.6967 26.7815 13.2225 26.4036 12.8762C26.0257 12.5299 25.5328 12.336 25.0202 12.3321C24.5076 12.3282 24.0118 12.5145 23.6287 12.855C23.2455 13.1956 23.0023 13.6661 22.946 14.1756C16.847 15.2465 12.7839 21.7016 14.4525 27.662C14.483 27.7689 14.5538 27.8598 14.65 27.9153C14.7463 27.9709 14.8603 27.9868 14.9681 27.9597Z"
                      fill="#FB8771" />
                    <path
                      d="M31.2969 32.7513C27.4383 35.9741 21.2632 35.594 17.8105 31.9422C18.1478 31.5672 18.3332 31.08 18.3304 30.5756C18.3309 30.1273 18.186 29.6909 17.9174 29.332C17.6488 28.9731 17.2709 28.711 16.8406 28.5852C16.4103 28.4594 15.9508 28.4766 15.5311 28.6342C15.1115 28.7919 14.7543 29.0815 14.5133 29.4595C14.2722 29.8375 14.1604 30.2835 14.1945 30.7305C14.2286 31.1775 14.4069 31.6014 14.7025 31.9384C14.9981 32.2755 15.3951 32.5075 15.8338 32.5996C16.2726 32.6918 16.7294 32.639 17.1356 32.4494C20.8605 36.4779 27.6108 36.9227 31.8252 33.4053C31.9091 33.3344 31.9619 33.2334 31.9723 33.124C31.9827 33.0146 31.9499 32.9055 31.8809 32.82C31.8118 32.7345 31.7121 32.6795 31.6029 32.6666C31.4938 32.6538 31.384 32.6841 31.2969 32.7513Z"
                      fill="#FB8771" />
                    <path
                      d="M28.4211 14.5274C28.3161 14.4955 28.2029 14.506 28.1056 14.5566C28.0083 14.6073 27.9347 14.694 27.9007 14.7983C27.8667 14.9026 27.8749 15.016 27.9235 15.1143C27.9722 15.2126 28.0575 15.2879 28.1611 15.324C33.5932 17.0119 36.5263 23.3468 34.3741 28.6008C33.9578 28.4691 33.5105 28.4723 33.0961 28.6101C32.6818 28.7478 32.3216 29.013 32.067 29.3678C31.8124 29.7225 31.6764 30.1486 31.6785 30.5853C31.6806 31.0219 31.8207 31.4467 32.0787 31.799C32.3367 32.1513 32.6995 32.413 33.1152 32.5467C33.5308 32.6804 33.9781 32.6793 34.3932 32.5436C34.8082 32.4079 35.1697 32.1444 35.426 31.7909C35.6823 31.4374 35.8203 31.012 35.8204 30.5753C35.8208 30.2794 35.7574 29.9868 35.6344 29.7177C35.5114 29.4485 35.3317 29.2091 35.1077 29.0158C37.5297 23.3138 34.3454 16.3712 28.4211 14.5274Z"
                      fill="#FB8771" />
                    <path
                      d="M25 10.9375C22.2187 10.9375 19.4999 11.7623 17.1873 13.3075C14.8747 14.8527 13.0723 17.0489 12.008 19.6185C10.9436 22.1881 10.6651 25.0156 11.2077 27.7435C11.7503 30.4713 13.0896 32.977 15.0563 34.9437C17.023 36.9104 19.5287 38.2497 22.2565 38.7923C24.9844 39.3349 27.8119 39.0564 30.3815 37.9921C32.9511 36.9277 35.1473 35.1253 36.6925 32.8127C38.2378 30.5001 39.0625 27.7813 39.0625 25C39.0583 21.2717 37.5754 17.6973 34.939 15.061C32.3027 12.4246 28.7283 10.9417 25 10.9375ZM25 38.2615C22.3771 38.2615 19.8131 37.4838 17.6323 36.0266C15.4514 34.5694 13.7517 32.4982 12.748 30.075C11.7442 27.6517 11.4816 24.9853 11.9933 22.4128C12.505 19.8403 13.768 17.4773 15.6227 15.6227C17.4773 13.768 19.8403 12.505 22.4128 11.9933C24.9853 11.4816 27.6517 11.7442 30.075 12.7479C32.4982 13.7517 34.5694 15.4514 36.0266 17.6323C37.4838 19.8131 38.2615 22.3771 38.2615 25C38.2576 28.516 36.8591 31.8868 34.3729 34.3729C31.8868 36.8591 28.516 38.2576 25 38.2615Z"
                      fill="#FB8771" />
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#F23936" />
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">HR Professionals</h5>
                  <p class="benefits-cards-text m-0">Manage onboarding, payroll, and employee data simply.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_460_83)">
                      <path
                        d="M36.9167 34.8333H17.4167C16.5547 34.8333 15.7281 34.4909 15.1186 33.8814C14.5091 33.2719 14.1667 32.4453 14.1667 31.5833V12.0833C14.1667 11.796 14.0525 11.5205 13.8494 11.3173C13.6462 11.1141 13.3707 11 13.0833 11C12.796 11 12.5205 11.1141 12.3173 11.3173C12.1141 11.5205 12 11.796 12 12.0833V31.5833C12.0017 33.0194 12.573 34.3961 13.5884 35.4116C14.6039 36.427 15.9806 36.9983 17.4167 37H36.9167C37.204 37 37.4795 36.8859 37.6827 36.6827C37.8859 36.4795 38 36.204 38 35.9167C38 35.6293 37.8859 35.3538 37.6827 35.1506C37.4795 34.9475 37.204 34.8333 36.9167 34.8333Z"
                        fill="#108AEA" />
                      <path
                        d="M18.5 32.6665C18.7873 32.6665 19.0629 32.5524 19.2661 32.3492C19.4692 32.146 19.5834 31.8705 19.5834 31.5832V23.9998C19.5834 23.7125 19.4692 23.437 19.2661 23.2338C19.0629 23.0306 18.7873 22.9165 18.5 22.9165C18.2127 22.9165 17.9372 23.0306 17.734 23.2338C17.5308 23.437 17.4167 23.7125 17.4167 23.9998V31.5832C17.4167 31.8705 17.5308 32.146 17.734 32.3492C17.9372 32.5524 18.2127 32.6665 18.5 32.6665Z"
                        fill="#108AEA" />
                      <path
                        d="M22.8333 21.8333V31.5833C22.8333 31.8707 22.9474 32.1462 23.1506 32.3494C23.3538 32.5525 23.6293 32.6667 23.9166 32.6667C24.204 32.6667 24.4795 32.5525 24.6827 32.3494C24.8858 32.1462 25 31.8707 25 31.5833V21.8333C25 21.546 24.8858 21.2705 24.6827 21.0673C24.4795 20.8641 24.204 20.75 23.9166 20.75C23.6293 20.75 23.3538 20.8641 23.1506 21.0673C22.9474 21.2705 22.8333 21.546 22.8333 21.8333Z"
                        fill="#108AEA" />
                      <path
                        d="M28.25 25.0833V31.5833C28.25 31.8707 28.3641 32.1462 28.5673 32.3494C28.7705 32.5525 29.046 32.6667 29.3333 32.6667C29.6207 32.6667 29.8962 32.5525 30.0994 32.3494C30.3025 32.1462 30.4167 31.8707 30.4167 31.5833V25.0833C30.4167 24.796 30.3025 24.5205 30.0994 24.3173C29.8962 24.1141 29.6207 24 29.3333 24C29.046 24 28.7705 24.1141 28.5673 24.3173C28.3641 24.5205 28.25 24.796 28.25 25.0833Z"
                        fill="#108AEA" />
                      <path
                        d="M33.6667 20.7498V31.5832C33.6667 31.8705 33.7808 32.146 33.984 32.3492C34.1872 32.5524 34.4627 32.6665 34.75 32.6665C35.0373 32.6665 35.3129 32.5524 35.5161 32.3492C35.7192 32.146 35.8334 31.8705 35.8334 31.5832V20.7498C35.8334 20.4625 35.7192 20.187 35.5161 19.9838C35.3129 19.7806 35.0373 19.6665 34.75 19.6665C34.4627 19.6665 34.1872 19.7806 33.984 19.9838C33.7808 20.187 33.6667 20.4625 33.6667 20.7498Z"
                        fill="#108AEA" />
                      <path
                        d="M18.5 20.7499C18.7873 20.7498 19.0628 20.6356 19.2659 20.4325L23.1507 16.5476C23.3572 16.3509 23.6315 16.2412 23.9166 16.2412C24.2018 16.2412 24.4761 16.3509 24.6826 16.5476L27.0356 18.9006C27.645 19.5099 28.4715 19.8522 29.3333 19.8522C30.1951 19.8522 31.0216 19.5099 31.6311 18.9006L37.6826 12.8491C37.8799 12.6448 37.9891 12.3711 37.9866 12.0871C37.9841 11.8031 37.8702 11.5313 37.6694 11.3305C37.4685 11.1296 37.1968 11.0157 36.9127 11.0132C36.6287 11.0108 36.355 11.12 36.1507 11.3173L30.0992 17.3677C29.8961 17.5708 29.6206 17.6849 29.3333 17.6849C29.046 17.6849 28.7705 17.5708 28.5674 17.3677L26.2144 15.0158C25.6049 14.4065 24.7784 14.0642 23.9166 14.0642C23.0549 14.0642 22.2284 14.4065 21.6189 15.0158L17.7341 18.9006C17.5826 19.0521 17.4795 19.2451 17.4377 19.4553C17.3959 19.6654 17.4173 19.8832 17.4993 20.0811C17.5813 20.279 17.7201 20.4482 17.8982 20.5672C18.0763 20.6863 18.2857 20.7498 18.5 20.7499Z"
                        fill="#108AEA" />
                    </g>
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#36A3F2" />
                    <defs>
                      <clipPath id="clip0_460_83">
                        <rect width="26" height="26" fill="white" transform="translate(12 11)" />
                      </clipPath>
                    </defs>
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Finance & Admin</h5>
                  <p class="benefits-cards-text m-0">Get paid faster and track your finances securely.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#F23685" />
                    <g clip-path="url(#clip0_460_33)">
                      <path
                        d="M38 15.25V34.3285L25 38.0433L12 34.3285V16.3333C12 15.3041 12.4712 14.3584 13.2935 13.7387C13.5632 13.535 13.8601 13.3964 14.1666 13.2859V32.6949L25 35.79L35.8333 32.6949V12.2025C36.1399 12.313 36.4378 12.4517 36.7065 12.6554C37.5287 13.275 38 14.2208 38 15.25ZM26.0833 15.6519V31.1035L25 31.4133L23.9166 31.1035V15.6519C23.9166 14.2089 22.9471 12.923 21.4781 12.507L19.67 12.0747C17.9681 11.6685 16.3333 12.9598 16.3333 14.7094V31.1901L25 33.6666L33.6666 31.1901V14.7462C33.6666 13.0161 32.0666 11.7291 30.3766 12.1007L28.4396 12.5265C27.0518 12.923 26.0822 14.2089 26.0822 15.6519H26.0833Z"
                        fill="#FE6A96" />
                    </g>
                    <defs>
                      <clipPath id="clip0_460_33">
                        <rect width="26" height="26" fill="white" transform="translate(12 12)" />
                      </clipPath>
                    </defs>
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Educators & Trainers</h5>
                  <p class="benefits-cards-text m-0">Run virtual classes and track student performance.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.2" cx="25" cy="25" r="25" fill="#14C4F6" />
                    <path
                      d="M29.6308 21.6028C32.2914 21.6028 34.4561 19.4381 34.4561 16.7775C34.4561 14.1168 32.2914 11.9521 29.6308 11.9521C26.9702 11.9521 24.8055 14.1168 24.8055 16.7775C24.8055 19.4381 26.9702 21.6028 29.6308 21.6028Z"
                      fill="#14C4F6" />
                    <path
                      d="M31.2343 24.168H28.1687C26.0889 24.168 24.1618 25.0862 22.8606 26.6617H27.5776C27.7961 26.6617 27.9854 26.8127 28.0347 27.025L29.6936 34.1955H32.6354C33.1347 34.1955 33.5415 33.7609 33.5415 33.227V30.9827C33.5415 30.7239 33.7515 30.5139 34.0103 30.5139C34.269 30.5139 34.479 30.7239 34.479 30.9827V33.227C34.479 34.278 33.6522 35.133 32.6354 35.133H29.9106L30.5851 38.0477H34.4134C36.46 38.0477 38.1245 36.3827 38.1245 34.3366V31.0586C38.1245 27.2594 35.034 24.168 31.2343 24.168Z"
                      fill="#14C4F6" />
                    <path d="M21.9437 27.5991H11.995L14.4133 38.0476H29.6228L27.205 27.5991H21.9437Z" fill="#14C4F6" />
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Procurement Managers</h5>
                  <p class="benefits-cards-text m-0">Track performance, forecast sales, and coach teams with real-time insights.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 9 -->
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="shadow-sm benefits-cards">
              <div class="d-flex gap-3">
                <div>
                  <svg width="50" height="55" viewBox="0 0 50 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle opacity="0.2" cx="25" cy="30" r="25" fill="#36A3F2" />
                    <path
                      d="M20.0536 27.9362C17.9149 26.0546 17.5119 22.848 19.1191 20.5014C20.7262 18.1549 23.8263 17.4238 26.3068 18.8063L29.7996 20.753C32.9062 22.4845 33.86 26.557 31.8471 29.4959C29.8343 32.4347 25.7435 32.9424 23.065 30.5858L20.0536 27.9362Z"
                      fill="url(#paint0_linear_162_5293)" />
                    <g opacity="0.5" filter="url(#filter0_f_162_5293)">
                      <path
                        d="M21.8495 26.7643C20.5853 25.6521 20.3471 23.7567 21.2971 22.3697C22.2471 20.9827 24.0795 20.5505 25.5457 21.3677L27.6102 22.5184C29.4465 23.5419 30.0102 25.9491 28.8205 27.6862C27.6307 29.4233 25.2127 29.7234 23.6295 28.3305L21.8495 26.7643Z"
                        fill="#0062FF" />
                    </g>
                    <foreignObject x="-12" y="-1.94043" width="74" height="71.9404">
                      <div xmlns="http://www.w3.org/1999/xhtml"
                        style="backdrop-filter:blur(12px);clip-path:url(#bgblur_0_162_5293_clip_path);height:100%;width:100%">
                      </div>
                    </foreignObject>
                    <g data-figma-bg-blur-radius="24">
                      <mask id="path-4-outside-1_162_5293" maskUnits="userSpaceOnUse" x="12" y="22.0596" width="26"
                        height="24" fill="black">
                        <rect fill="white" x="12" y="22.0596" width="26" height="24" />
                        <path
                          d="M36.1 35.8293C35.1148 35.8293 34.3132 35.0225 34.3132 34.0309C34.3132 33.0381 35.1148 32.2314 36.1 32.2314C36.3388 32.2314 36.568 32.1359 36.736 31.9669C36.9052 31.7966 37 31.5659 37 31.3255L36.9988 28.0621C36.9988 25.3036 34.768 23.0596 32.0272 23.0596H17.9728C15.232 23.0596 13.0012 25.3036 13.0012 28.0621L13 31.4306C13 31.6709 13.0948 31.9016 13.264 32.0719C13.432 32.241 13.6612 32.3364 13.9 32.3364C14.9188 32.3364 15.6868 33.0647 15.6868 34.0309C15.6868 35.0225 14.8852 35.8293 13.9 35.8293C13.4032 35.8293 13 36.2351 13 36.7351V39.9961C13 42.7546 15.2296 44.9999 17.9716 44.9999H32.0284C34.7704 44.9999 37 42.7546 37 39.9961V36.7351C37 36.2351 36.5968 35.8293 36.1 35.8293Z" />
                      </mask>
                      <path
                        d="M36.1 35.8293C35.1148 35.8293 34.3132 35.0225 34.3132 34.0309C34.3132 33.0381 35.1148 32.2314 36.1 32.2314C36.3388 32.2314 36.568 32.1359 36.736 31.9669C36.9052 31.7966 37 31.5659 37 31.3255L36.9988 28.0621C36.9988 25.3036 34.768 23.0596 32.0272 23.0596H17.9728C15.232 23.0596 13.0012 25.3036 13.0012 28.0621L13 31.4306C13 31.6709 13.0948 31.9016 13.264 32.0719C13.432 32.241 13.6612 32.3364 13.9 32.3364C14.9188 32.3364 15.6868 33.0647 15.6868 34.0309C15.6868 35.0225 14.8852 35.8293 13.9 35.8293C13.4032 35.8293 13 36.2351 13 36.7351V39.9961C13 42.7546 15.2296 44.9999 17.9716 44.9999H32.0284C34.7704 44.9999 37 42.7546 37 39.9961V36.7351C37 36.2351 36.5968 35.8293 36.1 35.8293Z"
                        fill="#3EA0FE" fill-opacity="0.35" />
                      <path
                        d="M36.1 36.8293C36.6523 36.8293 37.1 36.3816 37.1 35.8293C37.1 35.277 36.6523 34.8293 36.1 34.8293V36.8293ZM36.736 31.9669L36.0266 31.262L36.736 31.9669ZM37 31.3255H38L38 31.3252L37 31.3255ZM36.9988 28.0621H35.9988V28.0625L36.9988 28.0621ZM13.0012 28.0621L14.0012 28.0625V28.0621H13.0012ZM13 31.4306L12 31.4302V31.4306H13ZM13.264 32.0719L13.9734 31.3671H13.9734L13.264 32.0719ZM36.1 34.8293C35.5477 34.8293 35.1 35.277 35.1 35.8293C35.1 36.3816 35.5477 36.8293 36.1 36.8293V34.8293ZM36.1 35.8293V34.8293C35.6732 34.8293 35.3132 34.4763 35.3132 34.0309H34.3132H33.3132C33.3132 35.5687 34.5564 36.8293 36.1 36.8293V35.8293ZM34.3132 34.0309H35.3132C35.3132 33.5839 35.6736 33.2314 36.1 33.2314V32.2314V31.2314C34.556 31.2314 33.3132 32.4924 33.3132 34.0309H34.3132ZM36.1 32.2314V33.2314C36.605 33.2314 37.0896 33.0298 37.4454 32.6717L36.736 31.9669L36.0266 31.262C36.0464 31.2421 36.0726 31.2314 36.1 31.2314V32.2314ZM36.736 31.9669L37.4454 32.6717C37.8015 32.3133 38 31.8289 38 31.3255H37H36C36 31.3028 36.0089 31.2798 36.0266 31.262L36.736 31.9669ZM37 31.3255L38 31.3252L37.9988 28.0618L36.9988 28.0621L35.9988 28.0625L36 31.3259L37 31.3255ZM36.9988 28.0621H37.9988C37.9988 24.7571 35.326 22.0596 32.0272 22.0596V23.0596V24.0596C34.21 24.0596 35.9988 25.8501 35.9988 28.0621H36.9988ZM32.0272 23.0596V22.0596H17.9728V23.0596V24.0596H32.0272V23.0596ZM17.9728 23.0596V22.0596C14.674 22.0596 12.0012 24.7571 12.0012 28.0621H13.0012H14.0012C14.0012 25.8501 15.79 24.0596 17.9728 24.0596V23.0596ZM13.0012 28.0621L12.0012 28.0618L12 31.4302L13 31.4306L14 31.431L14.0012 28.0625L13.0012 28.0621ZM13 31.4306H12C12 31.934 12.1985 32.4184 12.5546 32.7768L13.264 32.0719L13.9734 31.3671C13.9911 31.3849 14 31.4079 14 31.4306H13ZM13.264 32.0719L12.5546 32.7768C12.9104 33.1349 13.395 33.3364 13.9 33.3364V32.3364V31.3364C13.9274 31.3364 13.9536 31.3472 13.9734 31.3671L13.264 32.0719ZM13.9 32.3364V33.3364C14.4172 33.3364 14.6868 33.6663 14.6868 34.0309H15.6868H16.6868C16.6868 32.4631 15.4204 31.3364 13.9 31.3364V32.3364ZM15.6868 34.0309H14.6868C14.6868 34.4763 14.3268 34.8293 13.9 34.8293V35.8293V36.8293C15.4436 36.8293 16.6868 35.5687 16.6868 34.0309H15.6868ZM13.9 35.8293V34.8293C12.8448 34.8293 12 35.6889 12 36.7351H13H14C14 36.7813 13.9616 36.8293 13.9 36.8293V35.8293ZM13 36.7351H12V39.9961H13H14V36.7351H13ZM13 39.9961H12C12 43.3007 14.6711 45.9999 17.9716 45.9999V44.9999V43.9999C15.7881 43.9999 14 42.2086 14 39.9961H13ZM17.9716 44.9999V45.9999H32.0284V44.9999V43.9999H17.9716V44.9999ZM32.0284 44.9999V45.9999C35.3289 45.9999 38 43.3007 38 39.9961H37H36C36 42.2086 34.2119 43.9999 32.0284 43.9999V44.9999ZM37 39.9961H38V36.7351H37H36V39.9961H37ZM37 36.7351H38C38 35.6889 37.1552 34.8293 36.1 34.8293V35.8293V36.8293C36.0384 36.8293 36 36.7813 36 36.7351H37Z"
                        fill="url(#paint1_linear_162_5293)" mask="url(#path-4-outside-1_162_5293)" />
                    </g>
                    <foreignObject x="5.61322" y="14.3984" width="38.7729" height="38.564">
                      <div xmlns="http://www.w3.org/1999/xhtml"
                        style="backdrop-filter:blur(7.5px);clip-path:url(#bgblur_1_162_5293_clip_path);height:100%;width:100%">
                      </div>
                    </foreignObject>
                    <g filter="url(#filter2_d_162_5293)" data-figma-bg-blur-radius="15">
                      <path
                        d="M29.1165 33.5281L27.7017 34.9274L28.0365 36.9057C28.0941 37.2482 27.9585 37.5858 27.6813 37.7882C27.4065 37.9929 27.0477 38.0185 26.7453 37.8552L24.9993 36.9227L23.2497 37.8564C23.1201 37.9259 22.9785 37.9625 22.8381 37.9625C22.6545 37.9625 22.4733 37.904 22.3173 37.7894C22.0413 37.5858 21.9057 37.2482 21.9633 36.9057L22.2969 34.9274L20.8821 33.5281C20.6373 33.2867 20.5521 32.932 20.6577 32.6017C20.7645 32.2726 21.0405 32.0386 21.3777 31.9898L23.3289 31.7009L24.2037 29.9006C24.3561 29.591 24.6609 29.3984 24.9993 29.3984H25.0017C25.3413 29.3997 25.6461 29.5922 25.7961 29.9018L26.6709 31.7009L28.6257 31.991C28.9593 32.0386 29.2353 32.2726 29.3409 32.6017C29.4477 32.932 29.3625 33.2867 29.1165 33.5281Z"
                        fill="url(#paint2_linear_162_5293)" />
                      <path
                        d="M24.999 29.498H25.0009L25.1122 29.5068C25.331 29.5385 25.5257 29.6604 25.6503 29.8467L25.706 29.9453L26.581 31.7451L26.6044 31.792L26.6562 31.7998L28.6113 32.0898C28.8692 32.1266 29.089 32.2898 29.2031 32.5264L29.246 32.6318V32.6328C29.3293 32.8907 29.2816 33.1642 29.122 33.3721L29.0468 33.457H29.0458L27.6318 34.8564L27.5947 34.8926L27.6035 34.9443L27.9374 36.9209V36.9219C27.9824 37.1895 27.8962 37.4529 27.7089 37.6348L27.622 37.707V37.708C27.4089 37.8668 27.1392 37.9038 26.8954 37.8135L26.7929 37.7676V37.7666L25.0468 36.835L24.999 36.8096L24.9521 36.835L23.2031 37.7686H23.2021C23.0864 37.8305 22.9607 37.8623 22.8378 37.8623C22.7164 37.8623 22.5956 37.8339 22.4843 37.7764L22.3769 37.709C22.1316 37.5281 22.011 37.2277 22.0624 36.9219L22.0615 36.9209L22.3954 34.9443L22.4042 34.8926L22.3671 34.8564L20.9521 33.457C20.7348 33.2428 20.6588 32.9277 20.7529 32.6328C20.8362 32.3759 21.0345 32.1848 21.2831 32.1123L21.3925 32.0889L23.3437 31.7998L23.3954 31.792L23.4189 31.7451L24.2939 29.9443C24.4299 29.6684 24.7 29.4982 24.999 29.498Z"
                        stroke="url(#paint3_linear_162_5293)" stroke-opacity="0.5" stroke-width="0.2" />
                    </g>
                    <defs>
                      <filter id="filter0_f_162_5293" x="0.716614" y="0.956055" width="48.7296" height="48.2524"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                        <feGaussianBlur stdDeviation="10" result="effect1_foregroundBlur_162_5293" />
                      </filter>
                      <clipPath id="bgblur_0_162_5293_clip_path" transform="translate(12 1.94043)">
                        <path
                          d="M36.1 35.8293C35.1148 35.8293 34.3132 35.0225 34.3132 34.0309C34.3132 33.0381 35.1148 32.2314 36.1 32.2314C36.3388 32.2314 36.568 32.1359 36.736 31.9669C36.9052 31.7966 37 31.5659 37 31.3255L36.9988 28.0621C36.9988 25.3036 34.768 23.0596 32.0272 23.0596H17.9728C15.232 23.0596 13.0012 25.3036 13.0012 28.0621L13 31.4306C13 31.6709 13.0948 31.9016 13.264 32.0719C13.432 32.241 13.6612 32.3364 13.9 32.3364C14.9188 32.3364 15.6868 33.0647 15.6868 34.0309C15.6868 35.0225 14.8852 35.8293 13.9 35.8293C13.4032 35.8293 13 36.2351 13 36.7351V39.9961C13 42.7546 15.2296 44.9999 17.9716 44.9999H32.0284C34.7704 44.9999 37 42.7546 37 39.9961V36.7351C37 36.2351 36.5968 35.8293 36.1 35.8293Z" />
                      </clipPath>
                      <filter id="filter2_d_162_5293" x="5.61322" y="14.3984" width="38.7729" height="38.564"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                          result="hardAlpha" />
                        <feOffset dx="5" dy="5" />
                        <feGaussianBlur stdDeviation="5" />
                        <feColorMatrix type="matrix"
                          values="0 0 0 0 0.15375 0 0 0 0 0.522433 0 0 0 0 0.9 0 0 0 0.5 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_162_5293" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_162_5293" result="shape" />
                      </filter>
                      <clipPath id="bgblur_1_162_5293_clip_path" transform="translate(-5.61322 -14.3984)">
                        <path
                          d="M29.1165 33.5281L27.7017 34.9274L28.0365 36.9057C28.0941 37.2482 27.9585 37.5858 27.6813 37.7882C27.4065 37.9929 27.0477 38.0185 26.7453 37.8552L24.9993 36.9227L23.2497 37.8564C23.1201 37.9259 22.9785 37.9625 22.8381 37.9625C22.6545 37.9625 22.4733 37.904 22.3173 37.7894C22.0413 37.5858 21.9057 37.2482 21.9633 36.9057L22.2969 34.9274L20.8821 33.5281C20.6373 33.2867 20.5521 32.932 20.6577 32.6017C20.7645 32.2726 21.0405 32.0386 21.3777 31.9898L23.3289 31.7009L24.2037 29.9006C24.3561 29.591 24.6609 29.3984 24.9993 29.3984H25.0017C25.3413 29.3997 25.6461 29.5922 25.7961 29.9018L26.6709 31.7009L28.6257 31.991C28.9593 32.0386 29.2353 32.2726 29.3409 32.6017C29.4477 32.932 29.3625 33.2867 29.1165 33.5281Z" />
                      </clipPath>
                      <linearGradient id="paint0_linear_162_5293" x1="22.3481" y1="15.7869" x2="20.9568" y2="33.6271"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#39AFFD" />
                        <stop offset="1" stop-color="#477FFF" />
                      </linearGradient>
                      <linearGradient id="paint1_linear_162_5293" x1="16.8204" y1="25.6156" x2="34.6547" y2="45.4885"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" stop-opacity="0.25" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                      <linearGradient id="paint2_linear_162_5293" x1="28.7642" y1="30.9449" x2="18.9924" y2="31.2713"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0.2" />
                      </linearGradient>
                      <linearGradient id="paint3_linear_162_5293" x1="21.5583" y1="32.2713" x2="29.0077" y2="32.3134"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </div>
                <div>
                  <h5 class="benefits-cards-title">Sales Managers</h5>
                  <p class="benefits-cards-text m-0">Track performance, forecast sales, and coach teams with real-time insights.</p>
                </div>
              </div>
            </div>
          </div>


        </div> <!-- row end -->
      </div>
    </div>
  </section>

  <!-- Seventh-section Industrites OF GSaaS -->

  <section class="overflow-hidden">
    <div class="d-flex align-items-center justify-content-center text-center"
      style="background: url('../public/Assest/images/industry-bg.png') no-repeat center center/cover; height: 180px; ">
      <h2 class=" text-white text-center industry-title">
        Industries of
        <span class="d-inline-block text-white px-3"
          style="background: url('../public/Assest/images/brush.png') no-repeat center center/contain;">
          GSaaS?
        </span>
      </h2>

    </div>

    <!-- Industry Categories Section -->
    <div
      style="background-image: linear-gradient(#eff8ff7b, rgba(239, 248, 255, 0.519)), url(../public/Assest/images/bg-indsutry.png); background-size: cover; background-position: center; background-repeat: no-repeat;"
      class="bg-industry-section">
      <!-- Retail Industry -->
      <div class="py-5">
        <div class="container">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold mb-0">RETAIL</h4>
            <div class="slider__buttons">
              <button class="slider__button slider__button--prev" data-slider-prev disabled>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
              <button class="slider__button" data-slider-next>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
            </div>
          </div>

          <div class="slider" data-slider>
            <ul class="slider__track" data-slider-track>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/agriculture.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Agriculture Supplies</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/clothing.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Fashion Outlets</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/bookstore.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Bookstores</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/furniture.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Furniture Shops</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/grocery.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Grocery Stores</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/bakery.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Bakeries</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Smart-Home-Retailers-1.svg" alt="" width="75px">
                  </div>
                  <h3 class="category-box-title mt-3">Smart Home Retailers</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Toy-Hobby-Stores-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Toy & Hobby <br/>Stores</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Jewelry-Retailers-1.svg" alt="" width="80px">
                  </div>
                  <h3 class="category-box-title mt-3">Jewelry Retailers</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Beauty-Tech-Stores-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Beauty Tech <br/>Stores</h3>
                </div>
              </li>
            </ul>
          </div>
        </div>


      </div>

      <!-- Health & Fitness -->
      <div style="background-color: white;" class="py-5">
        <div class="container">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold mb-0">HEALTH & FITNESS</h4>
            <div class="slider__buttons">
              <button class="slider__button slider__button--prev" data-slider-prev-1 disabled>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
              <button class="slider__button" data-slider-next-1>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
            </div>
          </div>

          <div class="slider" data-slider-1>
            <ul class="slider__track" data-slider-track-1>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/eyewear.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Eyewear Retailers</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/fitness.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Fitness Centres</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/nutrition.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Nutritionists</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/minimal.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Health Providers</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/lifestyle.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Wellness Coaches</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/eyewear.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Sports Clubs</h3>
                </div>
              </li>
               <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Holistic-Health-Retreats-1.svg" alt="" width="70px">
                  </div>
                  <h3 class="category-box-title mt-3">Holistic Health Retreats</h3>
                </div>
              </li>
               <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Prenatal-Fitness-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Prenatal Fitness</h3>
                </div>
              </li>
               <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Recovery-Clinics-1.svg" alt="" width="70px">
                  </div>
                  <h3 class="category-box-title mt-3">Recovery Clinics</h3>
                </div>
              </li>
               <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Athletic-Recovery-Centers-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Athletic Recovery Centers</h3>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>


      <!-- Supply Chain -->
      <div class=" py-5">
        <div class="container">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold mb-0 supply-chain">SUPPLY CHAIN & HOSPITALITY</h4>
            <div class="slider__buttons">
              <button class="slider__button slider__button--prev" data-slider-prev-2 disabled>
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
              <button class="slider__button" data-slider-next-2 >
                <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M33.9992 16.9083C33.9992 7.57491 26.4243 0 17.0909 0C7.75753 0 0.182617 7.57491 0.182617 16.9083C0.182617 26.2417 7.75753 33.8166 17.0909 33.8166C26.4243 33.8166 33.9992 26.2417 33.9992 16.9083ZM18.0265 19.918H8.0957C8.08443 19.918 8.07315 19.9067 8.07315 19.8954V13.9212C8.07315 13.91 8.08443 13.8986 8.0957 13.8986H18.0265V9.09666L26.1087 16.9083L18.0265 24.7199V19.918Z"
                    fill="#092B3B" />
                </svg>
              </button>
            </div>
          </div>

          <div class="slider" data-slider-2>
            <ul class="slider__track" data-slider-track-2>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/beverage.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Beverage Distributors</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/customfurniture.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Furniture Makers</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/corporate.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Corporate Gifting</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/microbrewery.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Microbreweries</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/hospitality.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Restaurants</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/fastfood.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Fast Food</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/beverage.png" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Brand Outlets</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Cloud-Kitchen-Networks-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Cloud Kitchen Networks</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Event-Rental-Services-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Event Rental Services</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/B2B-Hospitality-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">B2B Hospitality</h3>
                </div>
              </li>
              <li>
                <div class="slide">
                  <div class="category-box d-flex align-items-center justify-content-center">
                    <img src="../public/Assest/images/Cold-Chain-Logistics-1.svg" alt="" width="60px">
                  </div>
                  <h3 class="category-box-title mt-3">Cold Chain <br/>Logistics</h3>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    </div>

  </section>

  <!-- Eight-Section Featuers -->

  <section style="background-color: white;" class="py-5 text-center shadow-lg ">
    <!-- Heading -->
    <div class="heading py-5">
      <div class="position-relative">
        <img src="../public/Assest/images/lefttech.png" alt="corner image" class="features-main-img img-fluid ml-3 techimg">
        <div class=" position-relative w-100 mr feature-section">
          <h2 style="font-size: 64px; font-weight: 700;" class="font mb-5 position-relative d-inline-block">Features That Drive <span
              class="d-inline-block text-dark "
              style="background: url('../public/Assest/images/secbrush.png') no-repeat center center/contain;">
              Productivity
            </span>
            <img src="../public/Assest/images/feature-bubble.png" alt="" class="position-absolute features-bubble">
          </h2>
        </div>

      </div>
    </div>
    <div class="container feature-boxes-section">
      <!-- Features grid -->
      <div class="row feature-boxes-1">

        <div class="random-column mb-4">
          <img src="../public/Assest/images/tick.png" class="mb-2" alt="Task Management">
          <p class="m-0">Task Management</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/zig.png" class="mb-2" alt="Task Management">
          <p class="m-0">Sales Management</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/bar.png" class="mb-2" alt="Task Management">
          <p class="m-0">Project Tracking</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/lead.png" class="mb-2" alt="Task Management">
          <p class="m-0">Lead Generation</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/booking.png" class="mb-2" alt="Task Management">
          <p class="m-0">Booking Management</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/payroll.png" class="mb-2" alt="Task Management">
          <p class="m-0">Payroll Systems</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/leave.png" class="mb-2" alt="Task Management">
          <p class="m-0">Leave</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/fix.png" class="mb-2" alt="Task Management">
          <p class="m-0">Equipment Maintenance</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/vcard.png" class="mb-2" alt="Task Management">
          <p class="m-0">VCard Integration</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/appointment.png" class="mb-2" alt="Task Management">
          <p class="m-0">Appointment Scheduling</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/bus.png" class="mb-2" alt="Task Management">
          <p class="m-0">Consignment Handling</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/booking.png" class="mb-2" alt="Task Management">
          <p class="m-0">Manufacturing Processes</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/customer.png" class="mb-2" alt="Task Management">
          <p class="m-0">Custom Fields</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/ai.png" class="mb-2" alt="Task Management">
          <p class="m-0">AI-Powered Content </p>
        </div>

        <div class="random-column mb-4 tablet-box-1">
          <img src="../public/Assest/images/integration.png" class="mb-2" alt="Task Management">
          <p class="m-0">Webhook</p>
        </div>

        <div class="random-column mb-4 tablet-box-1">
          <img src="../public/Assest/images/woo.png" class="mb-2" alt="Task Management" style="width: 100px !important;">
          <p class="m-0">WordPress
            (Woo Commerce)</p>
        </div>
      </div>

      <div class="row justify-content-between feature-boxes-2">
        <div class="row justify-content-between feature-boxes-section-2" style="width: 29%;">
          <div class="random-column mb-4">
            <img src="../public/Assest/images/attendance.png" class="mb-2" alt="Task Management">
            <p class="m-0">Attendance Tracking</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/invoice.png" class="mb-2" alt="Task Management">
            <p class="m-0">Automated Invoicing</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/supply.png" class="mb-2" alt="Task Management">
            <p class="m-0">Inventory Control</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/supplier.png" class="mb-2" alt="Task Management">
            <p class="m-0">Supplier Management</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/budgeting.png" class="mb-2" alt="Task Management">
            <p class="m-0">Budget Planning</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/asset-allocation.png" class="mb-2" alt="Task Management">
            <p class="m-0">Asset Tracking</p>
          </div>
        </div>
        <div class="row justify-content-between feature-boxes-section-2" style="width: 43%;">
          <div class="random-column-2 mb-4">
            <img src="../public/Assest/images/project-sample.png" class="mb-2" alt="Task Management" width="100%">
            <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
              <img src="../public/Assest/images/bar.png" class="mb-2" alt="Task Management" width="20%">
              <p class="m-0">Project Management</p>
            </div>
          </div>
          <div class="random-column-2 mb-4">
            <img src="../public/Assest/images/crm.png" class="mb-2" alt="Task Management" width="100%">
            <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
              <img src="../public/Assest/images/bar.png" class="mb-2" alt="Task Management" width="39%">
              <p class="m-0">CRM</p>
            </div>
          </div>
          <div class="random-column-2 mb-4">
            <img src="../public/Assest/images/HRM.png" class="mb-2" alt="Task Management" width="100%">
            <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
              <img src="../public/Assest/images/bar.png" class="mb-2" alt="Task Management" width="39%">
              <p class="m-0">HRM</p>
            </div>
          </div>
          <div class="random-column-2 mb-4">
            <img src="../public/Assest/images/sm.png" class="mb-2" alt="Task Management" width="100%">
            <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
              <img src="../public/Assest/images/bar.png" class="mb-2" alt="Task Management" width="20%">
              <p class="m-0">Sales Management</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-between feature-boxes-section-2" style="width: 29%;">
          <div class="random-column mb-4">
            <img src="../public/Assest/images/store-buyer.png" class="mb-2" alt="Task Management">
            <p class="m-0">Purchase Orders</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/exam.png" class="mb-2" alt="Task Management">
            <p class="m-0">Form Builders</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/bug-report.png" class="mb-2" alt="Task Management">
            <p class="m-0">Bug Report</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/accounting1.png" class="mb-2" alt="Task Management">
            <p class="m-0">Accounting</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/point-of-sale-bill.png" class="mb-2" alt="Task Management">
            <p class="m-0">POS</p>
          </div>
          <div class="random-column mb-4">
            <img src="../public/Assest/images/barcode-read.png" class="mb-2" alt="Task Management">
            <p class="m-0">Barcode Printing</p>
          </div>
        </div>
      </div>

      <div class="row justify-content-between">

        <div class="random-column mb-4">
          <img src="../public/Assest/images/helpdesk.png" class="mb-2" alt="Task Management">
          <p class="m-0">Helpdesk</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/message.png" class="mb-2" alt="Task Management">
          <p class="m-0">Messaging</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/receipt.png" class="mb-2" alt="Task Management">
          <p class="m-0">Retainer</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/sourcing.png" class="mb-2" alt="Task Management">
          <p class="m-0">Procurement</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/work-in-progress.png" class="mb-2" alt="Task Management">
          <p class="m-0">Workflow Automation</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/clock.png" class="mb-2" alt="Task Management">
          <p class="m-0">Time Tracking</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/dealing-property-trading.png" class="mb-2" alt="Task Management">
          <p class="m-0">Deal Management</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/adobe-illustrator.png" class="mb-2" alt="Task Management">
          <p class="m-0">AI Document</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/restore.png" class="mb-2" alt="Task Management">
          <p class="m-0">Activity Log</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/scales.png" class="mb-2" alt="Task Management">
          <p class="m-0">Double Entry</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/QuickBooks.png" class="mb-2" alt="Task Management">
          <p class="m-0">QuickBooks</p>
        </div>

        <div class="random-column mb-4">
          <img src="../public/Assest/images/Shopify.png" class="mb-2" alt="Task Management" style="width: 105px !important;">
          <p class="m-0">Shopify Sync</p>
        </div>

        <div class="random-column mb-4 tablet-box-2">
          <img src="../public/Assest/images/integration.png" class="mb-2" alt="Task Management">
          <p class="m-0">Webhook</p>
        </div>

        <div class="random-column mb-4 tablet-box-2">
          <img src="../public/Assest/images/woo.png" class="mb-2" alt="Task Management" style="width: 100px !important;">
          <p class="m-0">WordPress
            (Woo Commerce)</p>
        </div>
      </div>

    </div>

  </section>

  <!-- Nineth-Section-Content-Creation -->

  <section class="whygsaas overflow-hidden ">
    <div class="heading p-3 mt-3  mb-4">
      <div class="text-center position-relative">
        <h2 style="font-weight: 500; font-size: 48px;" class=" p-4 mb-3">Why Choose
          <span class="d-inline-block text-dark px-3"
            style="background: url('../public/Assest/images/brush.png') no-repeat center center/contain;">
            GSaaS
          </span> for <br> Your Business?
        </h2>
        <img src="../public/Assest/images/Vector-small.png" class="position-absolute gsasimg1"
          style="top: -5px; left: 40px; width: 80px; height: 80px;" alt="">
        <img src="../public/Assest/images/Vector-small.png" class="position-absolute gsasimg2"
          style="top: -10px; left: 20px; width: 30px; height: 30px;" alt="">
      </div>
    </div>
    <div class="content-creation-bg">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <span class="content-creation-badge">Project Management</span>
            <div class="content-creation-box mt-3">
              <h2>Transform Your Project Management</h2>
              <p>Leverage AI to enhance workflow efficiency, automate routine updates, and improve team collaboration with precision.</p>
              <ul>
                <li>
                  <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.5001 4.17078L4.67087 11L11.5001 17.8292L18.3293 11L11.5001 4.17078Z" fill="#D4F6FF" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.10679 8.31681L8.81678 1.60683C10.2926 0.131058 12.7074 0.131058 14.1832 1.60683L20.8931 8.31677C22.3689 9.79254 22.3689 12.2075 20.8931 13.6832L14.1832 20.3932C12.7074 21.869 10.2926 21.869 8.81678 20.3932L2.10679 13.6833C0.631028 12.2075 0.631028 9.79258 2.10679 8.31681Z"
                      stroke="#108AEA" stroke-miterlimit="22.9256" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.1822 7.83105L11.5 13.5132L8.9874 11.0006" stroke="#108AEA" stroke-miterlimit="22.9256"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Generate project reports instantly
                </li>
                <li>
                  <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.5001 4.17078L4.67087 11L11.5001 17.8292L18.3293 11L11.5001 4.17078Z" fill="#D4F6FF" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.10679 8.31681L8.81678 1.60683C10.2926 0.131058 12.7074 0.131058 14.1832 1.60683L20.8931 8.31677C22.3689 9.79254 22.3689 12.2075 20.8931 13.6832L14.1832 20.3932C12.7074 21.869 10.2926 21.869 8.81678 20.3932L2.10679 13.6833C0.631028 12.2075 0.631028 9.79258 2.10679 8.31681Z"
                      stroke="#108AEA" stroke-miterlimit="22.9256" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.1822 7.83105L11.5 13.5132L8.9874 11.0006" stroke="#108AEA" stroke-miterlimit="22.9256"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Refine tasks and timelines for clarity
                </li>
                <li>
                  <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.5001 4.17078L4.67087 11L11.5001 17.8292L18.3293 11L11.5001 4.17078Z" fill="#D4F6FF" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.10679 8.31681L8.81678 1.60683C10.2926 0.131058 12.7074 0.131058 14.1832 1.60683L20.8931 8.31677C22.3689 9.79254 22.3689 12.2075 20.8931 13.6832L14.1832 20.3932C12.7074 21.869 10.2926 21.869 8.81678 20.3932L2.10679 13.6833C0.631028 12.2075 0.631028 9.79258 2.10679 8.31681Z"
                      stroke="#108AEA" stroke-miterlimit="22.9256" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.1822 7.83105L11.5 13.5132L8.9874 11.0006" stroke="#108AEA" stroke-miterlimit="22.9256"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Craft stakeholder updates and briefs
                </li>
                <li>
                  <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.5001 4.17078L4.67087 11L11.5001 17.8292L18.3293 11L11.5001 4.17078Z" fill="#D4F6FF" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.10679 8.31681L8.81678 1.60683C10.2926 0.131058 12.7074 0.131058 14.1832 1.60683L20.8931 8.31677C22.3689 9.79254 22.3689 12.2075 20.8931 13.6832L14.1832 20.3932C12.7074 21.869 10.2926 21.869 8.81678 20.3932L2.10679 13.6833C0.631028 12.2075 0.631028 9.79258 2.10679 8.31681Z"
                      stroke="#108AEA" stroke-miterlimit="22.9256" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.1822 7.83105L11.5 13.5132L8.9874 11.0006" stroke="#108AEA" stroke-miterlimit="22.9256"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Create content on workflows and KPIs
                </li>
              </ul>
              <div class="d-flex align-items-center gap-4 mt-3">
                <a style="text-decoration:none; color:white" href="/contact_us" class="contact-us-btn d-flex align-items-center gap-2">
                  Contact Us
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M4.16663 10.8337H14.0541L11.0266 14.467C10.7316 14.8203 10.78 15.3462 11.1333 15.6403C11.4875 15.9353 12.0125 15.887 12.3075 15.5337L16.4741 10.5337C16.5066 10.4945 16.5225 10.4487 16.5466 10.4053C16.5666 10.3703 16.5908 10.3403 16.6058 10.302C16.6433 10.2062 16.6658 10.1053 16.6658 10.0037C16.6658 10.0028 16.6666 10.0012 16.6666 10.0003C16.6666 9.99949 16.6658 9.99783 16.6658 9.99699C16.6658 9.89533 16.6433 9.79449 16.6058 9.69866C16.5908 9.66033 16.5666 9.63033 16.5466 9.59533C16.5225 9.55199 16.5066 9.50616 16.4741 9.46699L12.3075 4.46699C12.1416 4.26949 11.905 4.16699 11.6666 4.16699C11.4783 4.16699 11.2891 4.23033 11.1333 4.36033C10.78 4.65449 10.7316 5.18033 11.0266 5.53366L14.0541 9.16699H4.16663C3.70663 9.16699 3.3333 9.54033 3.3333 10.0003C3.3333 10.4603 3.70663 10.8337 4.16663 10.8337Z"
                      fill="white" />
                    <mask id="mask0_192_30932" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="3" y="4"
                      width="14" height="12">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.16663 10.8337H14.0541L11.0266 14.467C10.7316 14.8203 10.78 15.3462 11.1333 15.6403C11.4875 15.9353 12.0125 15.887 12.3075 15.5337L16.4741 10.5337C16.5066 10.4945 16.5225 10.4487 16.5466 10.4053C16.5666 10.3703 16.5908 10.3403 16.6058 10.302C16.6433 10.2062 16.6658 10.1053 16.6658 10.0037C16.6658 10.0028 16.6666 10.0012 16.6666 10.0003C16.6666 9.99949 16.6658 9.99783 16.6658 9.99699C16.6658 9.89533 16.6433 9.79449 16.6058 9.69866C16.5908 9.66033 16.5666 9.63033 16.5466 9.59533C16.5225 9.55199 16.5066 9.50616 16.4741 9.46699L12.3075 4.46699C12.1416 4.26949 11.905 4.16699 11.6666 4.16699C11.4783 4.16699 11.2891 4.23033 11.1333 4.36033C10.78 4.65449 10.7316 5.18033 11.0266 5.53366L14.0541 9.16699H4.16663C3.70663 9.16699 3.3333 9.54033 3.3333 10.0003C3.3333 10.4603 3.70663 10.8337 4.16663 10.8337Z"
                        fill="white" />
                    </mask>
                    <g mask="url(#mask0_192_30932)">
                      <rect x="-3.05176e-05" width="20" height="20" fill="white" />
                    </g>
                  </svg>
                </a>
                <!--<button class="contact-us-btn-2 d-flex align-items-center gap-2">-->
                <!--  Learn More-->
                <!--  <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                <!--    <path fill-rule="evenodd" clip-rule="evenodd"-->
                <!--      d="M1.16665 6.83366H11.0541L8.02665 10.467C7.73165 10.8203 7.77998 11.3462 8.13331 11.6403C8.48748 11.9353 9.01248 11.887 9.30748 11.5337L13.4741 6.53366C13.5066 6.49449 13.5225 6.44866 13.5466 6.40533C13.5666 6.37033 13.5908 6.34033 13.6058 6.30199C13.6433 6.20616 13.6658 6.10533 13.6658 6.00366C13.6658 6.00283 13.6666 6.00116 13.6666 6.00033C13.6666 5.99949 13.6658 5.99783 13.6658 5.99699C13.6658 5.89533 13.6433 5.79449 13.6058 5.69866C13.5908 5.66033 13.5666 5.63033 13.5466 5.59533C13.5225 5.55199 13.5066 5.50616 13.4741 5.46699L9.30748 0.466992C9.14165 0.269492 8.90498 0.166992 8.66665 0.166992C8.47831 0.166992 8.28915 0.230326 8.13331 0.360326C7.77998 0.654492 7.73165 1.18033 8.02665 1.53366L11.0541 5.16699H1.16665C0.706646 5.16699 0.333313 5.54033 0.333313 6.00033C0.333313 6.46033 0.706646 6.83366 1.16665 6.83366Z"-->
                <!--      fill="black" />-->
                <!--  </svg>-->
                <!--</button>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex flex-column justify-content-center position-relative">
            <div class="newslider-container">
                <div class="newmyslide">
                     <!--<img src="../public/Assest/images/image.jpeg" alt="Beach" class="newslide-image">-->
                   <img src="../public/Assest/images/pm1.png" alt="Beach" class="newslide-image">
                </div>
                <div class="newmyslide">
                     <img src="../public/Assest/images/pm2.png" alt="Beach" class="newslide-image">
                    <!--<img src="../public/Assest/images/vcard-dashboard.png" alt="Mountains" class="newslide-image">-->
                </div>
                <div class="newmyslide active">
                     <img src="../public/Assest/images/pm6.png" alt="Beach" class="newslide-image">
                    <!--<img src="../public/Assest/images/procurement-dashboard.png" alt="Nature" class="newslide-image">-->
                </div>
                <div class="newmyslide">
                     <img src="../public/Assest/images/pm4.png" alt="Beach" class="newslide-image">
                    <!--<img src="../public/Assest/images/equipment-dashboard.png" alt="City" class="newslide-image">-->
                </div>
            </div>
            <div class="newdots-container"></div>
          </div>
        </div>
      </div>
    </div>

  </section>


  <!-- Section tenth FAQ'S -->
  <div class="faq-container container bg-white py-3">
         <h1 style="font-size:40px" class="faq-heading mt-3 mb-5">Frequently Asked Questions</h1>
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


  <!-- Footer-->
  <footer>
    <div class="container position-relative">

      <div class="free-quote-badge" style="position: absolute; top: -51px; right: 7.5%; transform: translateX(-50%);">
        <!--<div class="position-relative">-->
        <!--  <img style="position: relative; top: 1px;" src="../public/Assest/images/Vector1.png" alt="" width="200">-->
        <!--  <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">-->
        <!--    <strong class="text-dark">FREE QUOTE</strong>-->
        <!--  </div>-->
        <!--</div>-->
      </div>

      <div class="row footer-first-section">
        <div class="col-md-12 col-lg-6">
          <p style="font-size: 20px;" class="text-white mb-1">Ready to Streamline Your Business?</p>
          <h4 class="kaushan">Contact us today to unlock efficiency and save time!</h4>
        </div>
        <div class="col-md-12 col-lg-6 d-flex align-items-center gap-4 free ">
          <a style="text-decoration:none; color:black" href="/contact_us" class="footer-btn d-flex justify-content-center align-items-center gap-2">
            Get a Free Quote
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M8.80021 16.6004C13.1081 16.6004 16.6004 13.1081 16.6004 8.80021C16.6004 4.49227 13.1081 1 8.80021 1C4.49227 1 1 4.49227 1 8.80021C1 13.1081 4.49227 16.6004 8.80021 16.6004Z"
                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M8.79999 11.9199L11.9201 8.79977L8.79999 5.67969" stroke="black" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M5.68024 8.7998H11.9204" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </a>
          <!--<button class="footer-btn-2">View Plans</button>-->
        </div>
      </div>

      <div class="row footer-main-section">
        <div class="col-md-12 col-lg-3">
          <div class="mb-4">
             <a class="navbar-brand" href="{{url('/')}}">
            <img src="../public/Assest/images/logo.png" alt="GSAAS" height="50" class="text-white">
          </a>
          </div>
          <p class="text-white-50">
            Unify operations with integrated modules—CRM, HR, finance, and more. Simplify workflows, cut costs, and scale smarter.
          </p>
          <div class="text-right foot-icons">
          <a href="https://www.linkedin.com/company/105405315" class="text-white mx-2" target="_blank"><i class="fab fa-linkedin" ></i></a>
          <a href="https://www.facebook.com/profile.php?id=61567218969136" class="text-white mx-2" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/gsaas5/" class="text-white mx-2" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="https://pin.it/5n4jB1X2b" class="text-white mx-2" target="_blank"><i class="fab fa-pinterest"></i></a>
          <a href="https://github.com/G-TechsolutionsGit" class="text-white mx-2" target="_blank"><i class="fab fa-github"></i></a>
        </div>
        </div>

        <!-- Company Links -->
        <div class="col-6 col-md-4 col-lg-3 company-links">
          <h6 class="text-uppercase mb-4">COMPANY</h6>
          <ul class="list-unstyled">
            <li>
                <a class="text-white-50" href="{{ url('/about_us') }}">About Us</a>
            </li>
            <li>
                <a class="text-white-50" href="{{ url('/referral_programme') }}">Referral Programme</a>
            </li>
            <li>
                <a class="text-white-50" href="{{ url('/become_a_reseller') }}">Become a Reseller</a>
            </li>

                <!--@if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))-->
                <!--    @foreach (json_decode($settings['menubar_page']) as $key => $value)-->
                <!--        @if ($value->header == 'on')-->
                <!--            @if(!in_array($value->page_slug,['contact_us','knowledge_centre']))-->
                <!--                @if($value->template_name == 'page_content')-->
                <!--                    <li>-->
                <!--                        <a class="text-white-50" href="{{ route('custom.page',$value->page_slug) }}">{{ $value->menubar_page_name }}</a>-->
                <!--                    </li>-->
                <!--                @else-->
                <!--                    <li>-->
                <!--                        <a class="text-white-50" target="_blank" href="{{ $value->page_url }}">{{ $value->menubar_page_name }}</a>-->
                <!--                    </li>-->
                <!--                @endif-->
                <!--            @endif-->
                <!--        @endif-->
                <!--    @endforeach-->
                <!--@endif-->
          </ul>
        </div>

        <!-- Products Links -->
        <div class="col-6 col-md-4 col-lg-3 product-links">
          <h6 class="text-uppercase mb-4">Help & Support</h6>
          <ul class="list-unstyled">
            <!--  <li>-->
            <!--    <a class="text-white-50" href="{{ url('/knowledge_centre') }}">Knowledge Centre</a>-->
            <!--</li>-->
            <li>
                <a class="text-white-50" href="{{ url('/contact_us') }}">Contact Us</a>
            </li>
              <!--@if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))-->
              <!--      @foreach (json_decode($settings['menubar_page']) as $key => $value)-->
              <!--          @if ($value->header == 'on')-->
              <!--              @if(in_array($value->page_slug,['contact_us','knowledge_centre']))-->
              <!--                  @if($value->template_name == 'page_content')-->
              <!--                      <li>-->
              <!--                          <a class="text-white-50" href="{{ route('custom.page',$value->page_slug) }}">{{ $value->menubar_page_name }}</a>-->
              <!--                      </li>-->
              <!--                  @else-->
              <!--                      <li>-->
              <!--                          <a class="text-white-50" target="_blank" href="{{ $value->page_url }}">{{ $value->menubar_page_name }}</a>-->
              <!--                      </li>-->
              <!--                  @endif-->
              <!--              @endif-->
              <!--          @endif-->
              <!--      @endforeach-->
              <!--  @endif-->
            
          </ul>
        </div>

        <!-- Newsletter -->
        <div class="col-12 col-md-4 col-lg-3 newsletter">
          <h6 class="text-uppercase mb-4">NEWSLETTER</h6>
          <div class="position-relative foot-email mb-3">
            <i class="far fa-envelope position-absolute text-white"
              style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
            <input type="email" class="form-control bg-transparent text-light"
              placeholder="Enter Your Email Address">
          </div>

          <button style="background-color: white;" class="btn btn-white btn-block foot-sub" >Subscribe Now</button>
           <div id="subscribeMessage" class="mt-3 text-success" style="display: none;">
                  ✅ Thank you for subscribing!
            </div>
        </div>
      </div>

      <!-- Copyright and Social Media -->
      <div class="d-flex justify-content-between align-items-center">
        <p class="mb-0 text-white-50">© <span id="year"></span> GSaaS. All Rights Reserved</p>
      </div>
    </div>
  </footer>
  <script>
  document.getElementById("year").textContent = new Date().getFullYear();
</script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            const sliderTrack = document.querySelector('[data-slider-track-1]');
            const prevButton = document.querySelector('[data-slider-prev-1]');
            const nextButton = document.querySelector('[data-slider-next-1]');
            const sliderContainer = document.querySelector('.slider-container');
            const autoplayIndicator = document.getElementById('autoplay-indicator');
            const sliderItems = document.querySelectorAll('.slider__track > li');
            const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin
            
            let scrollPosition = 0;
            let autoplayInterval;
            let isAutoplayActive = true;
            const autoplayDelay = 3000; // 3 seconds

            // Function to update button states
            function updateButtonStates() {
                prevButton.disabled = scrollPosition <= 0;
                nextButton.disabled = scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth;
            }

            // Function to handle next button click
            function scrollNext() {
                if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
                    scrollPosition += itemWidth;
                } else {
                    // Loop back to beginning
                    scrollPosition = 0;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Function to handle prev button click
            function scrollPrev() {
                if (scrollPosition > 0) {
                    scrollPosition -= itemWidth;
                } else {
                    // Loop to end
                    scrollPosition = sliderTrack.scrollWidth - sliderTrack.offsetWidth;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Autoplay functionality
            function startAutoplay() {
                if (isAutoplayActive) {
                    autoplayInterval = setInterval(() => {
                        scrollNext();
                    }, autoplayDelay);
                }
            }

            function stopAutoplay() {
                clearInterval(autoplayInterval);
            }

            function toggleAutoplay() {
                if (isAutoplayActive) {
                    stopAutoplay();
                    isAutoplayActive = false;
                } else {
                    isAutoplayActive = true;
                    startAutoplay();
                }
            }

            // Event listeners
            nextButton.addEventListener('click', () => {
                scrollNext();
            });

            prevButton.addEventListener('click', () => {
                scrollPrev();
            });

            // Pause autoplay on hover
            sliderContainer.addEventListener('mouseenter', stopAutoplay);
            sliderContainer.addEventListener('mouseleave', () => {
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });

            // Click indicator to toggle autoplay
            autoplayIndicator.addEventListener('click', toggleAutoplay);
            autoplayIndicator.style.cursor = 'pointer';
            autoplayIndicator.style.display = 'none'; // Hide the indicator

            // Handle manual scrolling
            sliderTrack.addEventListener('scroll', () => {
                scrollPosition = sliderTrack.scrollLeft;
                updateButtonStates();
            });

            // Initialize
            updateButtonStates();
            startAutoplay();

            // Handle touch/swipe for mobile
            let startX = 0;
            let isDragging = false;

            sliderTrack.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                stopAutoplay();
            });

            sliderTrack.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            sliderTrack.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;
                
                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;
                
                if (Math.abs(diffX) > 50) { // Minimum swipe distance
                    if (diffX > 0) {
                        scrollNext();
                    } else {
                        scrollPrev();
                    }
                }
                
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sliderTrack = document.querySelector('[data-slider-track-2]');
      const prevButton = document.querySelector('[data-slider-prev-2]');
      const nextButton = document.querySelector('[data-slider-next-2]');
            const sliderContainer = document.querySelector('.slider-container');
            const autoplayIndicator = document.getElementById('autoplay-indicator');
            const sliderItems = document.querySelectorAll('.slider__track > li');
            const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin
            
            let scrollPosition = 0;
            let autoplayInterval;
            let isAutoplayActive = true;
            const autoplayDelay = 3000; // 3 seconds

            // Function to update button states
            function updateButtonStates() {
                prevButton.disabled = scrollPosition <= 0;
                nextButton.disabled = scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth;
            }

            // Function to handle next button click
            function scrollNext() {
                if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
                    scrollPosition += itemWidth;
                } else {
                    // Loop back to beginning
                    scrollPosition = 0;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Function to handle prev button click
            function scrollPrev() {
                if (scrollPosition > 0) {
                    scrollPosition -= itemWidth;
                } else {
                    // Loop to end
                    scrollPosition = sliderTrack.scrollWidth - sliderTrack.offsetWidth;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Autoplay functionality
            function startAutoplay() {
                if (isAutoplayActive) {
                    autoplayInterval = setInterval(() => {
                        scrollNext();
                    }, autoplayDelay);
                }
            }

            function stopAutoplay() {
                clearInterval(autoplayInterval);
            }

            function toggleAutoplay() {
                if (isAutoplayActive) {
                    stopAutoplay();
                    isAutoplayActive = false;
                } else {
                    isAutoplayActive = true;
                    startAutoplay();
                }
            }

            // Event listeners
            nextButton.addEventListener('click', () => {
                scrollNext();
            });

            prevButton.addEventListener('click', () => {
                scrollPrev();
            });

            // Pause autoplay on hover
            sliderContainer.addEventListener('mouseenter', stopAutoplay);
            sliderContainer.addEventListener('mouseleave', () => {
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });

            // Click indicator to toggle autoplay
            autoplayIndicator.addEventListener('click', toggleAutoplay);
            autoplayIndicator.style.cursor = 'pointer';
            autoplayIndicator.style.display = 'none'; // Hide the indicator

            // Handle manual scrolling
            sliderTrack.addEventListener('scroll', () => {
                scrollPosition = sliderTrack.scrollLeft;
                updateButtonStates();
            });

            // Initialize
            updateButtonStates();
            startAutoplay();

            // Handle touch/swipe for mobile
            let startX = 0;
            let isDragging = false;

            sliderTrack.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                stopAutoplay();
            });

            sliderTrack.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            sliderTrack.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;
                
                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;
                
                if (Math.abs(diffX) > 50) { // Minimum swipe distance
                    if (diffX > 0) {
                        scrollNext();
                    } else {
                        scrollPrev();
                    }
                }
                
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sliderTrack = document.querySelector('[data-slider-track]');
      const prevButton = document.querySelector('[data-slider-prev]');
      const nextButton = document.querySelector('[data-slider-next]');
            const sliderContainer = document.querySelector('.slider-container');
            const autoplayIndicator = document.getElementById('autoplay-indicator');
            const sliderItems = document.querySelectorAll('.slider__track > li');
            const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin
            
            let scrollPosition = 0;
            let autoplayInterval;
            let isAutoplayActive = true;
            const autoplayDelay = 3000; // 3 seconds

            // Function to update button states
            function updateButtonStates() {
                prevButton.disabled = scrollPosition <= 0;
                nextButton.disabled = scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth;
            }

            // Function to handle next button click
            function scrollNext() {
                if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
                    scrollPosition += itemWidth;
                } else {
                    // Loop back to beginning
                    scrollPosition = 0;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Function to handle prev button click
            function scrollPrev() {
                if (scrollPosition > 0) {
                    scrollPosition -= itemWidth;
                } else {
                    // Loop to end
                    scrollPosition = sliderTrack.scrollWidth - sliderTrack.offsetWidth;
                }
                
                sliderTrack.scrollTo({
                    left: scrollPosition,
                    behavior: 'smooth'
                });
                updateButtonStates();
            }

            // Autoplay functionality
            function startAutoplay() {
                if (isAutoplayActive) {
                    autoplayInterval = setInterval(() => {
                        scrollNext();
                    }, autoplayDelay);
                }
            }

            function stopAutoplay() {
                clearInterval(autoplayInterval);
            }

            function toggleAutoplay() {
                if (isAutoplayActive) {
                    stopAutoplay();
                    isAutoplayActive = false;
                } else {
                    isAutoplayActive = true;
                    startAutoplay();
                }
            }

            // Event listeners
            nextButton.addEventListener('click', () => {
                scrollNext();
            });

            prevButton.addEventListener('click', () => {
                scrollPrev();
            });

            // Pause autoplay on hover
            sliderContainer.addEventListener('mouseenter', stopAutoplay);
            sliderContainer.addEventListener('mouseleave', () => {
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });

            // Click indicator to toggle autoplay
            autoplayIndicator.addEventListener('click', toggleAutoplay);
            autoplayIndicator.style.cursor = 'pointer';
            autoplayIndicator.style.display = 'none'; // Hide the indicator

            // Handle manual scrolling
            sliderTrack.addEventListener('scroll', () => {
                scrollPosition = sliderTrack.scrollLeft;
                updateButtonStates();
            });

            // Initialize
            updateButtonStates();
            startAutoplay();

            // Handle touch/swipe for mobile
            let startX = 0;
            let isDragging = false;

            sliderTrack.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                stopAutoplay();
            });

            sliderTrack.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
            });

            sliderTrack.addEventListener('touchend', (e) => {
                if (!isDragging) return;
                isDragging = false;
                
                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;
                
                if (Math.abs(diffX) > 50) { // Minimum swipe distance
                    if (diffX > 0) {
                        scrollNext();
                    } else {
                        scrollPrev();
                    }
                }
                
                if (isAutoplayActive) {
                    startAutoplay();
                }
            });
        });
    </script>
    
    <!--FAQS-->
   <script>
    const faqButtons = document.querySelectorAll('.faq-button');
    faqButtons.forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('.faq-icon i');
            const allIcons = document.querySelectorAll('.faq-icon i');
            allIcons.forEach(i => {
                if (i !== icon) {
                    i.classList.remove('fa-minus');
                    i.classList.add('fa-plus');
                }
            });
            icon.classList.toggle('fa-plus');
            icon.classList.toggle('fa-minus');
        });
    });
</script>
    



  <script>
//         document.addEventListener('DOMContentLoaded', function() {
//   // Get the necessary elements
//   const emailInput = document.querySelector('.foot-email input[type="email"]');
//   const subscribeButton = document.querySelector('.foot-sub');
//   const subscribeMessage = document.getElementById('subscribeMessage');

//   // Add click event listener to the subscribe button
//   subscribeButton.addEventListener('click', function() {
//     // Get the email value and trim whitespace
//     const email = emailInput.value.trim();
    
//     // Validate email format
//     if (!isValidEmail(email)) {
//       // Show error styling
//       emailInput.classList.add('is-invalid');
      
//       // Create error message if it doesn't exist yet
//       if (!document.getElementById('emailError')) {
//         const errorMessage = document.createElement('div');
//         errorMessage.id = 'emailError';
//         errorMessage.className = 'text-danger mt-2';
//         errorMessage.textContent = 'Please enter a valid email address';
//         emailInput.parentNode.after(errorMessage);
//       }
//       return;
//     }
    
//     // Clear any error styling and messages
//     emailInput.classList.remove('is-invalid');
//     const errorElement = document.getElementById('emailError');
//     if (errorElement) {
//       errorElement.remove();
//     }
    
//     // Simulate sending data to a server
//     submitEmailToServer(email)
//       .then(() => {
//         // Clear the input field
//         emailInput.value = '';
        
//         // Show success message
//         subscribeMessage.style.display = 'block';
        
//         // Hide the success message after 3 seconds
//         setTimeout(function() {
//           subscribeMessage.style.display = 'none';
//         }, 3000);
//       })
//       .catch(error => {
//         console.error('Subscription error:', error);
        
//         // Create server error message
//         const serverErrorMessage = document.createElement('div');
//         serverErrorMessage.className = 'text-danger mt-2';
//         serverErrorMessage.textContent = 'Could not subscribe. Please try again later.';
        
//         subscribeButton.after(serverErrorMessage);
        
//         // Remove error message after 3 seconds
//         setTimeout(function() {
//           serverErrorMessage.remove();
//         }, 3000);
//       });
//   });
  
//   // Add input event listener to remove error styling when typing
//   emailInput.addEventListener('input', function() {
//     this.classList.remove('is-invalid');
//     const errorElement = document.getElementById('emailError');
//     if (errorElement) {
//       errorElement.remove();
//     }
//   });
  
//   // Function to validate email format
//   function isValidEmail(email) {
//     const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     return emailRegex.test(email);
//   }
  
//   // Function to simulate server submission
//   function submitEmailToServer(email) {
//     return new Promise((resolve, reject) => {
//       // This is where you would normally make an API call to your server
//       // For demonstration, we'll use a timeout to simulate a network request
//       setTimeout(() => {
//         // Simulate 90% success rate
//         if (Math.random() < 0.9) {
//           resolve();
//         } else {
//           reject(new Error('Server error'));
//         }
//       }, 1000);
//     });
//   }
// });



document.addEventListener('DOMContentLoaded', function() {
  // Get the necessary elements
  const emailInput = document.querySelector('.foot-email input[type="email"]');
  const subscribeButton = document.querySelector('.foot-sub');
  const subscribeMessage = document.getElementById('subscribeMessage');
  
  // Add click event listener to the subscribe button
  subscribeButton.addEventListener('click', function() {
    // Get the email value and trim whitespace
    const email = emailInput.value.trim();
    
    // Validate email format
    if (!isValidEmail(email)) {
      // Show error styling
      emailInput.classList.add('is-invalid');
      
      // Create error message if it doesn't exist yet
      if (!document.getElementById('emailError')) {
        const errorMessage = document.createElement('div');
        errorMessage.id = 'emailError';
        errorMessage.className = 'text-danger mt-2';
        errorMessage.textContent = 'Please enter a valid email address';
        emailInput.parentNode.after(errorMessage);
      }
      return;
    }
    
    // Clear any error styling and messages
    emailInput.classList.remove('is-invalid');
    const errorElement = document.getElementById('emailError');
    if (errorElement) {
      errorElement.remove();
    }
    
    // Disable the subscribe button to prevent double submission
    subscribeButton.disabled = true;
    const originalButtonText = subscribeButton.textContent;
    subscribeButton.textContent = 'Subscribing...';
    
    // Send data to the server
    submitEmailToServer(email)
      .then(response => {
        // Clear the input field
        emailInput.value = '';
        
        // Show success message
        subscribeMessage.style.display = 'block';
        
        // Hide the success message after 3 seconds
        setTimeout(function() {
          subscribeMessage.style.display = 'none';
        }, 3000);
      })
      .catch(error => {
        console.error('Subscription error:', error);
        
        // Remove any existing server error messages
        const existingError = document.querySelector('.server-error-message');
        if (existingError) {
          existingError.remove();
        }
        
        // Create server error message
        const serverErrorMessage = document.createElement('div');
        serverErrorMessage.className = 'text-danger mt-2 server-error-message';
        
        // Handle different error types
        if (error.message === 'Email already exists') {
          serverErrorMessage.textContent = 'This email is already subscribed to our newsletter.';
        } else if (error.message === 'Validation failed') {
          serverErrorMessage.textContent = 'Please enter a valid email address.';
        } else {
          serverErrorMessage.textContent = 'Could not subscribe. Please try again later.';
        }
        
        subscribeButton.after(serverErrorMessage);
        
        // Remove error message after 5 seconds
        setTimeout(function() {
          serverErrorMessage.remove();
        }, 5000);
      })
      .finally(() => {
        // Re-enable the subscribe button
        subscribeButton.disabled = false;
        subscribeButton.textContent = originalButtonText;
      });
  });
  
  // Add input event listener to remove error styling when typing
  emailInput.addEventListener('input', function() {
    this.classList.remove('is-invalid');
    const errorElement = document.getElementById('emailError');
    if (errorElement) {
      errorElement.remove();
    }
  });
  
  // Function to validate email format
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  // Function to get CSRF token
  function getCSRFToken() {
    // Try to get CSRF token from meta tag
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
      return metaTag.getAttribute('content');
    }
    
    // Try to get CSRF token from hidden input (Laravel forms)
    const hiddenInput = document.querySelector('input[name="_token"]');
    if (hiddenInput) {
      return hiddenInput.value;
    }
    
    // If no CSRF token found, return null
    return null;
  }

  // Function to submit email to Laravel backend
  function submitEmailToServer(email) {
    const csrfToken = getCSRFToken();
    
    // Prepare headers
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    };
    
    // Add CSRF token if available
    if (csrfToken) {
      headers['X-CSRF-TOKEN'] = csrfToken;
    }
    
    return fetch('/subscribe', {
      method: 'POST',
      headers: headers,
      body: JSON.stringify({
        email: email
      })
    })
    .then(response => {
      // Check if the response is ok
      if (!response.ok) {
        return response.json().then(errorData => {
          // Handle different HTTP status codes
          if (response.status === 422) {
            throw new Error('Validation failed');
          } else if (response.status === 409) {
            throw new Error('Email already exists');
          } else {
            throw new Error('Server error');
          }
        });
      }
      return response.json();
    })
    .then(data => {
      // Return the response data for successful requests
      return data;
    })
    .catch(error => {
      // Re-throw the error to be handled by the calling function
      throw error;
    });
  }
});
  </script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const navbarToggler = document.querySelector('.navbar-toggler');
      const navbarNav = document.getElementById('navbarNav');

      navbarToggler.addEventListener('click', function () {
        // Toggle the "collapse" class to show or hide the navbar
        navbarNav.classList.toggle('collapse');
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
  // Clear any existing dots first
  const dotsContainer = document.querySelector('.dots-container');
  dotsContainer.innerHTML = '';

  // Get all slides
  const slides = document.querySelectorAll('.myslide');

  let currentSlide = 0;
  let autoplayInterval = 3000; // Time in milliseconds (3 seconds)

  // Create dot indicators for each slide
  for (let i = 0; i < slides.length; i++) {
    const dot = document.createElement('div');
    dot.classList.add('dot');

    // Set first dot as active
    if (i === 0) {
      dot.classList.add('active');
    }

    // Add click event to each dot
    dot.addEventListener('click', function () {
      goToSlide(i);
    });

    dotsContainer.appendChild(dot);
  }

  // Select all dots after they've been created
  const dots = document.querySelectorAll('.dot');

  // Function to show a specific slide
  function goToSlide(slideIndex) {
    // Hide all slides and deactivate all dots
    slides.forEach(slide => {
      slide.classList.remove('active');
    });

    dots.forEach(dot => {
      dot.classList.remove('active');
    });

    // Show current slide and activate current dot
    slides[slideIndex].classList.add('active');
    dots[slideIndex].classList.add('active');

    // Update current slide index
    currentSlide = slideIndex;
  }

  // Function for next slide
  function nextSlide() {
    // Calculate next slide index with wraparound
    let nextIndex = (currentSlide + 1) % slides.length;
    goToSlide(nextIndex);
  }

  // Add keyboard navigation
  document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowRight') {
      nextSlide();
    }
  });

  // Start autoplay
  setInterval(nextSlide, autoplayInterval);
});

  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
  // Clear any existing dots first
  const dotsContainer = document.querySelector('.newdots-container');
  dotsContainer.innerHTML = '';

  // Get all slides
  const slides = document.querySelectorAll('.newmyslide');

  let currentSlide = 0;
  let autoplayInterval = 3000; // Autoplay every 3 seconds

  // Create dot indicators for each slide
  for (let i = 0; i < slides.length; i++) {
    const dot = document.createElement('div');
    dot.classList.add('newdot');

    // Set first dot as active
    if (i === 0) {
      dot.classList.add('active');
    }

    // Add click event to each dot
    dot.addEventListener('click', function () {
      goToSlide(i);
    });

    dotsContainer.appendChild(dot);
  }

  // Select all dots after they've been created
  const dots = document.querySelectorAll('.newdot');

  // Function to show a specific slide
  function goToSlide(slideIndex) {
    // Hide all slides and deactivate all dots
    slides.forEach(slide => {
      slide.classList.remove('active');
    });

    dots.forEach(dot => {
      dot.classList.remove('active');
    });

    // Show current slide and activate current dot
    slides[slideIndex].classList.add('active');
    dots[slideIndex].classList.add('active');

    // Update current slide index
    currentSlide = slideIndex;
  }

  // Function for next slide
  function nextSlide() {
    // Calculate next slide index with wraparound
    let nextIndex = (currentSlide + 1) % slides.length;
    goToSlide(nextIndex);
  }

  // Add keyboard navigation
  document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowRight') {
      nextSlide();
    }
  });

  // Start autoplay
  setInterval(nextSlide, autoplayInterval);
});

  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize the carousel
      $('#retailCarousel').carousel({
        interval: false // Don't auto-slide
      });

      // Add click event listeners to the previous and next buttons
      $('#prevBtn').click(function () {
        $('#retailCarousel').carousel('prev');
      });

      $('#nextBtn').click(function () {
        $('#retailCarousel').carousel('next');
      });
    });
  </script>

  <script>
    document.getElementById('prevHealth').addEventListener('click', function () {
      $('#healthCarousel').carousel('prev');
    });
    document.getElementById('nextHealth').addEventListener('click', function () {
      $('#healthCarousel').carousel('next');
    });

    document.getElementById('prevSupply').addEventListener('click', function () {
      $('#supplyCarousel').carousel('prev');
    });
    document.getElementById('nextSupply').addEventListener('click', function () {
      $('#supplyCarousel').carousel('next');
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const accordionHeaders = document.querySelectorAll('.accordion-header');

      accordionHeaders.forEach(header => {
        header.addEventListener('click', function () {
          const content = this.nextElementSibling;
          const icon = this.querySelector('.accordion-icon');

          // Close all other accordion items
          document.querySelectorAll('.accordion-content').forEach(item => {
            if (item !== content) {
              item.classList.remove('active');
            }
          });

          document.querySelectorAll('.accordion-icon').forEach(i => {
            if (i !== icon) {
              i.classList.remove('active');
            }
          });

          // Toggle current accordion item
          content.classList.toggle('active');
          icon.classList.toggle('active');
        });
      });
    });
  </script>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>

</body>

</html>