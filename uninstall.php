<?php
namespace Wp_Motive;
/**
 * Fired when the plugin is uninstalled.
 *
  *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      29-Nov-2019
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 *
 * @package    Wp_Motive
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete Plugin Options
class Wp_Motive_Uninstall
{
    private $options;
    private $options_prefix = 'wp_motive_';

    public function __construct()
    {
        // Get Plugin Options

    }

    public function delete_options()
    {
        // Delete Plugin Options
        delete_option( $this->options_prefix . 'request_period' );
        delete_option( $this->options_prefix . 'data_loaded_status' );
        delete_option( $this->options_prefix . 'cache_users_data' );
        delete_option( $this->options_prefix . 'users_data_override' );
    }
}

$instance = new Wp_Motive_Uninstall();
$instance->delete_options();
