<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor
{
	const MINIMUM_ELEMENTOR_VERSION = '3.16.4';
	const MINIMUM_PHP_VERSION = '7.4';
	private static $_instance = null;

	/**
	 * Instance
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 */

	public function __construct()
	{

		add_action( 'after_setup_theme', [ $this, 'init' ] );

	}

	/**
	 * Initialize
	 */

	public function init(){

		// Check if Elementor installed and activated

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check for required Elementor version

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add actions

		require_once( __DIR__ . '/class-ale-elementor-helper.php' );

		add_action( 'elementor/elements/categories_registered', 'Ale_Elementor_Helper::categories_registered' );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

	}


	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required Elementor version.
	 */

	public function admin_notice_minimum_elementor_version() {

		$message = esc_html__('Theme requires Elementor version','ale').' <strong>'. self::MINIMUM_ELEMENTOR_VERSION .'</strong> '.esc_html__('or greater.','ale');
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required PHP version.
	 */

	public function admin_notice_minimum_php_version() {

		$message = esc_html__('Theme requires PHP version','ale') . ' <strong>'. self::MINIMUM_PHP_VERSION .'</strong> '. esc_html__('or greater.','ale');
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 * Include widgets files and register them
	 */

	public function init_widgets() {

		$widgets = [
			'alekids_shop',
			'alekids_top_screen',
			'alekids_step',
			'alekids_title',
			'alekids_button',
			'alekids_images_grid',
			'alekids-contact_icon',
			'alekids_single-image',
			'alekids_bloglist',
			'alekids_testimonials',
			'alekids_gallerylist',
			'alekids_form',
			'alekids_socialbox',
			'alekids_video',
			'alekids_counter',
			'alekids_timeline',
			'alekids_team',
			
		];

		foreach( $widgets as $widget ){

			require_once( __DIR__ . '/class-ale-elementor-widget-'. $widget .'.php' );

			$class = '\Ale_Elementor_Widget_'. str_replace( ' ', '_', ucfirst(str_replace( '-', ' ', $widget )));
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );

		}

	}

}

Ale_Elementor::instance();