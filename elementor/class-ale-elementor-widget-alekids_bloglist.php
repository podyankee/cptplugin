<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Bloglist extends \Elementor\Widget_Base {

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
		return 'alekids_bloglist';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Blog List', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-gallery-grid';
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
				'default' => '3',
			]
        );

			$this->add_control(
			'columns',
			[
				'label' => esc_html__( "Columns", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'three',
				'options' => [
					'one'=> esc_html( '1 Column', 'ale' ),
					'two'=> esc_html( '2 Columns', 'ale' ),
					'three'=> esc_html( '3 Columns', 'ale' ),
					'four'=> esc_html( '4 Columns', 'ale' ),
				]
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
				'default' => 'yes', 
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
			'show_infoline',
			[
				'label' => esc_html__('Show info line', 'ale'),
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
				'default' => 'no', 
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

		$columns = 'three_columns';
		if (!empty($settings['columns'])) {
			$columns = $settings['columns'] . '_columns';
		}

		$args = array('post_type'=>'post', 'posts_per_page'=>esc_attr($posts_count));

		$alekids_blogposts = new WP_QUERY($args);

		echo '<div class="posts_grid '.esc_attr($columns).' ">';

		if ($alekids_blogposts->have_posts()) : while ($alekids_blogposts->have_posts()) : $alekids_blogposts->the_post();

		$archive_year = get_the_time('Y');
		$archive_month = get_the_time('m');
		$archive_day = get_the_time('d');

		?>

<article <?php post_class('alekids_blog_preview'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
	<?php if ($settings['show_image'] == 'yes') { ?>
	<?php if(get_the_post_thumbnail(get_the_ID(), 'large')) { ?>
	<div class="featured_image">
		<div class="featured_image_holder">
			<a href="<?php the_permalink(); ?>">
				<?php
				if ($settings['columns'] == 'one' or $settings['columns'] == 'two') {		
					echo get_the_post_thumbnail(get_the_ID(), 'full'); 
				} else {
					echo get_the_post_thumbnail(get_the_ID(), 'post_smallimage'); 
				}
				?>
			</a>
		</div>
		<?php if ($settings['show_category'] == 'yes') { ?>
		<span class="category font_one"><?php the_category(' '); ?></span>
		<?php } ?>
	</div>
	<?php } ?>
	<?php } ?>
	<?php if ($settings['show_infoline'] == 'yes') { ?>
	<span class="post_info"><?php esc_html_e('By', 'alekids');?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>"><?php the_author(); ?></a> posted on <?php echo '<a href="'.esc_attr(get_day_link($archive_year, $archive_month, $archive_day)).'">' .get_the_date(). '</a>'; ?></span>
	<?php } ?>
	<?php if ($settings['show_title'] == 'yes') { ?>
	<h3><a href="<?php echo esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
	<?php } ?>
	<?php if ($settings['show_excerpt'] == 'yes') { ?>
	<?php echo wp_kses_post(ale_trim_excerpt(23)); ?>
	<?php } ?>
	<?php if ($settings['show_link'] == 'yes') { ?>
	<a class="read_more_blog font_one" href="<?php echo esc_url(the_permalink()); ?>"><?php esc_html_e('Read More','alekids'); ?></a>
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