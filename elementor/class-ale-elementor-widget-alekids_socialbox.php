<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Socialbox extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-socialbox_elementor',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-socialbox_elementor.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-socialbox_elementor' ];
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
		return 'alekids_socialbox';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Social Box', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-social-icons';
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
				'label' => esc_html__( "Social Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'description',
			[
				'label' => esc_html__( "Social Description", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

				$this->add_control(
			'image',
			[
				'label' => esc_html__( "Choose Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image', 'ale'),
				]
        );
				
        $this->add_control(
			'link',
			[
				'label' => esc_html__( "Social Profile URL", "ale" ),
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
			'color',
			[
				'label' => esc_html__( 'Background Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_socialbox' => 'background-color: {{VALUE}}',
				],
			]
		);

				$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alekids_socialbox' => 'color: {{VALUE}}',
					'{{WRAPPER}} .alekids_socialbox .alekids_dashed' => 'stroke: {{VALUE}}',
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

<div class="alekids_socialbox">
	<svg class="alekids_dashed alekids_socialbox_dashed">
		<rect x="20px" y="20px" rx="24px" ry="24px" width="0" height="0"></rect>
	</svg>
	<div class="social_content">
		<div class="image_holder">
			<?php if($settings['image']['url']){ ?>
			<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_html__($settings['title']); ?>">
			<?php } ?>
		</div>
		<div class="text_holder">
			<?php if(!empty($settings['link']['url'])){ ?>
			<a href="<?php echo esc_url($settings['link']['url']); ?>" <?php if(isset($settings['link']['is_external'])) {echo 'target="'.($settings['link']['is_external'] ? '_blank' : '_self').'"';} if(isset($settings['link']['nofollow'])){echo 'rel="'.($settings['link']['nofollow'] ? 'nofollow' : '').'"';} ?>>
				<?php if($settings['title']){ ?><h6><?php echo esc_html($settings['title']); ?></h6><?php } ?>
			</a>
			<?php }
				else {
					if($settings['title']){ ?><h6><?php echo esc_html($settings['title']); ?></h6><?php }
				}
			?>
			<?php if($settings['description']){ ?><p><?php echo esc_html($settings['description']); ?></p><?php } ?>
		</div>
	</div>
</div>


<?php 



	}

}