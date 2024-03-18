<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Video extends \Elementor\Widget_Base {


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
		return 'alekids_video';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Video', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-video-playlist';
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
			'video',
			[
				'label' => esc_html__( "Video Link", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

			$this->add_control(
			'image',
			[
				'label' => esc_html__( "Choose Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => esc_html__('Upload an image. Recommended size: 340x340', 'ale'),
				]
        );
        


		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		wp_enqueue_style('venobox');
		wp_enqueue_script('venobox');

		$settings = $this->get_settings_for_display();


	?>

<div class="alekids_video">
	<div class="mask"></div>
	<div class="image_holder">
		<?php if($settings['image']['url']){ ?>
		<img src="<?php echo esc_url($settings['image']['url']); ?>" alt="<?php echo esc_html__('Single Image', 'alekids'); ?>">
		<?php } ?>
		<?php  if(!empty($settings['video'])) { ?>
		<a href="<?php echo esc_url($settings['video']); ?>" data-overlay="rgba(255, 211, 189, 0.8)" data-autoplay="true" data-vbtype="video" class="venobox open_video"><span class="opener"><span class="video_icon"></span></span></a>
		<?php } ?>
	</div>
</div>

<?php 


	}

}