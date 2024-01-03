<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Images_Grid extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-images_grid',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-images_grid.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-alekids-images_grid' ];
		}

		return [];
	} 

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {

		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );

		parent::__construct( $data, $args );
	}

	/**
	 * WPML compatibility
	 */

	public function wpml_widgets_to_translate_filter( $widgets ) {

	  $widgets[ $this->get_name() ] = [
			'conditions' => [
				'widgetType' => $this->get_name(),
			],
			'fields' => [
			  [
					'field' => 'title_one',
					'type' => $this->get_title() .'<br />'. esc_html__( "Sub Title", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'title_two',
					'type' => $this->get_title() .'<br />'. esc_html__( "Main Title", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'description',
					'type' => $this->get_title() .'<br />'. esc_html__( "Description", "alekids" ),
					'editor_type' => 'VISUAL'
			  ],
			],
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'alekids_images_grid';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Images Grid', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-gallery-grid';
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
				'label' => esc_html__( 'First Image', 'ale' ),
			]
		);

		$this->add_control(
			'image1',
			[
				'label' => esc_html__( "Choose First Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image with size: 280x280', 'ale'),
				]
        );

		$this->add_control(
			'title1',
			[
				'label' => esc_html__( "Image Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
      
        $this->add_control(
			'link1',
			[
				'label' => esc_html__( "URL for Image", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__( 'https://your-link.com', 'ale' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				]
        );

			$this->end_controls_section();
			

			$this->start_controls_section(
			'second_section',
			[
				'label' => esc_html__( 'Second Image', 'ale' ),
			]
		);

		$this->add_control(
			'image2',
			[
				'label' => esc_html__( "Choose Second Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image with size: 280x280', 'ale'),
				]
        );

		$this->add_control(
			'title2',
			[
				'label' => esc_html__( "Image Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
      
        $this->add_control(
			'link2',
			[
				'label' => esc_html__( "URL for Image", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__( 'https://your-link.com', 'ale' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'third_section',
			[
				'label' => esc_html__( 'Third Image', 'ale' ),
			]
		);

		
			$this->add_control(
			'image3',
			[
				'label' => esc_html__( "Choose Third Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image with size: 580x280', 'ale'),
				]
        );

		$this->add_control(
			'title3',
			[
				'label' => esc_html__( "Image Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
      
        $this->add_control(
			'link3',
			[
				'label' => esc_html__( "URL for Image", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__( 'https://your-link.com', 'ale' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
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

<div class="alekids_images_grid">
	<svg class="alekids_dashed alekids_images_grid_dashed">
		<rect x="0px" y="0px" rx="26px" ry="26px" width="3" height="3"></rect>
	</svg>
	<div class="images_container">
		<figure class="image_item_small">
			<?php if($settings['image1']['url']){ ?>
			<img src="<?php echo esc_url($settings['image1']['url']); ?>" alt="<?php echo esc_html($settings['title1']); ?>">
			<?php } ?>

			<?php if($settings['link1']['url']){ ?>
			<a href="<?php echo esc_url($settings['link1']['url']); ?>" <?php if(isset($settings['link1']['is_external'])) {echo 'target="'.($settings['link1']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link1']['nofollow'])){echo 'rel="'.($settings['link1']['nofollow'] ? 'nofollow' : '').'"';} ?>></a>
			<?php } ?>

			<?php if($settings['title1']){ ?>
			<figcaption class="font_one"><?php echo esc_html($settings['title1']); ?></figcaption>
			<?php } ?>
		</figure>

		<figure class="image_item_small">
			<?php if($settings['image2']['url']){ ?>
			<img src="<?php echo esc_url($settings['image2']['url']); ?>" alt="<?php echo esc_html($settings['title2']); ?>">
			<?php } ?>

			<?php if($settings['link2']['url']){ ?>
			<a href="<?php echo esc_url($settings['link2']['url']); ?>" <?php if(isset($settings['link2']['is_external'])) {echo 'target="'.($settings['link2']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link2']['nofollow'])){echo 'rel="'.($settings['link2']['nofollow'] ? 'nofollow' : '').'"';} ?>></a>
			<?php } ?>

			<?php if($settings['title2']){ ?>
			<figcaption class="font_one"><?php echo esc_html($settings['title2']); ?></figcaption>
			<?php } ?>
		</figure>

		<figure class="image_item_big">
			<?php if($settings['image3']['url']){ ?>
			<img src="<?php echo esc_url($settings['image3']['url']); ?>" alt="<?php echo esc_html($settings['title3']); ?>">
			<?php } ?>

			<?php if($settings['link3']['url']){ ?>
			<a href="<?php echo esc_url($settings['link3']['url']); ?>" <?php if(isset($settings['link3']['is_external'])) {echo 'target="'.($settings['link3']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link3']['nofollow'])){echo 'rel="'.($settings['link3']['nofollow'] ? 'nofollow' : '').'"';} ?>></a>
			<?php } ?>

			<?php if($settings['title3']){ ?>
			<figcaption class="font_one"><?php echo esc_html($settings['title3']); ?></figcaption>
			<?php } ?>
		</figure>

	</div>
</div>


<?php

	}

}