<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Top_Screen extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-top-screen_elementor',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-top-screen_elementor.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-top-screen_elementor' ];
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
		return 'alekids_top_screen';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Top Screen', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-image-rollover';
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
			'content_section',
			[
				'label' => esc_html__( 'Content', 'ale' ),
			]
		);

		$this->add_control(
			'title_one',
			[
				'label' => esc_html__( "Sub Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
		$this->add_control(
			'title_two',
			[
				'label' => esc_html__( "Main Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'description',
			[
				'label' => esc_html__( "Description", "ale" ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
        'placeholder' => esc_html__( 'Type your description here', 'ale' ),
				],
        );
				
        $this->add_control(
			'link',
			[
				'label' => esc_html__( "URL", "ale" ),
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

        $this->add_control(
			'image',
			[
				'label' => esc_html__( "Choose Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				]
        );

        


		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

        $image_src = $settings['image']['url'];

		?>

<div class="alekids_top_screen" <?php if(!empty($image_src)) { echo 'style="background-image:url( '.$image_src.' )"';} ?>>
	<div class="wrapper">
		<div class="left_content">
			<?php if($settings['title_one']) { ?> <span class="subtitle font_one"><?php echo esc_html($settings['title_one']); ?></span><?php } ?>
			<?php if($settings['title_two']) { ?> <h3 class="top_screen_title font_one"><?php echo esc_html($settings['title_two']); ?></h3><?php } ?>
			<?php if($settings['description']) { ?> <div class="top_screen_description font_one"><?php echo wp_kses_post($settings['description']); ?></div><?php } ?>
			<?php if(!empty($settings['link']['url'])) { ?>
			<a href="<?php echo esc_url($settings['link']['url']) ?>" class="alekids_button" <?php if(isset($settings['link']['is_external'])) {echo 'target="'.($settings['link']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link']['nofollow'])){echo 'rel="'.($settings['link']['nofollow'] ? 'nofollow' : '').'"';} ?>>
				<div class="container">
					<span><?php esc_html_e('Take a look'); ?></span>
					<span>
						<svg class="alekids_dashed">
							<rect x="5px" y="5px" rx="25px" ry="25px" width="0" height="0"></rect>
						</svg>
					</span>
				</div>
			</a>
			<?php } ?>
		</div>
	</div>
	<div class="alekids_balloon_one"></div>
	<div class="alekids_balloon_two"></div>
	<div class="alekids_rocket"></div>
	<div class="alekids_lightbulb"></div>
	<div class="alekids_figure_one"></div>
	<div class="alekids_figure_two"></div>
</div>



<?php

	}

}