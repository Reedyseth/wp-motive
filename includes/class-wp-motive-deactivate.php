<?php
namespace Wp_Motive;
/**
 * Fired during plugin deactivation
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Deactivate {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        $logger = new Logger();
        $logger->log("deactivate() function executed.!!\n");
    }

}