<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://developer.wasakredit.se
 * @since      1.0.0
 *
 * @package    Wasa_Kredit_Checkout
 * @subpackage Wasa_Kredit_Checkout/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wasa_Kredit_Checkout
 * @subpackage Wasa_Kredit_Checkout/public
 * @author     Wasa Kredit <ehandel@wasakredit.se>
 */
class Wasa_Kredit_Checkout_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/wasa-kredit-checkout-public.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/wasa-kredit-checkout-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_register_script(
			'wasa-kredit-monthly-cost',
			WASA_KREDIT_CHECKOUT_PLUGIN_URL . '/assets/js/monthly-cost-widget.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		wp_localize_script(
			'wasa-kredit-monthly-cost',
			'wasaKreditParams',
			array(
				'wasa_kredit_update_monthly_widget_url'   => WC_AJAX::get_endpoint( 'wasa_kredit_update_monthly_widget' ),
				'wasa_kredit_update_monthly_widget_nonce' => wp_create_nonce( 'wasa_kredit_update_monthly_widget' ),
				'thousand_separator'                      => wc_get_price_thousand_separator(),
				'decimal_separator'                       => wc_get_price_decimal_separator(),
			)
		);

		wp_enqueue_script( 'wasa-kredit-monthly-cost' );
	}
}
