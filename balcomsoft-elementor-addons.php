<?php
/**
 * Plugin Name: Balcomsoft Elementor Addons
 * Author: Balcomsoft
 * Author URI: https://balcomsoft.com/
 * Description: Balcomsoft WordPress Elementor Addons Plugin.
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.1.0
 * Text Domain: bsoft-elementor
 * Domain Path: /languages
 *
 * @author  Balcomsoft
 * @package Bsoft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BSOFT_ELEMENTOR_VERSION', '1.1.0.' );
define( 'BSOFT_ELEMENTOR_PATH', dirname( __FILE__ ) );
define( 'BSOFT_ELEMENTOR_FILES_PATH', plugins_url( '/', __FILE__ ) );

/**
 * Checking Elementor plugin status
 *
 * Check when the site doesn't have Elementor installed or activated.
 */
if ( ! function_exists( 'bsoft_elementor_status' ) ) {
	/**
	 * Enqueue redux styles.
	 */
	function bsoft_elementor_status() {
		$elementor_path    = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $elementor_path ] );
	}
}

if ( ! class_exists( 'Bsoft_Elementor_Widgets' ) ) {
	include BSOFT_ELEMENTOR_PATH . '/includes/class-bsoft-elementor-widgets.php';
}
require BSOFT_ELEMENTOR_PATH . '/includes/ad-banner.php';

