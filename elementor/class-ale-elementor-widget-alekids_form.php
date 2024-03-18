<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Alekids_Form extends \Elementor\Widget_Base {

  public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'alekids-button_elementor',ALE_PLUGIN_URL. '/elementor/js/widget-alekids-button_elementor.js', [ 'elementor-frontend' ], '1.0', true );
			return [ 'alekids-button_elementor' ];
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
					'field' => 'name',
					'type' => $this->get_title() .'<br />'. esc_html__( "Name Placeholder", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'email',
					'type' => $this->get_title() .'<br />'. esc_html__( "Email Placeholder", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'phone',
					'type' => $this->get_title() .'<br />'. esc_html__( "Phone Placeholder", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'submit',
					'type' => $this->get_title() .'<br />'. esc_html__( "Submit Placeholder", "alekids" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'subject',
					'type' => $this->get_title() .'<br />'. esc_html__( "Mail Subject", "alekids" ),
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
		return 'alekids_form';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Contact Form', 'alekids' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-form-horizontal';
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
			'receive',
			[
				'label' => esc_html__( "Email to receive messages", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'subject',
			[
				'label' => esc_html__( "Mail Subject", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Message from contact page', 'ale' ),
			]
        );
				
		$this->add_control(
			'name',
			[
				'label' => esc_html__( "Name Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Name *', 'ale' ),
			]
        );

		$this->add_control(
			'email',
			[
				'label' => esc_html__( "Email Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Email *', 'ale' ),
			]
        );

		$this->add_control(
			'phone',
			[
				'label' => esc_html__( "Phone Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Phones', 'ale' ),
			]
        );

		$this->add_control(
			'message',
			[
				'label' => esc_html__( "Message Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Comment *', 'ale' ),
			]
        );

		$this->add_control(
			'submit',
			[
				'label' => esc_html__( "Submit Value", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Submit', 'ale' ),
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

<div class="alekids_contact">

	<a name="success"></a>

	<?php if (isset($_GET['success'])) { ?>
	<p class="success"><?php echo esc_html_e("Thank you for your message!", "ale"); ?></p>
	<?php } ?>

	<?php if (isset($error) && isset($error['msg'])) {?>
	<p class="error"><?php echo esc_attr($error['msg']); ?></p>
	<?php } ?>

	<form method="post" action="<?php echo esc_url(get_the_permalink()); ?>" class="alekids_contact_form">

		<div class="form_line">
			<input name="contact[name]" type="text" class="item_field" placeholder="<?php echo esc_attr($settings['name']); ?>" value="" required="required" id="contact-form-name" />
			<input name="contact[email]" type="email" class="item_field" placeholder="<?php echo esc_attr($settings['email']); ?>" value="" required="required" id="contact-form-email" />
			<input name="contact[phone]" type="phone" class="item_field" placeholder="<?php echo esc_attr($settings['phone']); ?>" value="" id="contact-form-phone" />
		</div>

		<div class="form_line">
			<textarea name="contact[message]" class="item_field" placeholder="<?php echo esc_attr($settings['message']); ?>" id="contact-form-message" required="required"></textarea>
		</div>

		<div class="form_line submit_line">
			<div class="alekids_button">
				<div class="container">
					<svg class="alekids_dashed">
						<rect x="5px" y="5px" rx="25px" ry="25px" width="0" height="0"></rect>
					</svg>
					<span><input type="submit" class="submit submit_button" value="<?php echo esc_attr($settings['submit']); ?>" /></span>
				</div>
			</div>
		</div>

		<input name="contact[receive]" type="hidden" value="<?php echo esc_attr($settings['receive']); ?>" />
		<input name="contact[subject]" type="hidden" value="<?php echo esc_attr($settings['subject']); ?>" />

		<?php wp_nonce_field(); ?>

	</form>
</div>

<?php 


	}

}