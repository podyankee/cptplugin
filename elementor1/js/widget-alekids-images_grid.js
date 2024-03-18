(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/alekids_single_images_grid.default',
			function ($scope, $) {
				('use strict');

				//Alekids button style

				function alekidsButtonRect(svg) {
					if (svg) {
						let width = svg.outerWidth();
						let height = svg.outerHeight();
						let svgRect = svg.find('rect');
						let x_pos_rect = svgRect.attr('x');
						let y_pos_rect = svgRect.attr('y');

						if (x_pos_rect) width = width - parseInt(x_pos_rect) * 2;
						if (y_pos_rect) height = height - parseInt(y_pos_rect) * 2;

						if (width > 0 && height > 0) {
							svgRect.attr('width', width);
							svgRect.attr('height', height);
						}
					}
				}

				if ($('.alekids_dashed').length) {
					$('.alekids_dashed').each(function () {
						let svg = $(this);
						alekidsButtonRect(svg);
					});
				}
			},
		);
	});
})(jQuery);
