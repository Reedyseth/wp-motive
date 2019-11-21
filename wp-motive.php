<?php

/**
 * This is the plugin example for the "Developer Applicant Challenge" as requested on the website
 *
 * https://awesomemotive.com/career/developer-applicant-challenge/
 *
 * @link              http://behstant.com/blog
 * @since             1.0.0
 * @package           Wp_Motive
 *
 * @wordpress-plugin
 * Plugin Name:       WP Awesome Request
 * Plugin URI:        https://awesomemotive.com/plugin-test
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            reedyseth
 * Author URI:        http://behstant.com/blog
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-motive
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_MOTIVE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-motive-activator.php
 */
function activate_wp_motive() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-motive-activator.php';
	Wp_Motive_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-motive-deactivator.php
 */
function deactivate_wp_motive() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-motive-deactivator.php';
	Wp_Motive_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_motive' );
register_deactivation_hook( __FILE__, 'deactivate_wp_motive' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-motive.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_motive() {

	$plugin = new Wp_Motive();
	$plugin->run();

}
run_wp_motive();
