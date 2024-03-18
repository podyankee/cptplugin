(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/alekids_shop.default',
			function ($scope, $) {
				('use strict');

				if ($('.alekids_product_slider').length) {
					let columns = $('.alekids_product_slider .products').data('columns');

					$('.alekids_product_slider .products').slick({
						infinite: true,
						autoplay: false,
						arrows: true,
						slidesToShow: columns,
						slidesToScroll: 1,
						dots: false,
						prevArrow: '<button type="button" class="slick-prev"></button>',
						nextArrow: '<button type="button" class="slick-next"></button>',
					});
				}
			},
		);
	});
})(jQuery);
