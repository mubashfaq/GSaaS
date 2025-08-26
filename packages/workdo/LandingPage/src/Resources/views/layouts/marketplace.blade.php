
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
  
  .company-links ul li a:hover, .product-links ul li a:hover{
      color:#fff !important;
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





@keyframes underlineAnim {
  from { width: 0; }
  to { width: 100%; }
}


    /*.faq-item:last-child .faq-button {*/
    /*  border-bottom: none !important;*/
    /*}*/
    /*.faq-button::after {*/
    /*  display: none !important;*/
    /*}*/
    /*.faq-item,*/
    /*.faq-button,*/
    /*.faq-collapse {*/
    /*  border: none !important;*/
    /*  box-shadow: none !important;*/
    /*}*/
    /*.faq-button {*/
    /*  border-bottom: 1px solid black !important;*/
    /*  display: flex;*/
    /*  justify-content: space-between;*/
    /*  align-items: center;*/
    /*  padding: 0.4rem 1rem;*/
    /*  background: none;*/
    /*  font-size: 1rem;*/
    /*  width: 100%;*/
    /*  text-align: left;*/
    /*}*/
    /*.faq-icon {*/
    /*  background-color: black;*/
    /*  color: white;*/
    /*  padding: 5px;*/
    /*  border-radius: 2px;*/
    /*  margin-left: auto;*/
    /*  transition: transform 0.3s;*/
    /*  font-size: 1rem;*/
    /*}*/
    /*.faq-body {*/
    /*  padding: 0.4rem 1rem;*/
    /*  font-size: 0.95rem;*/
    /*}*/
    /*.faq-heading {*/
    /*  margin-bottom: 0.8rem !important;*/
    /*  font-size: 1.5rem;*/
    /*  font-weight: 700;*/
    /*}*/
    /*.faq-button:focus {*/
    /*  box-shadow: none;*/
    /*}   */
    @media (min-width:320px) and (max-width:576px){
        .get-a{
            position:relative !important;
            top:-10px !important;
            width:100% !important;
            left:-60px !important;
          
        }
        .logo-foot{
            margin-top:15px;
        }
        .faq-heading{
            font-size:24px !important;
            margin-top:18px;
            margin-left:36px;
            margin-bottom:1.8rem !important;
        }
        .footer-btn{
            position:relative !important;
            left:0px !important;
        }
     
       
       
    }
    @media (min-width:766px) and (max-width:1023px){
        .get-a{
            position:relative !important;
            top:-25px !important;
            width:100% !important;
            left:-280px !important;
        }
      
       
       
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
  margin-top: -430px;
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

/*Footer*/
 .footer-first-section p{
    font-size: 18px !important;
  }

  .footer-first-section .kaushan{
    font-size: 32px !important;
  }
  
  .footer-first-section .d-flex{
    flex-wrap: wrap !important;
    justify-content: flex-start !important;
    margin-top: 10px;
  }

  .footer-main-section{
    padding: 0px 0px 50px !important;
  }
   .company-links, .product-links, .newsletter{
    padding: 10px !important;
  }
  .footer-main-section{
    padding: 10px 0px 35px;
  }
  .footer-first-section {
  margin-bottom: 50px;
  padding-bottom: 30px;
  border-bottom: 1px solid #FFFFFF;
}
.footer-main-section {
  border-bottom: 1px solid #EAEAEA;
  padding: 30px 0px 50px;
  margin-bottom: 20px;
}
.footer-btn {
  background-color: white;
  padding: 11px 30px;
  border: none;
  border-radius: 10px;
  font-family: "Inter", sans-serif;
  font-weight: 16px;
  font-weight: 500;
  position: relative;
  left: 33%;
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
footer {
  padding: 50px 0px 30px !important;
  background-image: url('../public/Assest/images/footer-bg.png');
  background-size: cover;
  background-position: center;
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
  color: rgba(185, 194, 203, 0.8) !important;
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
  padding: 12px 10px !important;
  border-radius: 10px !important;
 }

 .foot-sub{
  border-radius: 12px !important;
  border-radius: 10px !important;
  font-weight: 500;
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

@media only screen and (max-width: 1300px) {
    .navbar-nav {
        gap:0px !important;
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
}



@media only screen and (max-width: 600px) {
  .tablet-box-1{
    display: none;
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

  .slider-container {
    height: 190px;
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
    margin-top: 40px;
    background:black;
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
    width: 93% !important;
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

  

  .free-quote-badge{
    display: none;
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
    padding-top: 0px !important;
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
   

  <!-- wrapper start -->
  
         @yield('content')
         
    <!-- wrapper end -->
    
    
    <!--FAQS-->
    
<!--    <div class="faq-container container bg-white py-3">-->
<!--         <h1 style="font-size:40px" class="faq-heading">Frequently Asked Questions</h1>-->
<!--    <div style="background-color:white;padding:10px;" class="faq-card shadow-lg rounded" >-->
 
<!--  <div class="faq-accordion p-4" id="faqAccordion">-->

    <!-- FAQ Item Template -->
<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingOne">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false">-->
<!--          What Is The GSAAS Reseller Program?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseOne" class="faq-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          It is a program that allows you to earn commissions by referring customers to GSaaS.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingTwo">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false">-->
<!--          Who Can Become A Reseller?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseTwo" class="faq-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          Any business or individual with a network interested in promoting GSaaS can join.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingThree">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false">-->
<!--          How Do I Apply To Become A Reseller?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseThree" class="faq-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          Complete our online application form or contact our sales team for assistance.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingFour">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false">-->
<!--          Are There Any Fees To Join?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseFour" class="faq-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          No, joining the program is free. You earn commissions only on sales generated.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingFive">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false">-->
<!--          What Kind Of Commission Can I Earn?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseFive" class="faq-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          You will receive competitive recurring commissions on all subscription sales from your referrals.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item mb-3">-->
<!--      <h2 class="faq-header" id="headingSix">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false">-->
<!--          Do I Need Technical Expertise To Become A Reseller?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseSix" class="faq-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          No technical knowledge is required; we provide comprehensive training and support.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--    <div class="faq-item">-->
<!--      <h2 class="faq-header" id="headingSeven">-->
<!--        <button class="faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false">-->
<!--          Can I White-Label The GSaaS Product?-->
<!--          <span class="faq-icon">-->
<!--            <i class="fas fa-plus"></i>-->
<!--          </span>-->
<!--        </button>-->
<!--      </h2>-->
<!--      <div id="collapseSeven" class="faq-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">-->
<!--        <div class="faq-body">-->
<!--          Yes, our program supports white-labeling so you can brand the product for your clients.-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

<!--  </div>-->
<!--  </div>-->
<!--</div>-->
    
 
    <!--CTA-->
    <!--<section class="cta-section py-5">-->
    <!--    <div class="container">-->
    <!--        <div class="row justify-content-center">-->
    <!--            <div class="col-lg-8 text-center">-->
    <!--                <h2 class="mb-3">Ready to Advance Your Business?</h2>-->
    <!--                <p class="mb-4">GSaaS offers expert guidance and strategies focused on simplifying operations, reducing costs, and accelerating  -->
    <!--                growth — wherever your business is located in Australia.-->
    <!--                </p>-->
    <!--                <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">-->
    <!--                    <a href="#" class="btn btn-outline-light rounded">-->
    <!--                        Contact Us Today-->
    <!--                    </a>-->
    <!--                    <a href="#" class="btn btn-light gradient-text px-3 py-2" style="color: #00a7e9; font-weight: 700;">-->
    <!--                        Request Your Free Consultation-->
    <!--                    </a>-->
    <!--                </div>-->

    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    
  

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
                 style="top: 50%; left: 15px; transform: translateY(-50%); pointer-events: none;"></i>
              <input type="email" class="form-control bg-transparent text-light ps-5" 
                     placeholder="Your Email Address" 
                     style="padding-left: 2.5rem !important;">
            </div>
          <button style="background-color: white;" class="btn btn-white btn-block foot-sub" >Subscribe Now</button>
           <div id="subscribeMessage" class="mt-3 text-success" style="display: none;">
                  ✅ Thank you for subscribing!
            </div>
        </div>
      </div>

      <!-- Copyright and Social Media -->
      <div class="d-flex justify-content-between align-items-center">
        <p class="mb-0 text-white-50">© <span id="year"></span> 2025 GSaaS. All Rights Reserved</p>
      </div>
    </div>
  </footer>
  <script>
document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll(".footer-link");

  links.forEach(link => {
    link.addEventListener("click", function () {
      links.forEach(l => l.classList.remove("clicked")); // remove from all
      this.classList.add("clicked"); // add to clicked link
    });
  });
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
    navbarNav.classList.toggle('show'); // Show/hide navbar
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
      // Clear any existing dots first
      const dotsContainer = document.querySelector('.dots-container');
      dotsContainer.innerHTML = '';

      // Get all slides
      const slides = document.querySelectorAll('.myslide');

      let currentSlide = 0;

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
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const sliderTrack = document.querySelector('[data-slider-track-1]');
      const prevButton = document.querySelector('[data-slider-prev-1]');
      const nextButton = document.querySelector('[data-slider-next-1]');
      const sliderItems = document.querySelectorAll('.slider__track > li');
      const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin

      let scrollPosition = 0;

      // Function to handle next button click
      function scrollNext() {
        if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          scrollPosition += itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          prevButton.disabled = false;
        }

        if (scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          nextButton.disabled = true;
        }
      }

      // Function to handle prev button click
      function scrollPrev() {
        if (scrollPosition > 0) {
          scrollPosition -= itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          nextButton.disabled = false;
        }

        if (scrollPosition <= 0) {
          prevButton.disabled = true;
        }
      }

      // Attach event listeners to buttons
      nextButton.addEventListener('click', scrollNext);
      prevButton.addEventListener('click', scrollPrev);

      // Initial state: Disable prev button when at the beginning
      prevButton.disabled = true;
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const sliderTrack = document.querySelector('[data-slider-track-2]');
      const prevButton = document.querySelector('[data-slider-prev-2]');
      const nextButton = document.querySelector('[data-slider-next-2]');
      const sliderItems = document.querySelectorAll('.slider__track > li');
      const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin

      let scrollPosition = 0;

      // Function to handle next button click
      function scrollNext() {
        if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          scrollPosition += itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          prevButton.disabled = false;
        }

        if (scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          nextButton.disabled = true;
        }
      }

      // Function to handle prev button click
      function scrollPrev() {
        if (scrollPosition > 0) {
          scrollPosition -= itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          nextButton.disabled = false;
        }

        if (scrollPosition <= 0) {
          prevButton.disabled = true;
        }
      }

      // Attach event listeners to buttons
      nextButton.addEventListener('click', scrollNext);
      prevButton.addEventListener('click', scrollPrev);

      // Initial state: Disable prev button when at the beginning
      prevButton.disabled = true;
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const sliderTrack = document.querySelector('[data-slider-track]');
      const prevButton = document.querySelector('[data-slider-prev]');
      const nextButton = document.querySelector('[data-slider-next]');
      const sliderItems = document.querySelectorAll('.slider__track > li');
      const itemWidth = sliderItems[0].offsetWidth + 15; // Width of the item including margin

      let scrollPosition = 0;

      // Function to handle next button click
      function scrollNext() {
        if (scrollPosition < sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          scrollPosition += itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          prevButton.disabled = false;
        }

        if (scrollPosition >= sliderTrack.scrollWidth - sliderTrack.offsetWidth) {
          nextButton.disabled = true;
        }
      }

      // Function to handle prev button click
      function scrollPrev() {
        if (scrollPosition > 0) {
          scrollPosition -= itemWidth;
          sliderTrack.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
          });
          nextButton.disabled = false;
        }

        if (scrollPosition <= 0) {
          prevButton.disabled = true;
        }
      }

      // Attach event listeners to buttons
      nextButton.addEventListener('click', scrollNext);
      prevButton.addEventListener('click', scrollPrev);

      // Initial state: Disable prev button when at the beginning
      prevButton.disabled = true;
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
  
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const faqAccordion = document.getElementById('faqAccordion');

    faqAccordion.addEventListener('show.bs.collapse', function (event) {
        const icon = event.target.previousElementSibling.querySelector('.faq-icon i');
        icon.classList.remove('fa-plus');
        icon.classList.add('fa-minus');
    });

    faqAccordion.addEventListener('hide.bs.collapse', function (event) {
        const icon = event.target.previousElementSibling.querySelector('.faq-icon i');
        icon.classList.remove('fa-minus');
        icon.classList.add('fa-plus');
    });
});
</script>



  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>

</body>

</html>