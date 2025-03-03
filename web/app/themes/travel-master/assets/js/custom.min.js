jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    if( $(window).width() < 767 ) {
        $('#top-bar').click(function(){
            $('#top-bar .wrapper').slideToggle();
            $('#top-bar').toggleClass('top-menu-active');
        });
    }

    menu_toggle.click(function(){
        $('.main-navigation .dropdown-toggle').removeClass('active');
        $('.main-navigation .sub-menu').removeClass('toggled-on');
        $('.main-navigation .sub-menu').slideUp();
        nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('.main-navigation').toggleClass('menu-open');
        $('.menu-overlay').toggleClass('active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
        $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.menu-sticky #masthead').addClass('nav-shrink');
        }
        else {
            $('.menu-sticky #masthead').removeClass('nav-shrink');
        }
    });

    if ($(window).width() < 1024) {
        $( ".nav-menu ul.sub-menu li:last-child" ).focusout(function() {
            dropdown_toggle.removeClass('active');
            $('.main-navigation .sub-menu').slideUp();
        });
    }  

/*--------------------------------------------------------------
 Keyboard Navigation
----------------------------------------------------------------*/
if( $(window).width() < 1024 ) {
    $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
        if( e.which === 9 ) {
            e.preventDefault();
            $('#masthead').find('.menu-toggle').focus();
        }
    });
}
else {
    $( '#primary-menu li:last-child' ).unbind('keydown');
}

$(window).resize(function() {
    if( $(window).width() < 1024 ) {
        $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $( '#primary-menu li:last-child' ).unbind('keydown');
    }
});

menu_toggle.on('keydown', function (e) {
    var tabKey    = e.keyCode === 9;
    var shiftKey  = e.shiftKey;

    if( menu_toggle.hasClass('active') ) {
        if ( shiftKey && tabKey ) {
            e.preventDefault();
            nav_menu.slideUp();
            $('.main-navigation').removeClass('menu-open');
            $('.menu-overlay').removeClass('active');
            menu_toggle.removeClass('active');
        };
    }
});

/*------------------------------------------------
            SLICK SLIDER
------------------------------------------------*/

$('.featured-slider').slick({
    responsive: [{
        breakpoint: 1023,
            settings: {
            slidesToShow: 1,
            arrows: false
        }
    }]
});
$('.gallery-slider').slick({
    responsive: [{
        breakpoint: 1200,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 400,
        settings: {
            slidesToShow: 1
        }
    }]
});
$('#destination-slider .destination-slider-wrapper').slick({
    responsive: [{
        breakpoint: 767,
            settings: {
            slidesToShow: 1,
            fade: false,
            arrows: true,
            dots: false
        }
    }]
});
$('.places-slider').slick();
$('.clients-feedback').slick({
    responsive: [{
        breakpoint: 1200,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 1,
            fade: true
        }
    }]
});

/*------------------------------------------------
                TABS
------------------------------------------------*/

$('ul.tabs li').click(function(event) {
    event.preventDefault();
    
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('active');
    $('.tab-content').removeClass('active');

    $(this).addClass('active');
    $("#"+tab_id).addClass('active');
});

/*------------------------------------------------
            POPUP VIDEO
------------------------------------------------*/

    $(".video-link").click(function (event) {
        event.preventDefault();
        $('.popup .widget_media_video').fadeIn();
        $('.video-overlay').addClass('active');
    });

    $(document).click(function (e) {
        var container = $(".video-link,.popup .widget_media_video");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".popup .mejs-controls .mejs-playpause-button.mejs-pause button").trigger("click");
            $('.popup .widget_media_video').fadeOut();
            $('.video-overlay').removeClass('active');            
        }
    });
    
/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});