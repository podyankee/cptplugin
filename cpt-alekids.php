<?php
/**
 * Plugin Name: AleKids Theme Core
 * Plugin URI: http://aletheme.com
 * Description: This plugin will load necessary core for AleKids Theme like: Custom Post Types, Custom Taxonomies, Custom Metaboxes, Custom Widgets, Contact Form Core, Demo Install Core.
 * Version: 1.0
 * Author: CRIK0VA / ALETHEME.COM
 * Author URI: http://aletheme.com
 * License: GPL v2
 */

define('ALE_PLUGIN_URL', plugin_dir_url( __FILE__ ));

//Theme Registration
//require_once (plugin_dir_path( __FILE__ ) . 'inc/AleInit.php');

//Contact Form Class
require_once ('contact.php');
require_once ('social.php');

//Load Custom Widgets
require_once (plugin_dir_path( __FILE__ ) . 'widgets/widget-blog.php');

//Load Custom Metaboxes
require_once (plugin_dir_path( __FILE__ ) . 'metaboxes/gallery-meta.php');
require_once (plugin_dir_path( __FILE__ ) . 'metaboxes/meta-init.php');
require_once (plugin_dir_path( __FILE__ ) . 'metaboxes/metaboxes.php');

// Load Elementor

require_once (plugin_dir_path( __FILE__ ) . 'elementor/class-ale-elementor.php');



//Load JS for Gallery Metabox
function ale_add_scripts_plugin($hook) {

	// Add scripts for metaboxes
  	if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php' ) {
	    wp_enqueue_script('aletheme-metabox-gallery', plugin_dir_url( __FILE__ ) . 'assets/js/meta.js', array('jquery', 'jquery-ui-sortable'));
    }
}
add_action( 'admin_enqueue_scripts', 'ale_add_scripts_plugin', 10 );

//Widgets Init

function ale_init_widgets() {
	register_widget('Aletheme_Blog_Widget');
}

add_action('widgets_init', 'ale_init_widgets');


//Advanced Navigation for Menus
if (is_admin()) {

    function ale_inject_archives_menu_meta_box() {
        add_meta_box('ale-nav-advanced', esc_html__( 'Advanced Navigation', 'ale' ), 'ale_wp_nav_menu_archives_meta_box', 'nav-menus', 'side', 'default');
    }
    add_action( 'admin_head-nav-menus.php', 'ale_inject_archives_menu_meta_box');


    function ale_wp_nav_menu_archives_meta_box() {

        /* get custom post types with archive support */
        $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

        /* hydrate the necessary object properties for the walker */
        foreach (
            $post_types as &$post_type) {
            $post_type->classes = array();
            $post_type->type = $post_type->name;
            $post_type->object_id = $post_type->name;
            $post_type->title = $post_type->labels->name . ' ' . esc_html__('Archive', 'ale');
            $post_type->object = 'ale-archive';

            $post_type->menu_item_parent = null;
            $post_type->url = null;
            $post_type->xfn = null;
            $post_type->db_id = null;
            $post_type->target = null;
            $post_type->attr_title = null;
        }

        $walker = new Walker_Nav_Menu_Checklist(array());
        ?>
<div id="ale-archive" class="posttypediv">
	<div id="tabs-panel-ale-archive" class="tabs-panel tabs-panel-active">
		<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
			<?php
                    echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array('walker' => $walker));
                    ?>

		</ul>
	</div><!-- /.tabs-panel -->
</div>
<p class="button-controls">
	<span class="add-to-menu">

		<input type="submit" class="button-secondary submit-add-to-menu" value="<?php esc_html_e('Add to Menu','ale'); ?>" name="add-ctp-archive-menu-item" id="submit-ale-archive" />
	</span>
</p>
<?php
    }
}

/**
 * Add Needed Post Types
 */
function ale_init_post_types() {
    if (function_exists('aletheme_get_post_types')) {
        foreach (aletheme_get_post_types() as $type => $options) {
            ale_add_post_type($type, $options['config'], $options['singular'], $options['multiple']);
        }
    }
}
add_action('init', 'ale_init_post_types');

/**
 * Add Needed Taxonomies
 */
