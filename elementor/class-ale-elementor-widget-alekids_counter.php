<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Counter extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-counter_elementor',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-counter_elementor.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-counter_elementor' ];
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
		return 'alekids_counter';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Counter', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-counter';
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
			'icon',
			[
				'label' => esc_html__( "Icon", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'=> esc_html( 'Crown Icon', 'ale' ),
					'two'=> esc_html( 'Layer Icon', 'ale' ),
					'three'=> esc_html( 'Boy Icon', 'ale' ),
					'four'=> esc_html( 'Stat Icon', 'ale' ),
					'custom'=> esc_html( 'Custom Image', 'ale' ),
				]
			]
        );

		$this->add_control(
			'image',
			[
				'label' => esc_html__( "Choose Icon Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
						'name' => 'icon',
						'operator' => '==',
						'value' => 'custom',
					)))]
        );

		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Counter Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'number',
			[
				'label' => esc_html__( "Number", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

      

				$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_text_color' => 'color: {{VALUE}}',
				],
			]
		);

      
				$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Number Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_number_color' => 'color: {{VALUE}}',
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
<div class="alekids_counter">
	<div class="image_container">
		<?php if ($settings['icon'] == 'custom') {
				$image_src = $settings['image']['url'];
				if (!empty($image_src)) {
					echo '<img src="'.esc_url($image_src).'" alt="'.esc_attr($settings['title']).'" />';
				}
			} else  {
				echo '<div class="icon_counter icon_'.esc_attr($settings['icon']).'"></div>';
			} ?>
	</div>
	<?php if($settings['title']){ ?><span class="font_one alekids_text_color"><?php echo esc_html($settings['title']); ?></span><?php } ?>
	<?php if($settings['number']){ ?><span class="font_one alekids_number_color"><?php echo esc_html($settings['number']); ?></span><?php } ?>
</div>
<?php  


	}

}