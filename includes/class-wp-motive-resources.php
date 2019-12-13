<?php
namespace Wp_Motive;
/**
 *
 * Takes care of the Script and Style Resources.
 *
 * @version    1.0.0
 * @since      02-Dic-2019
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog/sobre-mi/
 */
class Wp_Motive_Resources extends Wp_Motive_i18n {
    private $plugin_url = null;
    private $plugin_version = null;

    public function __construct($plugin_url, $plugin_version)
    {
        $this->plugin_url = $plugin_url;
        $this->plugin_version = $plugin_version;
    }

    public function enqueue_admin_scripts() {
        $path = $this->plugin_url . "js/wp-motive-admin.js";
        wp_enqueue_script( "wp-motive-admin-scripts", $path, array("jquery"), $this->plugin_version, true );
        $this->define_localization();
        wp_localize_script("wp-motive-admin-scripts","wp_motive", $this->get_localize() );
    }

    public function enqueue_admin_styles() {
        $path = $this->plugin_url . "css/wp-motive-admin-style.css";
        wp_enqueue_style( "wp-motive-admin-styles", $path );
    }

    public function enqueue_public_scripts() {
        $path = $this->plugin_url . "js/wp-motive-public.js";
        wp_enqueue_script( "wp-motive-public-scripts", $path, array("jquery"), $this->plugin_version, true );
        $this->define_localization();
        wp_localize_script("wp-motive-public-scripts","wp_motive", $this->get_localize() );
    }

    public function enqueue_public_styles() {
        $path = $this->plugin_url . "css/wp-motive-public-style.css";
        wp_enqueue_style( "wp-motive-public-styles", $path );
    }
}
