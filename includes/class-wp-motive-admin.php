<?php
namespace Wp_Motive;
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

    public function __construct()
    {
        $this->hooks = new Wp_Motive_Hooks();
        $this->make_admin_hooks();
        $this->hooks->load_hooks();
    }

    private function make_admin_hooks()
    {
        $this->hooks->add_actions("admin_menu", $this, "admin_menu");
    }

    public function admin_menu()
    {
        if(current_user_can("manage_options")){
            $page_title = "Awesome Motive Challenge";
            $menu_title = "WP Motive";
            $capability = "manage_options";
            $function   = "";
            $icon_url   = "dashicons-smiley";
            $position   = 26;
            $parent_slug= "wp_motive_subscriptions";

            add_menu_page( $page_title, $menu_title, $capability, $parent_slug,
                $function, $icon_url, $position );
        }
    }
}