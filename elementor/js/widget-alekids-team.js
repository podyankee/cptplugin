(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/alekids_team.default',

			function ($scope, $) {
				'use strict';

				// Team Slider
				if ($('.alekids_team_slider'.length)) {
					$('.alekids_team_slider').slick({
						infinite: true,
						autoplay: false,
						arrows: false,
						slidesToShow: 2,
						slidesToScroll: 1,
						dots: true,
					});
				}
			},
		);
	});
})(jQuery);
