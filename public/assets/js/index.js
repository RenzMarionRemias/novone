$(document).ready(function () {
	$(".home-menu").on("click", function (e) {
		e.preventDefault();
		$(".home-section").animatescroll({scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$(".services-menu").on("click", function (e) {
		e.preventDefault();
		$(".services-section").animatescroll({padding: 42, scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$(".about-menu").on("click", function (e) {
		e.preventDefault();
		$(".about-section").animatescroll({padding: 92, scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$(".contact-menu").on("click", function (e) {
		e.preventDefault();
		$(".contact-section").animatescroll({padding: 95, scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$(".navbar-brand").on("click", function (e) {
		e.preventDefault();
		$(".home-section").animatescroll({scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$("#getStartedBtn").on("click", function (e) {
		e.preventDefault();
		$(".services-section").animatescroll({padding: 42, scrollSpeed: 700, easing: 'easeInOutSine'});
	});

	$(window).scroll(function () {
		if ($("#manufactureIcon").visible() == true) {
			setTimeout(function () {
				$("#manufactureIcon").addClass("animated zoomIn");
				$("#manufactureIcon").css("opacity", 1)
			}, 300);
		}

		if ($("#deliverIcon").visible() == true) {
			setTimeout(function () {
				$("#deliverIcon").addClass("animated zoomIn");
				$("#deliverIcon").css("opacity", 1)
			}, 700);
		}

		if ($("#assistIcon").visible() == true) {
			setTimeout(function () {
				$("#assistIcon").addClass("animated zoomIn");
				$("#assistIcon").css("opacity", 1)
			}, 1200);
		}
	});
});
