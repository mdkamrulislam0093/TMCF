<?php
/**
 * Plugin Name: TM Custom Fields
 * Plugin URI: #
 * Description: TMCF will help you to easily add custom fields in single post or page or custom post type.
 * Version: 1.0
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


include_once TMG_PATH .'/settings/settings.php';
include_once TMG_PATH .'/fields/main.php';

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
	}

	function load_textdomain() {
    	load_plugin_textdomain( 'tm-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

}

TMCF::get_instance();
$settings = TM_Settings::get_instance();
TMCF_Fields::get_instance($settings->getPostTypes());

