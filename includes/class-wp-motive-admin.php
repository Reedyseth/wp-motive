<?php
namespace Wp_Motive;
use const stcr\SLUG;

/**
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      29-Nov-2019
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * This class define the functionality of the Plugin in the Admin area.
 *
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Admin
{
    protected $hooks = null;
    private $slug = "";
    private $resources = null;
    private $data_schedule = null;

    public function __construct($slug, $plugin_url, $plugin_version)
    {
        $this->hooks = new Wp_Motive_Hooks();
        $this->resources = new Wp_Motive_Resources($plugin_url, $plugin_version);
        $this->make_admin_hooks();
        $this->hooks->load_hooks();
        $this->slug = $slug;
    }

    private function make_admin_hooks()
    {
        $this->hooks->add_actions("admin_menu", $this, "admin_menu");
        $this->hooks->add_actions("in_admin_header", $this, "display_admin_header");
        $this->hooks->add_actions("admin_enqueue_scripts", $this->resources, "enqueue_admin_scripts");
        $this->hooks->add_actions("admin_enqueue_scripts", $this->resources, "enqueue_admin_styles");
        $this->hooks->add_actions("wp_ajax_wp_motive_update_options", $this, "update_options");
        $this->hooks->add_actions("wp_ajax_wp_motive_cache_data", $this, "cache_endpoint_data");
        $this->hooks->add_actions("wp_ajax_wp_motive_load_cache_data", $this, "reload_cache_data");
        $this->hooks->add_actions("wp_ajax_wp_motive_loaded_table_time", $this, "save_loaded_table_time");
        $this->hooks->add_actions("wp_ajax_wp_motive_check_loaded_limit", $this, "check_loaded_limit");
    }

    public function admin_menu()
    {
        if(current_user_can("manage_options")){
            $page_title = "Awesome Motive Challenge";
            $menu_title = "WP Motive";
            $capability = "manage_options";
            $function   = array($this,"admin_page");
            $icon_url   = "dashicons-smiley";
            $position   = 26;
            $parent_slug= "wp_motive_options";

            add_menu_page( $page_title, $menu_title, $capability, $parent_slug,
                $function, $icon_url, $position );
        }
    }

    public function display_admin_header()
    {
        $current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        /**
         * Make Sure that the Admin header is only visible on the WP Motive Page.
         */
        if( ! $current_page === "wp_motive_options" ){
            return false;
        }
        echo "
            <div id='wpbody-content'>
                <div class='wrap' id='wp-mail-smtp'>
                    <div class='wp-mail-smtp-page-title'>                                                                                                                                            
                                <a href='admin.php?page=wp_motive_options' class='tab active'>         
                                        General</a>                                                                                                                                            
                                <a href='#' class='tab'>                   
                                        This could be another Tab</a>
                    </div>";
    }

    public function admin_page(){

        $update_nonce = wp_create_nonce( "wp_motive_nonce_update_options" );
        $time_period  = unserialize( get_option("wp_motive_request_period") );
        $time         = $time_period["time"];
        $start_datetime      = $time_period["start_datetime"];

        echo "<div class='wp-mail-smtp-page-content'>
                <form method='POST' action='' autocomplete='off' class='wp-motive-form'>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>                                                                    
                                <h2>" . __("Ajax Endpoint","wp-motive") ."</h2>
                                <p class='desc'>
                                    " . __("This information is fetched from https://miusage.com/v1/challenge/1/","wp-motive") ."
                                </p>
                        </div>
                    </div>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>
                            <div class='reload-data-container'>
                                <input type='hidden' name='wp_motive_nonce_update_options' value='" . $update_nonce ."'/>
                                <input type='hidden' name='wp_motive_start_datetime' value='" . esc_attr( $start_datetime ) ."'/>
                                <input type='hidden' name='wp_motive_data_loaded_status' value='" . esc_attr( get_option("wp_motive_data_loaded_status") ) ."'/>
                                <button class='wp-mail-smtp-btn wp-mail-smtp-btn-md wp-mail-smtp-btn-orange btn-reload-data'>
                                    " . __("Reload","wp-motive") ."
                                </button>
                                <span class='wp-motive-notification'></span>
                            </div>
                            
                            <table class='wp-motive-table-data'>
                                <thead>
                                    <tr>
                                        <th>" . __("ID","wp-motive") ."</th>
                                        <th>" . __("First Name</","wp-motive") ."</th>
                                        <th>" . __("Last Name","wp-motive") ."</th>
                                        <th>" . __("Email","wp-motive") ."</th>
                                        <th>" . __("Date","wp-motive") ."</th>
                                    </tr>
                                </thead>
                                <tbody><tr><td colspan='5'>" . __("No data to show","wp-motive") ."</td></tr></tbody>
                            </table>                                                                 
                        </div>
                    </div>
                </form>
              </div>"; // Closes <div class='wp-mail-smtp-page-content'>
            echo "</div>"; // Closes <div class="wrap" id="wp-mail-smtp">
        echo "</div>"; // Closes <div id="wpbody-content">
    }

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
