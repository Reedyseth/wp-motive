<?php
namespace Wp_Motive;
/**
 * This class define the functionality of the Plugin in the Admin area.
 *
 * @class Wp_Motive
 * @version    1.0.0
 * @since      29-Nov-2019
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog
 */
class Wp_Motive_Admin extends Wp_Motive_Controller
{
    protected $hooks = null;
    private $slug = "";
    private $resources = null;

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
        $this->hooks->add_actions("wp_ajax_wp_motive_get_options", $this, "get_options");
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
        if(current_user_can("manage_options")) {
            $current_page = isset($_GET['page']) ? $_GET['page'] : '';
            $array_pages = array(
                "wp_motive_options" => __('WP Motive Options', 'wp-motive'),
                "wp_motive_settings" => __('Settings', 'wp-motive'),
            );
            /**
             * Make Sure that the Admin header is only visible on the WP Motive Page.
             */
            if (!array_key_exists($current_page, $array_pages)) {
                return false;
            }
            echo "
            <div id='wpbody-content'>
                <div class='wrap' id='wp-mail-smtp'>
                    <div class='wp-mail-smtp-page-title'>                                                                                                                                            
                                <a href='admin.php?page=wp_motive_options' class='tab active'>         
                                        " . $array_pages['wp_motive_options'] . "</a>                                                                                                                                            
                                <a href='#' class='tab'>                   
                                        " . $array_pages['wp_motive_settings'] . "</a>
                    </div>";
        }
    }

    public function admin_page()
    {
        if (current_user_can("manage_options")) {
            $update_nonce = wp_create_nonce("wp_motive_nonce_update_options");
            $time_period = unserialize(get_option("wp_motive_request_period"));
            $time = $time_period["time"];
            $start_datetime = $time_period["start_datetime"];

            echo "<div class='wp-mail-smtp-page-content'>
                <form method='POST' action='' autocomplete='off' class='wp-motive-form'>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>                                                                    
                                <h2>" . __("Ajax Endpoint", "wp-motive") . "</h2>
                                <p class='desc'>
                                    " . __("This information is fetched from https://miusage.com/v1/challenge/1/", "wp-motive") . "
                                </p>
                        </div>
                    </div>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>
                            <div class='reload-data-container'>
                                <input type='hidden' name='wp_motive_nonce_update_options' value='" . $update_nonce . "'/>
                                <input type='hidden' name='wp_motive_users_data_override' value='" . esc_attr( get_option("wp_motive_users_data_override") ) ."'/>
                                <input type='hidden' name='wp_motive_start_datetime' value='" . esc_attr($start_datetime) . "'/>
                                <input type='hidden' name='wp_motive_data_loaded_status' value='" . esc_attr(get_option("wp_motive_data_loaded_status")) . "'/>
                                <button class='wp-mail-smtp-btn wp-mail-smtp-btn-md wp-mail-smtp-btn-orange btn-reload-data'>
                                    " . __("Reload", "wp-motive") . "
                                </button>
                                <span class='wp-motive-notification'></span>
                            </div>
                            
                            <table class='wp-motive-table-data'>
                                <thead>
                                    <tr>
                                        <th>" . __("ID", "wp-motive") . "</th>
                                        <th>" . __("First Name", "wp-motive") . "</th>
                                        <th>" . __("Last Name", "wp-motive") . "</th>
                                        <th>" . __("Email", "wp-motive") . "</th>
                                        <th>" . __("Date", "wp-motive") . "</th>
                                    </tr>
                                </thead>
                                <tbody><tr><td colspan='5'>" . __("No data to show", "wp-motive") . "</td></tr></tbody>
                            </table>                                                                 
                        </div>
                    </div>
                </form>
              </div>"; // Closes <div class='wp-mail-smtp-page-content'>
            echo "</div>"; // Closes <div class="wrap" id="wp-mail-smtp">
            echo "</div>"; // Closes <div id="wpbody-content">
        }
    }
}
