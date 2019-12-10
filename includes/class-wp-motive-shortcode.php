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
        return '<h1>WP Motive Shortcode Test</h1>';
    }
}
