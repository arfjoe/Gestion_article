'use strict';
$(document).ready(function() {
	$(".toggleMenu").css("display", "none");
	$(".nav li").hover(function() {
	 	$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});
});
 $(document).ready(function() {
	let ww = document.body.clientWidth;
	if (ww < 1023) {
		$(".toggleMenu").css("display", "inline-block");
		$(".nav li a").click(function() {
			$(this).parent("li").toggleClass('hover');
		});
	} else {
		$(".toggleMenu").css("display", "none");
		$(".nav li").hover(function() {
			$(this).addClass('hover');
		}, function() {
			$(this).removeClass('hover');
		});
	}
});
$(".nav li a").each(function() {
    if ($(this).next().length > 0) {
        $(this).addClass("parent");
    };
})
if (ww < 1023) {
    $(".toggleMenu").css("display", "inline-block");
    $(".nav li a.parent").click(function(e) {
        e.preventDefault();
         $(this).parent("li").toggleClass('hover');
    });
} else {
 }
$(".toggleMenu").click(function(e) {
	e.preventDefault();
	$(".nav").toggle();
});

if (ww < 1023) {
	$(".toggleMenu").css("display", "inline-block");
	$(".nav").hide();
} else {
	
}

let ww = document.body.clientWidth;
$(document).ready(function() {
	$(".toggleMenu").click(function(e) {
		e.preventDefault();
		$(".nav").toggle();
	});
	$(".nav li a").each(function() {
		if ($(this).next().length > 0) {
			$(this).addClass("parent");
		};
	})
	adjustMenu();
});
function adjustMenu() {
	if (ww < 1023) {
		$(".toggleMenu").css("display", "inline-block");
		$(".nav").hide();
		$(".nav li a.parent").click(function(e) {
			e.preventDefault();
		 	$(this).parent("li").toggleClass('hover');
		});
	} else {
		$(".toggleMenu").css("display", "none");
		$(".nav li").hover(function() {
		 		$(this).addClass('hover');
			}, function() {
				$(this).removeClass('hover');
		});
	}
}
$(window).bind('resize orientationchange', function() {
	ww = document.body.clientWidth;
	adjustMenu();
});
$(document).ready(function() {
	$(".toggleMenu").click(function(e) {
		e.preventDefault();
		$(this).toggleClass("active");
		$(".nav").toggle();
	});
});
	if (ww < 1023) {
		$(".toggleMenu").css("display", "inline-block");
		if (!$(".toggleMenu").hasClass("active")) {
			$(".nav").hide();
		} else {
			$(".nav").show();
		}
		$(".nav li a.parent").click(function(e) {
			e.preventDefault();
		 	$(this).parent("li").toggleClass('hover');
		});
    }
    $(".nav li").unbind('mouseenter mouseleave');