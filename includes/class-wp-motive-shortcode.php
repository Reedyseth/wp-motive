<?php
namespace Wp_Motive;
/**
 * Takes care of the Shortcodes.
 *
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive_Shortcode
{
    private $short_codes = [];

    public function __construct()
    {
        add_action( "init", array( $this, "register_shortcodes" ) );
    }

    public function register_shortcodes()
    {
        add_shortcode( "motive-users-data", array($this, "display_users_data") );
    }

    public function display_users_data()
    {
        $update_nonce = wp_create_nonce( "wp_motive_nonce_update_options" );
        $time_period  = unserialize( get_option("wp_motive_request_period") );
        $start_datetime      = $time_period["start_datetime"];

        $output = "<div class='wp-mail-smtp-page-content'>
                <form method='POST' action='' autocomplete='off' class='wp-motive-form'>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>                                                                    
                                <h2>" . __("Ajax Endpoint","wp-motive") ."</h2>
                        </div>
                    </div>
                    <div class='wp-mail-smtp-setting-row wp-mail-smtp-setting-row-content wp-mail-smtp-clear section-heading'>
                        <div class='wp-mail-smtp-setting-field'>
                            <div class='reload-data-container'>
                                <input type='hidden' name='wp_motive_nonce_update_options' value='" . $update_nonce ."'/>
                                <input type='hidden' name='wp_motive_users_data_override' value='" . esc_attr( get_option("wp_motive_users_data_override") ) ."'/>
                                <input type='hidden' name='wp_motive_users_data_override' value='" . esc_attr( get_option("wp_motive_users_data_override") ) ."'/>
                                <input type='hidden' name='wp_motive_start_datetime' value='" . esc_attr( $start_datetime ) ."'/>
                                <input type='hidden' name='wp_motive_data_loaded_status' value='" . esc_attr( get_option("wp_motive_data_loaded_status") ) ."'/>
                                <div class='wp-motive-notification'></div>
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
        $output .= "</div>"; // Closes <div class="wrap" id="wp-mail-smtp">
        $output .= "</div>"; // Closes <div id="wpbody-content">

        return $output;
    }
}
