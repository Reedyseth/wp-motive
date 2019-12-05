<?php
namespace Wp_Motive;
/**
 * Fired during plugin activation
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      29-Nov-2019
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Activate {
    private static $options = null;
    /**
     *
     * @since    1.0.0
     */
    public static function activate() {
        $options_prefix = 'wp_motive_';
        /**
         * Define the plugin default options
         */
        $options = array(
            $options_prefix . "request_period" => "3600",
            $options_prefix . "data_loaded_status" => "no"
        );

        $logger = new Wp_Motive_Logger();
        $logger->log("activate() function executed.!!\n");

        /**
         * Create the options in WordPress
         */
        foreach ( $options as $key => $value ){
            add_option( $key, $value );
        }
    }

}
