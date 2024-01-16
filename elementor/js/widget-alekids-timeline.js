(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/alekids_timeline.default',

			function ($scope, $) {
				('use strict');

				alert('Alert');

				// Timeline Slider
				if ($('.alekids_timeline'.length)) {
					$('.alekids_timeline').slick({
						infinite: true,
						autoplay: true,
						arrows: false,
						slidesToShow: 4,
						slidesToScroll: 1,
						dots: false,
						swipe: true,
					});
				}
			},
		);
	});
})(jQuery);
