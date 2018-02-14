jQuery(document).ready(function($) {
    "use strict";
    // PrettyPhoto Script
    $('a[data-rel]').each(function() {
        $(this).attr('rel', $(this).data('rel'));
        $(".pretty-gallery a[rel^='prettyPhoto']").prettyPhoto();
    });
	
	 if ($('.gallery').length) {
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'normal',
            theme: 'light_square',
            slideshow: 3000,
            autoplay_slideshow: true
        });
        $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'fast',
            slideshow: 10000,
            hideflash: true
        });
    }


    // Home Banner
     if ($('#home-banner').length) {
        $('#home-banner').owlCarousel({
            loop: false,
            dots: false,
            nav: false,
            items: 1,
            autoplay: true,
            smartSpeed: 2000,
            animateOut: 'flipOutY',
            animateIn: 'fadeIn',
            URLhashListener: true,
            autoplayHoverPause: false,
        });
    }
	
	//TESTIMONIALS STYLE 2
	if ($('#event-slider').length) {
        $('#event-slider').bxSlider({
            mode: 'vertical',
            minSlides: 3,
            slideMargin: 10,
            pager: true,
            auto: true,
            speed: 5000,
        });
    }
	
	//EVENT
	if ($('#testimonial-2').length) {
        $('#testimonial-2').bxSlider({
            mode: 'vertical',
            minSlides: 1,
            slideMargin: 10,
            pager: true,
            auto: true,
            speed: 5000,
        });
    }
	
	//BLOG SLIDER
	if ($('#blog-slider').length) {
        $('#blog-slider').owlCarousel({
            loop: false,
            dots: false,
            nav: true,
            items: 1,
            autoplay: true,
            smartSpeed: 2000,
        });
    }
	
	//Recent Slider
    if ($('#recent-slider').length) {
        $('#recent-slider').owlCarousel({
            loop: true,
            dots: false,
            nav: true,
            items: 1,
            autoplay: true,
            smartSpeed: 2000,
        });
    }
	
	//Causes Style 1
    if ($('#causes-slider').length) {
        $('#causes-slider').owlCarousel({
            loop: true,
            dots: true,
            nav: false,
            navText: '',
            items: 3,
            smartSpeed: 1000,
            padding: 0,
            margin: 30,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1199: {
                    items: 3,
                }
            }
        });
    }
	
	//Shop Slider
    if ($('#shop-slider').length) {
        $('#shop-slider').owlCarousel({
            loop: true,
            dots: false,
            nav: false,
            navText: '',
            items:0,
            smartSpeed: 1000,
            padding: 0,
            margin: 5,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1199: {
                    items: 5,
                }
            }
        });
    }
	
	//Shop Slider 2
    if ($('#shop-slider-2').length) {
        $('#shop-slider-2').owlCarousel({
            loop: true,
            dots: true,
            nav: false,
            navText: '',
            items:0,
            smartSpeed: 1000,
            padding: 0,
            margin: 4,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1199: {
                    items: 4,
                }
            }
        });
    }
	
	//TESTIMONIALS 3
    if ($('#testimonial-3').length) {
        $('#testimonial-3').owlCarousel({
            loop: true,
            dots: true,
            nav: false,
            navText: '',
            items:2,
            smartSpeed: 1000,
            padding: 0,
            margin: 30,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1199: {
                    items: 2,
                }
            }
        });
    }
	
	//Progress
	if ($('.demo-pie-1').length) {
	 $('.demo-pie-1').pieChart({
                barColor: '#14afb4',
                trackColor: '#ebebeb',
                lineCap: 'round',
                lineWidth: 10,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });
	}
	
	   //EVENT TIMER
     if ($('.defaultCountdown').length) {
        var austDay = new Date();
        austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
        $('.defaultCountdown').countdown({
            until: austDay
        });
        $('#year').text(austDay.getFullYear());
    }
	
	    //COMINGSOON
     if ($('.defaultCountdown').length) {
        var austDay = new Date();
        austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
        $('.defaultCountdown').countdown({
            until: austDay
        });
        $('#year').text(austDay.getFullYear());
    }
	   
	
	// TESTIMONIALS STYLE 1
     if ($('#testimonial-1').length) {
        $('#testimonial-1').owlCarousel({
            loop: false,
            dots: true,
            nav: false,
            items: 1,
            autoplay: true,
            smartSpeed: 2000,
        });
    }
	
	//Project Style 1
    if ($('#project-1').length) {
	$(window).load(function(){ // Prevent the stage height from collapsing: GitHub #251
        $('#project-1').owlCarousel({
            loop: true,
            dots: false,
            nav: true,
            navText: '',
            items: 3,
            smartSpeed: 1000,
            padding: 0,
            margin: 5,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1199: {
                    items: 3,
                }
            }
        });
	});
    }
	   
    //Function End
});