function ale_init_taxonomies() {
    if (function_exists('aletheme_get_taxonomies')) {
        foreach (aletheme_get_taxonomies() as $type => $options) {
            ale_add_taxonomy($type, $options['for'], $options['config'], $options['singular'], $options['multiple']);
        }
    }
}
add_action('init', 'ale_init_taxonomies');


/**
 * Register Post Type Wrapper
 * @param string $name
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function ale_add_post_type($name, $config, $singular = 'Entry', $multiple = 'Entries') {
    if (!isset($config['labels'])) {
        $config['labels'] = array(
            'name' => $multiple,
            'singular_name' => $singular,
            'not_found'=> 'No ' . $multiple . ' Found',
            'not_found_in_trash'=> 'No ' . $multiple . ' found in Trash',
            'edit_item' => 'Edit ', $singular,
            'search_items' => 'Search ' . $multiple,
            'view_item' => 'View ', $singular,
            'new_item' => 'New ' . $singular,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New ' . $singular,
        );
    }

    register_post_type($name, $config);
}

/**
 * Register taxonomy wrapper
 * @param string $name
 * @param mixed $object_type
 * @param array $config
 * @param string $singular
 * @param string $multiple
 */
function ale_add_taxonomy($name, $object_type, $config, $singular = 'Entry', $multiple = 'Entries') {

    if (!isset($config['labels'])) {
        $config['labels'] = array(
            'name' => $multiple,
            'singular_name' => $singular,
            'search_items' =>  'Search ' . $multiple,
            'all_items' => 'All ' . $multiple,
            'parent_item' => 'Parent ' . $singular,
            'parent_item_colon' => 'Parent ' . $singular . ':',
            'edit_item' => 'Edit ' . $singular,
            'update_item' => 'Update ' . $singular,
            'add_new_item' => 'Add New ' . $singular,
            'new_item_name' => 'New ' . $singular . ' Name',
            'menu_name' => $singular,
        );
    }

    register_taxonomy($name, $object_type, $config);
}

/**
 * Sets up a custom post type to attach image to.  This allows us to have
 * individual galleries for different uploaders.
 */

if ( ! function_exists( 'optionsframework_mlu_init' ) ) {
    function optionsframework_mlu_init () {
        register_post_type( 'optionsframework', array(
            'labels' => array(
                'name' => __( 'Theme Options Media', 'options_framework_theme' ),
            ),
            'public' => true,
            'show_ui' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => false,
            'supports' => array( 'title', 'editor' ),
            'query_var' => false,
            'can_export' => true,
            'show_in_nav_menus' => false,
            'public' => false
        ) );
    }
}

/**
 * Register Sliders post type to make it queriable
 */
if(class_exists('Aletheme_Sliders')){
    function aletheme_sliders_register_post_type() {
        ale_add_post_type(Aletheme_Sliders::POST_TYPE, array(
            'public' => false,
        ), 'Aletheme Slider', 'Aletheme Sliders');
    }
    add_action( 'init', 'aletheme_sliders_register_post_type' );
}



/**
 * Add post types that are used in the theme
 *
 * @return array
 */
function aletheme_get_post_types() {
    return array(
        'galleries' => array(
            'config' => array(
                'public' => true,
                'menu_position' => 20,
                'has_archive'   => true,
                'supports'=> array(
                    'title',
                    'editor',
                    'comments',
                    'thumbnail',
                ),
                'show_in_nav_menus'=> true,
            ),
            'singular' => 'Gallery',
            'multiple' => 'Galleries',
            'columns'    => array(
                'first_image',
            )
        ),
    );
}



/**
 * Add taxonomies that are used in theme
 *
 * @return array
 */
function aletheme_get_taxonomies() {
    return array(
        'gallery-category'    => array(
            'for'        => array('galleries'),
            'config'    => array(
                'sort'        => true,
                'args'        => array('orderby' => 'term_order'),
                'hierarchical' => true,
            ),
            'singular'    => 'Category',
            'multiple'    => 'Categories',
        ),
    );
}


//Check if Plugin is Active
function ale_check_plugin_active($data){
    return is_plugin_active( $data );
}


function ale_theme_add_admin_menu() {
    add_theme_page( esc_html__('Demo Install', 'ale'), esc_html__('Demo Install', 'ale'), 'edit_posts', 'aletheme_theme_demos','ale_theme_demos');
}
add_action('admin_menu', 'ale_theme_add_admin_menu', 1);