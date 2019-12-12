<?php
namespace Wp_Motive;
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @version    1.0.0
 * @since      29-Nov-2019
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog
 *
 */
class Wp_Motive_Activate {

    public static function activate() {
        $options_prefix = 'wp_motive_';
        /**
         * Define the plugin default options
         */
        $options = array(
            "request_period" => serialize( array(
                "time" => 3600,
                "start_datetime" => 0,
            ) ),
            "data_loaded_status" => "no",
            "cache_users_data" => "",
            "users_data_override" => "no", // Use to force the information reload
        );
        /**
         * Create the options in WordPress
         */
        foreach ( $options as $key => $value ){
            add_option( $options_prefix . $key, $value );
        }
    }

}
