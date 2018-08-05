/**
 * Created by KayL on 28/11/2016.
 */


/* nav-main-menu script */
var navbar = $('.navbar');
var navMenuLink = $('.nav-menu-link');
var dropdownBox = $('.dropdown-box');
var dropdownContainer = $('.dropdown-container');
var dropdownSection = $('.dropdown-section');
var elAttr, selectedEl;
var minWidthArray = [];



$('.has-dropdown').hover(function() {
    navbar.removeClass('no-dropdown').addClass('show-dropdown');
},function() {
    navbar.removeClass('show-dropdown').addClass('no-dropdown');
});
dropdownBox.hover(function() {
    navbar.removeClass('no-dropdown').addClass('show-dropdown');
},function() {
    navbar.removeClass('show-dropdown').addClass('no-dropdown');
});

// for touch devices that have big screen
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

    navMenuLink.on('touchstart', function() {
        var onTouchEl = $(this);
        console.log(onTouchEl);
        elAttr = onTouchEl.attr('data-toggle');
        console.log(elAttr);
        selectedEl = $('.dropdown-section[data-toggle="' + elAttr + '"]');
        console.log(selectedEl);
        dropdownContainer.outerWidth(selectedEl.outerWidth(true)).outerHeight(selectedEl.outerHeight(), true);
        dropdownSection.removeAttr('style');
        setTimeout(function(){
            selectedEl.css({"opacity": 1, "z-index": 500});
            dropdownBox.css("left", onTouchEl.offset().left + (onTouchEl.outerWidth(true) / 2) - (minWidthArray[selectedEl.index()] / 2));
        }, 100);
        dropdownBox.on('touchstart', function () {
            selectedEl.css({"opacity": 1, "z-index": 500});
        });
    });

    $('body').on('touchstart', function() {
        selectedEl.removeAttr('style');
        navbar.removeClass('show-dropdown').addClass('no-dropdown');
    });

} else {

    navMenuLink.hover(function() {
        var onHoverEl = $(this);
        elAttr = onHoverEl.attr('data-toggle');
        selectedEl = $('.dropdown-section[data-toggle="'+elAttr+'"]');
        dropdownContainer.outerWidth(selectedEl.outerWidth(true)).outerHeight(selectedEl.outerHeight(), true);
        selectedEl.css({ "opacity": 1, "z-index": 500 });
        dropdownBox.css("left", onHoverEl.offset().left + (onHoverEl.outerWidth(true) / 2) - (minWidthArray[selectedEl.index()] / 2));
        dropdownBox.hover(function() {
            selectedEl.css({
                "opacity": 1,
                "z-index": 500
            });
        }, function() {
            selectedEl.removeAttr('style');
        })
    }, function() {
        selectedEl.removeAttr('style');
    });

}

/* mobile-main-menu script */
var navMenuMobile = $('.nav-menu-mobile');
var menuOverlay = $('.menu-overlay');

$('.mobile-popup-link').click(function() {
    navMenuMobile.addClass('show-popup');
    menuOverlay.show();
});
$('.popup-close-btn').click(function() {
    menuOverlay.hide();
    navMenuMobile.removeClass('show-popup');
});
menuOverlay.click(function() {
    $(this).hide();
    navMenuMobile.removeClass('show-popup');
});


function callOwlCarousel(){

    $('.owl-carousel').owlCarousel({
        loop:true,
        items: 1,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsiveClass:true,
        responsive : {
            // breakpoint from 480 up
            468 : { items : 2 },
            // breakpoint from 768 up
            768 : { items : 3 },
            992 : { items : 4 }
        }
    });

}


function initHeightOfVideoCard(){

    var videoList = $('.video-list');
    var getWidth = videoList.find('.owl-item').first().width();

    videoList.find('.owl-item').height((getWidth - 20) / 16 * 9);

}

function callVideoNav(){

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:15,
        items: 1,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsiveClass:true,
        responsive : {
            // breakpoint from 480 up
            480 : { items : 2 },
            // breakpoint from 768 up
            768 : { items : 4 },
            992 : { items : 6 }
        }
    });

}


function setWrapBoxHeight() {
    var wrapBox = $('.wrapBox');
    wrapBox.height(wrapBox.width());
}