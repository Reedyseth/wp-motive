<?php
/**
 * This is the plugin example for the "Developer Applicant Challenge" as requested on the website
 * https://awesomemotive.com/career/developer-applicant-challenge/
 *
 * @link              http://behstant.com/blog
 * @since             1.0.0
 * @package           Wp_Motive
 * @since      29-Nov-2019
 *
 * @wordpress-plugin
 * Plugin Name:       Awesome Motive Challenge
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

if( file_exists( dirname( __FILE__ ) ) . '/vendor/autoload.php' ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'VERSION','1.0.0' );
/**
 * The slug of the plugin, on this case wp-motive
 */
define( 'SLUG', "wp-motive" );
/**
 * The code that runs during plugin activation.
 */
function activate_wp_motive() {
    Wp_Motive\Wp_Motive_Activate::activate();
}
//
///**
// * The code that runs during plugin deactivation.
// */
function deactivate_wp_motive() {
	Wp_Motive\Wp_Motive_Deactivate::deactivate();
}
//
register_activation_hook( __FILE__, 'activate_wp_motive' );
register_deactivation_hook( __FILE__, 'deactivate_wp_motive' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_wp_motive() {

    $plugin = new Wp_Motive\Wp_Motive();
    $plugin->run();
}
run_wp_motive();