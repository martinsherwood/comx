$(function(cookieConsent) {
	$(".cookie-accept").click(function () {
		days = 365; //number of days to keep the cookie
		myDate = new Date();
		myDate.setTime(myDate.getTime()+(days*24*60*60*1000));
		document.cookie = "comxCookie = true; expires = " + myDate.toGMTString(); //create
		$("#cookies").slideUp("fast");
	});
});

//sticks the header to the top when page is scrolled
var animatedHeader = (function() {
	var docElem = document.documentElement,
		header = $("#top-bar"),
		didScroll = false,
		changeHeaderOn = 300;

	function init() {
		window.addEventListener("scroll", function(event) {
			if (!didScroll) {
				didScroll = true;
				setTimeout(scrollPage, 250);
			}
		}, false );
	}

	function scrollPage() {
		var sy = scrollY();
		if (sy >= changeHeaderOn) {
            header.addClass("reveal");
		} else {
			header.removeClass("reveal");
		}
		didScroll = false;
	}

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}
	init();
})();

$("#go-down").click(function () {
    $("html, body").animate({
        scrollTop: $("#intro").offset().top - 200
    });
});

//mobile menu function
var mobileMenu = {
    
    el: {
        menuTrigger: $(".mobile-nav-btn"),
        menuTop: $(".menu-top"),
        menuMiddle: $(".menu-middle"),
        menuBottom: $(".menu-bottom"),
        mobileNav: $("#mobile-panel")
    },

    init: function() {
        mobileMenu.bindUIactions();
    },

    bindUIactions: function() {
        mobileMenu.el.menuTrigger.on("click", function(event) {
            mobileMenu.activateMenu(event);
            event.preventDefault();
        });
    },

    activateMenu: function() {
        mobileMenu.el.menuTop.toggleClass("menu-top-click");
        mobileMenu.el.menuMiddle.toggleClass("menu-middle-click");
        mobileMenu.el.menuBottom.toggleClass("menu-bottom-click");
        mobileMenu.el.menuTrigger.toggleClass("nav-open");
        mobileMenu.el.mobileNav.toggleClass("nav-visible");
    }
};

mobileMenu.init();


//contact form
$(".contact-form").submit(function(event) {
	event.preventDefault();
	
	var name  = $("#name").val();
	var email = $("#email").val();
	var text  = $("#text").val();
	
	//check for blank inputs
	if (name == "") {
		$(".no-email").hide();
		$(".no-text").hide();
		$(".no-name").slideDown("fast");
		$("#name").focus();
		return false;
	}
	
	if (email == "") {
		$(".no-name").hide();
		$(".no-text").hide();
		$(".no-email").slideDown("fast");
		$("#email").focus();
		return false;
	}
	
	if (text == "") {
		$(".no-name").hide();
		$(".no-email").hide();
		$(".no-text").slideDown("fast");
		$("#text").focus();
		return false;
	}
	
	var dataString = 'name=' + name + '&email=' + email + '&text=' + text;
	//alert (dataString); return false;
	
	$.ajax({
		type: "POST",			
		url: "contact.php",
		data: dataString,
		beforeSend: function() {
		//showsanimation
			$(".contact-form").html("<div class=\"loading\"><i class=\"fa fa-spinner fa-pulse fa-2x\"></i></div>");
		},
		success: function() {
			$(".contact-form").html("<p class=\"sent\">Thanks, we've got your message and we'll reply shortly!</p>");
		}
	});
	return false;
});