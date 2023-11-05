<?php
/**
 * Plugin Name: TM Custom Fields Lite
 * Plugin URI: #
 * Description: TMCF will help you to easily add custom fields (Text, Number, Tel, Email, Select, Checkbox, Radio, Gallery, Colors ) in single post or page or custom post type.
 * Version: 3.0
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * Author: Kamrul Islam
 * Author URI: #
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: tmcf
 * Domain Path: /languages
 */


//Avoiding Direct File Access
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


define('TMG_FILE', __FILE__);
define('TMG_PATH', plugin_dir_path(__FILE__));
define('TMG_URL', plugin_dir_url(__FILE__));


include_once TMG_PATH .'/inc/settings.php';
include_once TMG_PATH .'/inc/fields.php';

class TMCF {

	private static $instance;

	public static function get_instance(){
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct(){
		add_action( 'plugins_loaded', [$this, 'load_textdomain'] );
		add_shortcode( 'tmcf', [$this, 'frontend_display'] );
	}

	public function frontend_display($atts) {
		$atts = shortcode_atts( array(
			'id' => get_the_ID(),
			'key' => ''
		), $atts, 'tmcf' );

		if ( !isset($atts['key']) && empty($atts['key']) ) {
			return;
		}

		if ( !isset($atts['id']) && empty($atts['id']) ) {
			return;
		}

		$data = empty(get_post_meta( $atts['id'], 'display_tmcf', true )) ? [] : json_decode(get_post_meta( $atts['id'], 'display_tmcf', true ), true);		

		if ( !empty( $data[$atts['key']] ) ) {
			return $data[$atts['key']];
		}

		return;
	}

	function load_textdomain() {
    	load_plugin_textdomain( 'tm-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}

TMCF::get_instance();
$settings = TM_Settings::get_instance();
TMCF_Fields::get_instance($settings->getPostTypes());

