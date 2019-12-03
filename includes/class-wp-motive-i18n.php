<?php
namespace Wp_Motive;
/**
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.                                                                                                      *
 * @link       http://behstant.com/blog/sobre-mi/
 * @since      1.0.0
 * @since      29-Nov-2019
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_i18n {
    /**
     * Load the plugin text domain for translation.
     *                                                                                                                                           * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'wp-motive',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }


}
