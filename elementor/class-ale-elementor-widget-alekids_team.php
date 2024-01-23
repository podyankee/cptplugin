<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Team extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids_team',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-team.js', [ 'elementor-frontend', 'jquery-slick' ], '1.0', true );
			return [ 'alekids_team' ];
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
		return 'alekids_team';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Team', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-person';
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
			'image',
			[
				'label' => esc_html__( "Upload Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image', 'ale'),
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
			'list_color',
			[
				'label' => esc_html__( 'Aspect Color', 'ale' ),
				'type' => \Elementor\Controls_Manager::COLOR,
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

		$repeater->add_control(
			'list_ins',
			[
				'label' => esc_html__( 'Instagram Link', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'list_twi',
			[
				'label' => esc_html__( 'Twitter Link', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'list_fb',
			[
				'label' => esc_html__( 'Facebook Link', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);


		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Team Slider', 'ale' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_name' => esc_html__('Alex Socha', 'ale'),
						'list_content' => esc_html__('Maecenas dictum sed amet molestie. Orci, eu pretium eget enim imperdiet.', 'ale'),
						'list_ins' => '#',
						'list_twi' => '#',
						'list_fb' => '#',
					],
					[
						'list_name' => esc_html__('Elene White', 'ale'),
						'list_content' => esc_html__('Maecenas dictum sed amet molestie. Orci, eu pretium eget enim imperdiet.', 'ale'),
						'list_ins' => '#',
						'list_twi' => '#',
						'list_fb' => '#',
					],
				
				],
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

<div class="alekids_team_slider">
	<?php 
				if ($settings['list']) {
					foreach($settings['list'] as $member) { ?>
	<div class="team_slide">

		<div class="line_content" <?php if(!empty($member['list_color'])){echo 'style="background-color:'.esc_attr($member['list_color']).'"';} ?>>

			<?php if(!empty($member['image']['url'])) { ?>
			<div class="image_holder">
				<img src="<?php echo esc_url($member['image']['url']); ?>" alt="<?php echo esc_html($member['list_name']); ?>" />
			</div>
			<?php } ?>

			<?php if (!empty($member['list_name'])) { ?>
			<span class="team_name font_one"> <?php echo esc_html($member['list_name']); ?></span>
			<?php } ?>

			<?php if (!empty($member['list_content'])) { ?>
			<div class="team_text">
				<?php echo wp_kses_post($member['list_content']);  ?>
			</div>
			<?php } ?>
			<div class="team_social">

				<?php
				$custom_color = '#7292DE';

				if (!empty($member['list_color'])) {
					$custom_color = $member['list_color'];
				}

				if(!empty($member['list_ins'])) {
					echo '<a href="'.esc_url($member['list_ins']).'">
						<div class="alekids_round_icon">
							<div class="mask"></div>
							<div class="icon">
								<svg width="17" height="17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.875 4.207A4.044 4.044 0 0 0 4.832 8.25a4.021 4.021 0 0 0 4.043 4.043 4.044 4.044 0 0 0 4.043-4.043c0-2.215-1.828-4.043-4.043-4.043Zm0 6.68A2.633 2.633 0 0 1 6.238 8.25c0-1.441 1.16-2.602 2.637-2.602a2.596 2.596 0 0 1 2.602 2.602c0 1.477-1.16 2.637-2.602 2.637Zm5.133-6.82a.945.945 0 0 0-.95-.95.945.945 0 0 0-.949.95c0 .527.422.949.95.949.527 0 .949-.422.949-.95Zm2.672.949c-.07-1.266-.352-2.391-1.266-3.305C14.5.797 13.375.516 12.11.445c-1.3-.07-5.203-.07-6.504 0C4.34.515 3.25.797 2.301 1.711c-.914.914-1.196 2.039-1.266 3.305-.07 1.3-.07 5.203 0 6.504.07 1.265.352 2.355 1.266 3.304.949.914 2.039 1.196 3.304 1.266 1.301.07 5.204.07 6.504 0 1.266-.07 2.391-.352 3.305-1.266.914-.949 1.195-2.039 1.266-3.304.07-1.301.07-5.204 0-6.504Zm-1.688 7.875c-.246.703-.808 1.23-1.476 1.511-1.055.422-3.516.317-4.641.317-1.16 0-3.621.105-4.64-.317a2.665 2.665 0 0 1-1.512-1.511c-.422-1.02-.317-3.48-.317-4.641 0-1.125-.105-3.586.317-4.64a2.712 2.712 0 0 1 1.511-1.477c1.02-.422 3.48-.317 4.641-.317 1.125 0 3.586-.105 4.64.317.669.246 1.196.808 1.477 1.476.422 1.055.317 3.516.317 4.641 0 1.16.105 3.621-.317 4.64Z" fill="'.esc_attr($custom_color).'"/></svg>
							</div>
						</div>
					</a>';    
				}
				if(!empty($member['list_twi'])) {
					echo '<a href="'.esc_url($member['list_twi']).'">
						<div class="alekids_round_icon">
							<div class="mask"></div>
							<div class="icon">
								<svg width="18" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.137 4.594a7.818 7.818 0 0 0 1.828-1.899 6.918 6.918 0 0 1-2.11.563 3.607 3.607 0 0 0 1.618-2.04 7.798 7.798 0 0 1-2.32.915 3.691 3.691 0 0 0-2.708-1.16 3.69 3.69 0 0 0-3.691 3.691c0 .281.035.563.105.844A10.71 10.71 0 0 1 1.23 1.64a3.59 3.59 0 0 0-.492 1.863c0 1.266.633 2.39 1.653 3.058-.598-.035-1.196-.175-1.688-.457v.036a3.696 3.696 0 0 0 2.953 3.62c-.281.071-.633.141-.949.141-.246 0-.457-.035-.703-.07.457 1.477 1.828 2.531 3.445 2.566A7.422 7.422 0 0 1 .88 13.98c-.317 0-.598-.035-.879-.07 1.617 1.055 3.55 1.652 5.66 1.652 6.785 0 10.477-5.59 10.477-10.476v-.492Z" fill="'.esc_attr($custom_color).'"/></svg>
							</div>
						</div>
					</a>';    
				}
				if(!empty($member['list_fb'])) {
					echo '<a href="'.esc_url($member['list_fb']).'">
						<div class="alekids_round_icon">
							<div class="mask"></div>
							<div class="icon">
								<svg width="11" height="19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m9.809 10.375.492-3.234H7.17V5.03c0-.914.423-1.758 1.829-1.758h1.441V.496S9.141.25 7.911.25c-2.567 0-4.255 1.582-4.255 4.395V7.14H.773v3.234h2.883v7.875h3.516v-7.875h2.637Z" fill="'.esc_attr($custom_color).'"/></svg>
							</div>
						</div>
					</a>';    
				}?>
			</div>
		</div>

	</div>
	<?php }
				}
			?>
</div>

<?php
		
	}
}