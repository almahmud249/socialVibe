(function ($) {
	"use strict";
	/*********************************
	 * Table of Context
	 * *******************************/

     /*********************************
    /* Sticky Navbar
    *********************************/
    $(window).scroll(function () {
        var scrolling = $(this).scrollTop();
        var stikey = $(".header");

        if (scrolling >= 10) {
            $(stikey).addClass("nav-bg");
        } else {
            $(stikey).removeClass("nav-bg");
        }
    });

	/********************************
	 * Toggle Bar
	 ********************************/
	$(".header__toggle ").on("click", function (e) {
		e.preventDefault();
		$(".header__toggle").toggleClass("active");
		$(".header__menu").toggleClass("mblMenu__open");
	});

	$(".header .header__menu ul li a").on("click", function (event) {
		// event.preventDefault();
		$(".header__toggle").removeClass("active");
		// $(this).find(".header__menu").removeClass("mblMenu__open");
		$(".header__menu").removeClass("mblMenu__open");
	});

     /*********************************
    /* Click Scroll Action
    ********************************/

    $(".header .header__menu ul li a").on("click", function (e) {
        var target = this.hash,
            $target = $(target);

        $("html, body")
            .stop()
            .animate(
                {
                    scrollTop: $target.offset().top - 70,
                },
                100,
                "swing",
                function () {
                    window.location.hash = target;
                }
            );
    });

    /********************************
    * Language Dropdown
    ********************************/
    $(".language__dropdown .selected").on("click", function (e) {
        e.preventDefault();
        $(".dropdown__list").toggleClass("active");
        // $(".dropdown__list").removeClass("active");
        // $(this).parents(".meta__list").find(".dropdown__list").addClass("active");
    });

    $(document).on("click", function (e) {
        if ($(e.target).closest(".meta__list").length === 0 && $(e.target).closest(".language__dropdown").length === 0) {
            $(".dropdown__list").removeClass("active");
        }
    });


	/*********************************
    /*  Testimonial Slider
    *********************************/
    if ($(".testimonial__slider").length > 0) {
        var testimonialSlider = new Swiper(".testimonial__slider", {
            loop: false,
            spaceBetween: 20,
            grabCursor: true,
            autoplay: {
                enabled: false,
                delay: 2000,
            },
            navigation: {
                nextEl: ".testimonial-swipe-next",
                prevEl: ".testimonial-swipe-prev",
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                400: {
                    slidesPerView: 1,
                },
                479: {
                    slidesPerView: 1.3,
                },
                575: {
                    slidesPerView: 1.3,
                },
                767: {
                    slidesPerView: 1.5,
                },
                991: {
                    slidesPerView: 2.3,
                },
                1199: {
                    slidesPerView: 3,
                },
            },
        });
    }

    
    /*********************************
    /*  Login Slider Carousel
    *********************************/
    if ($(".login__slider").length > 0) {
        var loSlider = new Swiper ('.login__slider', {
            // direction: 'vertical',
            effect: 'fade',
            slidesPerView: 1,
            spaceBetween: 30,
            grabCursor: true,
            loop: true,
            autoplay: {
                enabled: true,
                delay: 2000,
            },
            pagination: {                       //pagination(dots)
                el: '.login-pagination',
            },
        })
    }

    /********************************
	 * Password Toggle
	 ********************************/
	$(".toggle__password").click(function () {
		// Find the associated password input field
		let passwordInput = $(this).prev(".password");
		// Toggle the input field's type between password and text
		let type = passwordInput.attr("type") === "password" ? "text" : "password";
		passwordInput.attr("type", type);

		// Toggle the eye icon class
		$(this).toggleClass("ri-eye-line ri-eye-off-line");
	});


    /**********************************
    /*  AOS animation
    **********************************/
    AOS.init();
	
})(jQuery);
