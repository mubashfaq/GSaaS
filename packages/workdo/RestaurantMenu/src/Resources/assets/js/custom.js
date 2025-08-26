$(document).ready(function () {

    $('.category-card').first().addClass('active')
    $('.tab-content').first().addClass('active')
    $('.title .category_name').html('All Item')
    // /********* On scroll heder Sticky *********/
    function initHeaderSticky() {
        if (jQuery(document).height() > jQuery(window).height()) {
            if (jQuery(this).scrollTop() > 200) {
                jQuery('.site-header').addClass("fixed");
            } else {
                jQuery('.site-header').removeClass("fixed");
            }
        }
    }

    $(document).ready(function () {
        initHeaderSticky()
    });
    $(window).on('resize scroll', function () {
        initHeaderSticky()
    });

    // /********* On scroll heder back *********/
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
            document.getElementById("header-sticky").style.top = "0";
        } else {
            document.getElementById("header-sticky").style.top = "-200px";
        }
        prevScrollpos = currentScrollPos;
    }

    /****  TAB Js ****/
    $(".category-card").click(function () {
        var $this = $(this);
        var $theTab = $(this).attr("data-tab");
        if ($this.hasClass("active")) {
        } else {
            $this
                .closest(".tabs-wrapper")
                .find(".category-card, .tabs-container .tab-content")
                .removeClass("active");
                console.log($theTab);
            $('.tabs-container .tab-content[id="' + $theTab + '"], .category-card[data-tab="' + $theTab + "]" ).addClass("active");
            if($theTab == 0){
                $('.title .category_name').html('All Item')
            }else{
                $('.title .category_name').html($('.tabs-container .tab-content[id="' + $theTab + '"]' ).attr('data-name'))
            }
            
        }
        $(this).addClass("active");
    });

    /********* qty spinner ********/
    var quantity = 0;
    $('.quantity-increment').click(function () {
        ;
        
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        $(t).val(quantity + 1);
    });
    $('.quantity-decrement').click(function () {
        var t = $(this).siblings('.quantity');
        var quantity = parseInt($(t).val());
        if (quantity > 1) {
            $(t).val(quantity - 1);
        }
    });

    /******* order-popup Js *******/
    // $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {

    //     var title = $(this).data('title');
    //     var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    //     var url = $(this).data('url');
    //     var clickedElement = $(this); 

    //     $("#commonModal .modal-title").html(title);
    //     $("#commonModal .modal-dialog").addClass('modal-' + size);
    //     $.ajax({
    //         url: url,
    //         beforeSend: function () {
    //             $(".loader-wrapper").removeClass('d-none');
    //         },
    //         success: function (data) {
    //             $(".loader-wrapper").addClass('d-none');
    //             $('#commonModal .modal-body').html(data); 
    //             $("#commonModal").modal('show');
                
    //             if (clickedElement.hasClass('order')) { 
    //                 $(".order-popup").addClass("active");
    //                 $("body").addClass("no_scroll");
    //             }
    //         }
    //     });
    // });
    
    // $(".order-close-btn").click(function () {
    //     $(".order-popup").removeClass("active");
    //     $("body").removeClass("no_scroll");
    // });
     /******* order-popup Js *******/
    $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
        var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
        var url = $(this).data('url');
        
        $.ajax({
            url: url,
            beforeSend: function () {
                $(".loader-wrapper").removeClass('d-none');
            },
            success: function (data) {
                $('#commonModal .body').html(data);
                $(".order-popup").toggleClass("active");
                $("body").toggleClass("no_scroll");
            },
            error: function (xhr) {
                $(".loader-wrapper").addClass('d-none');
                toastrs('Error', xhr.responseJSON.error, 'error')
            }
        });


       
       
    });

    $(".order-close-btn").click(function () {
        $(".order-popup").removeClass("active");
        $("body").removeClass("no_scroll");
    });
    
    /** category-slider **/
    var swiper = new Swiper(".category-slider", {
        loop: false,
        slidesPerView: 4,
        speed: 800,
        spaceBetween: 10,
        navigation: {
            nextEl: '.category-arrow.swiper-button-next',
            prevEl: '.category-arrow.swiper-button-prev',
        },
        breakpoints: {
            1200: {
                slidesPerView: 9,
            },
            992: {
                slidesPerView: 7,
            },
            768: {
                slidesPerView: 6,
            },
            641: {
                slidesPerView: 5,
            },
            576: {
                slidesPerView: 4,
            },
            481: {
                slidesPerView: 4,
            },
            380: {
                slidesPerView: 3,
            },
            0: {
                slidesPerView: 2,
            },
        },
    });


});
function show_toastr(title, message, type) {
    var o, i;
    var icon = '';
    var cls = '';
    if (type == 'success') {
        icon = 'fas fa-check-circle';
        cls = 'success';
    } else {
        icon = 'fas fa-times-circle';
        cls = 'danger';
    }
    $.notify({icon: icon, title: " " + title, message: message, url: ""}, {
        element: "body",
        type: cls,
        allow_dismiss: !0,
        placement: {from: 'top', align: 'right'},
        offset: {x: 15, y: 15},
        spacing: 10,
        z_index: 1080,
        delay: 2500,
        timer: 2000,
        url_target: "_blank",
        mouse_over: !1,
        animate: {enter: o, exit: i},
        template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
    });
}