<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Title extends \Elementor\Widget_Base {

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
					'type' => $this->get_title() .'<br />'. esc_html__( "Title (Line 1)", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'title',
					'type' => $this->get_title() .'<br />'. esc_html__( "Title (Line 2)", "alekids" ),
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
		return 'alekids_title';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Title', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-site-title';
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
				'label' => esc_html__( "Title (Line 1)", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'title2',
			[
				'label' => esc_html__( "Title (Line 2)", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'textcolor',
			[
				'label' => esc_html__( 'Text Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#304566',
				'selectors' => [
					'{{WRAPPER}} .alekids_title h2' => 'color: {{VALUE}}',
				],
			]
		);

				$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Background Color (Line 1)', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom_color_line_one::before' => 'background-color: {{VALUE}}',
				],
			]
		);

				$this->add_control(
			'color2',
			[
				'label' => esc_html__( 'Background Color (Line 2)', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom_color_line_two::before' => 'background-color: {{VALUE}}',
				],
			]
		);

			$this->add_control(
			'align',
			[
				'label' => esc_html__( 'Title Align', 'ale' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'center' => esc_html__( 'Center', 'ale' ),
					'left' => esc_html__( 'Left', 'ale' ),
					'right' => esc_html__( 'Right', 'ale' ),
				],
				],
		);


        


		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();
		$align_style = 'style="text-align: '.esc_attr($settings['align']).'"';

		?>

<div class="alekids_title" <?php echo wp_kses_post($align_style); ?>>
	<?php
				if ($settings['title']) { ?>
	<h2 class="custom_color_line_one"><?php echo esc_html($settings['title']); ?></h2>
	<?php } ?>
	<?php
				if ($settings['title2']) { ?>
	<br />
	<h2 class="custom_color_line_two"><?php echo esc_html($settings['title2']); ?></h2>
	<?php } ?>
</div>



<?php

	}

}