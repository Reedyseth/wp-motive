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

    public function __construct()
    {
        // Get Plugin Options
        // Delete Plugin Options
    }
}

$instance = new Wp_Motive_Uninstall();
