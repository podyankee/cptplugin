<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Gallerylist extends \Elementor\Widget_Base {

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
		return 'alekids_gallerylist';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Gallery List', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-gallery-masonry';
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
			'count',
			[
				'label' => esc_html__( "Posts count", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '4',
			]
        );

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__('Show category', 'ale'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ale'), 
				'Label_off' => esc_html__('Hide', 'ale'), 
				'return_value' => 'yes', 
				'default' => 'no', 
			]
			);

		$this->add_control(
			'show_image',
			[
				'label' => esc_html__('Show image', 'ale'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ale'), 
				'Label_off' => esc_html__('Hide', 'ale'), 
				'return_value' => 'yes', 
				'default' => 'yes', 
			]
			);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__('Show title', 'ale'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ale'), 
				'Label_off' => esc_html__('Hide', 'ale'), 
				'return_value' => 'yes', 
				'default' => 'yes', 
			]
			);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__('Show excerpt', 'ale'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ale'), 
				'Label_off' => esc_html__('Hide', 'ale'), 
				'return_value' => 'yes', 
				'default' => 'yes', 
			]
			);

		$this->add_control(
			'show_link',
			[
				'label' => esc_html__('Show Read More', 'ale'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ale'), 
				'Label_off' => esc_html__('Hide', 'ale'), 
				'return_value' => 'yes', 
				'default' => 'yes', 
			]
			);



		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();
		$posts_count = '-1';
		if (!empty($settings['count'])) {
			$posts_count = $settings['count'];
		}

		$args = array('post_type'=>'galleries', 'posts_per_page'=>esc_attr($posts_count));

		$alekids_galleryposts = new WP_QUERY($args);

		echo '<div class="alekids_galleries">';

		if ($alekids_galleryposts->have_posts()) : while ($alekids_galleryposts->have_posts()) : $alekids_galleryposts->the_post();

		?>

<article <?php post_class('gallery_item'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
	<div class="gallery_content">
		<?php if ($settings['show_title'] == 'yes') { ?>
		<h3><a href="<?php esc_attr(the_permalink()); ?>"><?php the_title(); ?></a></h3>
		<?php } ?>
		<?php if ($settings['show_category'] == 'yes') {
		$categories = get_the_terms(get_the_ID(), 'gallery-category');
		if($categories) {
			echo '<div class="gallery_category font_one">';
		foreach($categories as $category) {
		echo $category->name;
				}
				echo '</div>';
			}
		} ?>
		<?php if ($settings['show_excerpt'] == 'yes') { ?>
		<?php echo wp_kses_post(ale_trim_excerpt(16)); ?>
		<?php } ?>
		<?php if ($settings['show_link'] == 'yes') { ?>
		<a class="read_more font_one" href="<?php esc_attr(the_permalink()); ?>"><?php esc_html_e('Take a look', 'alekids'); ?></a>
		<?php } ?>
	</div>
	<?php if ($settings['show_image'] == 'yes') { ?>
	<?php if(get_the_post_thumbnail(get_the_ID(), 'gallery-square')){ ?>
	<div class="featured_image">
		<a href="<?php esc_attr(the_permalink()); ?>">
			<?php echo get_the_post_thumbnail(get_the_ID(), 'gallery-square'); ?>
		</a>
		<div class="gallery_icon">
			<div class="icon"></div>
		</div>
	</div>
	<?php } ?>
	<?php } ?>
</article>

<?php
			
			endwhile; else: 
					get_template_part('partials/notfound');
		endif;

		wp_reset_postdata();

		echo '</div>';

?>



<?php

	}

}