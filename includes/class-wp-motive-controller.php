<?php
namespace Wp_Motive;
/**
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      10-Dic-2019
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * This class define the functionality of the Plugin.
 *
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Controller
{
    /**
     * Update a Plugin Option with the given name and value.
     *
     * @version 1.0.0
     * @since 04-Dic-2019
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>
     *
     * @return json encoded data with the result.
     */
    public function update_options()
    {
        $result = [
            "status" => "failed",
            "code" => 401
        ];
        // Check Nonce
        $data = isset($_POST) ? $_POST : null;
        if( $data !== null ){
            $option_name = sanitize_text_field(trim($_POST["option_name"]));
            $option_value = sanitize_text_field(trim($_POST["option_value"]));
            // Check for the nonce key, if not correct 'check_admin_referer' will die the execution.
            check_admin_referer("wp_motive_nonce_update_options", "security");

            update_option( $option_name, $option_value);
            $result = [
                "status" => "ok",
                "code" => 200
            ];
            return wp_send_json_success($result);
        }

        return wp_send_json_error($result);
    }

    public function save_loaded_table_time()
    {
        $result = [
            "status" => "failed",
            "code" => 401
        ];
        // Check Nonce
        $data = isset($_POST) ? $_POST : null;
        if( $data !== null ){
            $date = date_create();
            $unixTimeStamp = date_timestamp_get( $date );
            echo $date->getTimestamp();
            // Check for the nonce key, if not correct 'check_admin_referer' will die the execution.
            check_admin_referer("wp_motive_nonce_update_options", "security");
            $this->save_array_option_by_key( "wp_motive_request_period", "start_datetime", $unixTimeStamp );

            $result = [
                "status" => "ok",
                "code" => 200
            ];
            return wp_send_json_success($result);
        }

        return wp_send_json_error($result);
    }

    /**
     * Retrieve an option value already serialized and convert it to an array. Update
     * the array value to the given one. This only work at the first level of the array.
     * If the array contains more nested arrays then some other method should be use.
     *
     * @since 08-Dic-2019
     * @version 1.0.0
     * @author Israel Barragan (Reedyseth)
     *
     * @param $_option_name
     * @param $_key
     * @param $_value
     */
    public function save_array_option_by_key( $_option_name, $_key, $_value )
    {
        $option = unserialize( get_option( $_option_name ) ) ;
        $option[$_key] = $_value;
        update_option( $_option_name, serialize( $option ) );
    }

    /**
     * Save a local users information on the database to retrieve it instead of the endpoint
     *
     * @version 1.0.0
     * @since 05-Dic-2019
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>

     * @return json encoded data with the result.
     */
    public function cache_endpoint_data()
    {
        $result = [
            "status" => "failed",
            "code" => 401
        ];
        // Check Nonce
        $data = isset($_POST) ? $_POST : null;
        if( $data !== null ){
            $users_data = sanitize_text_field(trim($_POST["users_data"]));
            // Check for the nonce key, if not correct 'check_admin_referer' will die the execution.
            check_admin_referer("wp_motive_nonce_update_options", "security");

            update_option( "wp_motive_cache_users_data", $users_data );
            $result = [
                "status" => "ok",
                "code" => 200
            ];
            return wp_send_json_success($result);
        }

        return wp_send_json_error($result);
    }
    /**
     * Reload users data already cache on the database.
     *
     * @version 1.0.0
     * @since 06-Dic-2019
     * @author Israel Barragan (Reedyseth) <reedyseth@gmail.com>

     * @return json encoded data with the result.
     */
    public function reload_cache_data()
    {
        $result = [
            "status" => "failed",
            "code" => 401
        ];
        // Check Nonce
        $data = isset($_POST) ? $_POST : null;
        if( $data !== null ){
            // Check for the nonce key, if not correct 'check_admin_referer' will die the execution.
            check_admin_referer("wp_motive_nonce_update_options", "security");
            //sleep(10);
            $users_data = stripslashes( get_option( "wp_motive_cache_users_data" ) );
            $result = [
                "status" => "ok",
                "code" => 200,
                "users_data" => $users_data
            ];
            return wp_send_json_success($result);
        }

        return wp_send_json_error($result);
    }

    public function check_loaded_limit()
    {
        $result = [
            "status" => "failed",
            "code" => 401
        ];
        // Check Nonce
        $data = isset($_POST) ? $_POST : null;
        if( $data !== null ){
            // Check for the nonce key, if not correct 'check_admin_referer' will die the execution.
            check_admin_referer("wp_motive_nonce_update_options", "security");
            //sleep(10);
            $wp_motive_request_period = unserialize( get_option( "wp_motive_request_period" ) );
            $on_time = false;
            $server_output = null;
            $date = date_create();
            $unixTimeStamp = date_timestamp_get( $date );
            // Check difference in time
            $time_diff = $unixTimeStamp - $wp_motive_request_period["start_datetime"];

            if( $time_diff <= $wp_motive_request_period["time"] ) {
                $on_time = true;
            }
            elseif ( $time_diff > $wp_motive_request_period["time"] )
            {
                // Let us use cURL to avoid sending back only the limit result and make another Ajax request on
                // the frontend
                if( function_exists( "curl_init" ) ){
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_URL, 'https://miusage.com/v1/challenge/1/' );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    $server_output = curl_exec( $ch );
                }
            }

            $result = [
                "status" => "ok",
                "code" => 200,
                "on_time" => $on_time,
                "users" => $server_output,
            ];
            return wp_send_json_success($result);
        }

        return wp_send_json_error($result);
    }
}
