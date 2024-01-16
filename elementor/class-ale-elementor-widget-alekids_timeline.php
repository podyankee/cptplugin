<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Timeline extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids_timeline',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-timeline.js', [ 'elementor-frontend', 'jquery-slick' ], '1.0', true );
			return [ 'alekids_timeline' ];
		}

		return[];
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
		return 'alekids_timeline';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Timeline', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-slides';
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

		$repeater->add_control(
			'list_year',
			[
				'label' => esc_html__( 'Year', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' => esc_html__( 'Aspect Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#B3D0FD',
			]
		);

		$repeater->add_control(
			'list_title',
			[
				'label' => esc_html__( 'Title', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content',
			[
				'label' => esc_html__( 'Text', 'ale' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'show_label' => false,
			]
		);


		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Timeline List', 'ale' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_year' => esc_html__('1997', 'ale'),
						'list_title' => esc_html__('Started kids center', 'ale'),
						'list_content' => esc_html__('Turpis eu sit metus, id sed id sit a aliquet. Habitant vestibulum pellentesque.', 'ale'),
					],
					[
						'list_year' => esc_html__('2004', 'ale'),
						'list_title' => esc_html__('EduBii certifiedpartner', 'ale'),
						'list_content' => esc_html__('Turpis eu sit metus, id sed id sit a aliquet. Habitant vestibulum pellentesque.', 'ale'),
					],
				],
				'title_field' => '{{{ list_year }}}',
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

<div class="alekids_timeline">
	<?php 
				if ($settings['list']) {
					foreach($settings['list'] as $line) { ?>
	<div class="timeline_item">
		<div class="alekids_mask" <?php if(!empty($line['list_color'])){echo 'style="background-color:'.esc_attr($line['list_color']).'"';} ?>></div>
		<div class="line_content">
			<?php if (!empty($line['list_year'])) { ?>
			<span class="alekids_year font_one" <?php if(!empty($line['list_color'])){echo 'style="color:'.esc_attr($line['list_color']).'"';} ?>><?php echo esc_html($line['list_year']); ?></span>
			<?php } ?>
			<?php if (!empty($line['list_title'])) { ?>
			<span class="alekids_title"><?php echo esc_html($line['list_title']); ?></span>
			<?php } ?>
			<?php if (!empty($line['list_content'])) { ?>
			<div class="alekids_text">
				<?php echo wp_kses_post($line['list_content']);  ?>
			</div>
			<?php } ?>
		</div>

	</div>
	<?php }
				}
			?>
</div>

<?php
		
	}
}