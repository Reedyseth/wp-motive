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
                                <input type='hidden' name='wp_motive_request_period' value='" . esc_attr( get_option("wp_motive_request_period") ) ."'/>
                                <input type='hidden' name='wp_motive_request_status' value='" . esc_attr( get_option("wp_motive_request_status") ) ."'/>
                                <button type='submit' class='wp-mail-smtp-btn wp-mail-smtp-btn-md wp-mail-smtp-btn-orange btn-reload-data'>
                                    " . __("Reload","wp-motive") ."
                                </button>
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
}
