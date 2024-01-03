<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Button extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-button_elementor',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-button_elementor.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-button_elementor' ];
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
					'field' => 'title',
					'type' => $this->get_title() .'<br />'. esc_html__( "Text on Button", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			],
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'alekids_button';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Button', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-button';
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
			'title',
			[
				'label' => esc_html__( "Text on Button", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Button', 'ale' ),
			]
        );
				
        $this->add_control(
			'link',
			[
				'label' => esc_html__( "Button URL", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__( 'https://your-link.com', 'ale' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				]
        );

      
				$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Background Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_button' => 'background-color: {{VALUE}}',
				],
			]
		);

				$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .alekids_button .alekids_dashed' => 'stroke: {{VALUE}}',
				],
			]
		);

      
				$this->add_control(
			'color_hover',
			[
				'label' => esc_html__( 'Hover Background Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

				$this->add_control(
			'text_color_hover',
			[
				'label' => esc_html__( 'Hover Text Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .alekids_button:hover .alekids_dashed' => 'stroke: {{VALUE}}',
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


	if(!empty($settings['link']['url'])) { ?>

<a href="<?php echo esc_url($settings['link']['url']); ?>" <?php if(isset($settings['link']['is_external'])) {echo 'target="'.($settings['link']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link']['nofollow'])){echo 'rel="'.($settings['link']['nofollow'] ? 'nofollow' : '').'"';} ?> class="alekids_button">

	<div class="container">
		<span><?php echo esc_html($settings['title']); ?></span>
		<span>
			<svg class="alekids_dashed">
				<rect x="5px" y="5px" rx="25px" ry="25px" width="0" height="0"></rect>
			</svg>
		</span>
	</div>
</a>
<?php } 


	}

}