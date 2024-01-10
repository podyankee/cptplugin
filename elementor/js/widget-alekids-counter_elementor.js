(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/alekids_counter.default',
			function ($scope, $) {
				('use strict');
			},
		);
	});
})(jQuery);
