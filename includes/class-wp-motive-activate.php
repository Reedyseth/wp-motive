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

    /**
     *
     * @since    1.0.0
     */
    public static function activate() {
        $logger = new Wp_Motive_Logger();
        $logger->log("activate() function executed.!!\n");
    }

}