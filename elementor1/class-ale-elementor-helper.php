<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Ale_Elementor_Helper {

	/**
	 * Create new category
	 */

	public static function categories_registered( $elements_manager ){

	  $elements_manager->add_category(
			'ale_builder',
			[
				'title' => __( 'AleKids', 'ale' ),
				'icon' => 'fa fa-plug',
			]
		);

	}

}
