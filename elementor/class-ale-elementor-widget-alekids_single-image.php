<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Ale_Elementor_Widget_Alekids_Single_Image extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-single_image',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-single_image.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-single_image' ];
		}

		return [];
	} 

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

	

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'alekids_single_images';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Single Image', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-image';
	}

	/**
	 * Get widget categories
	 */

	public function get_categories() {
		return [ 'ale_builder' ];
	}

	/**
	 * Register widget controls
	 */

	protected function _register_controls() {

		$this->start_controls_section(
			'first_section',
			[
				'label' => esc_html__( 'Content', 'ale' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( "Choose Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image with size: 580x540', 'ale'),
				]
        );
      

			$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

		?>

<div class="alekids_single_image">
	<svg class="alekids_dashed alekids_images_grid_dashed">
		<rect x="0px" y="0px" rx="26px" ry="26px" width="3" height="3"></rect>
	</svg>
	<div class="single_image_container">
		<?php if($settings['image']['url']){ ?>
		<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_html__('Single Image', 'alekids'); ?>">
		<?php } ?>
	</div>
</div>


<?php

	}

}