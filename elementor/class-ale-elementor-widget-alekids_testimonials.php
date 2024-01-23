<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Testimonials extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids_testimonials',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-testimonials.js', [ 'elementor-frontend', 'jquery-slick' ], '1.0', true );
			return [ 'alekids_testimonials' ];
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
					'field' => 'list_name',
					'type' => $this->get_title() .'<br />'. esc_html__( "Name", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'list_title',
					'type' => $this->get_title() .'<br />'. esc_html__( "Title", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'list_content',
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
		return 'alekids_testimonials';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Testimonials', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-review';
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
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$this->add_control(
			'color_text',
			[
				'label' => esc_html__( 'Textr Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#7D7D7D',
				'selectors' => [
					'{{WRAPPER}} .testimonial_text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .occupation' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'list_name',
			[
				'label' => esc_html__( 'Name', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => esc_html__( 'Decor Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFD3BD',
			]
		);

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__( 'Title', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'list_content',
			[
				'label' => esc_html__( 'Testimonial Text', 'ale' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'show_label' => false,
			]
		);


		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Testimonials List', 'ale' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_name }}}',
			]
		);

		$this->end_controls_section();



	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		wp_enqueue_script('slick');
		$settings = $this->get_settings_for_display();
		?>

<div class="alekids_testimonial_slider">
	<?php 
				if ($settings['list']) {
					foreach($settings['list'] as $testimonial) { ?>
	<div class="testimonial_item">
		<svg class="alekids_dashed alekids_testimonial_dashed" <?php if(!empty($testimonial['color'])) {echo 'style="stroke: '.esc_attr($testimonial['color']).' "';} ?>>
			<rect x="2px" y="2px" rx="26px" ry="26px" width="0" height="0"></rect>
		</svg>
		<?php if (!empty($testimonial['list_name'])) { ?>
		<h4 <?php if(!empty($testimonial['color'])) {echo 'style="color: '.esc_attr($testimonial['color']).' "';} ?>><?php echo esc_html($testimonial['list_name']); ?></h4>
		<?php } ?>
		<?php if (!empty($testimonial['list_title'])) { ?>
		<span class="occupation"><?php echo esc_html($testimonial['list_title']); ?></span>
		<?php } ?>
		<?php if (!empty($testimonial['list_content'])) { ?>
		<div class="testimonial_text">
			<?php echo wp_kses_post($testimonial['list_content']);  ?>
		</div>
		<?php } ?>
	</div>
	<?php }
				}
			?>
</div>

<?php
		
	}
}