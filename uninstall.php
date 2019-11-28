<?php
namespace Wp_Motive;
/**
 * Fired when the plugin is uninstalled.
 *
  *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 *
 * @package    Wp_Motive
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
