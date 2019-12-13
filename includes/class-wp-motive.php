<?php
namespace Wp_Motive;
/**
 * This class define the core functionality of the Plugin.
 *
 * @class Wp_Motive
 * @version    1.0.0
 * @since      29-Nov-2019
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 * @link       http://behstant.com/blog
 */
class Wp_Motive
{
    protected $version;
    protected $plugin_version;
    protected $hooks;
    protected $plugin_url;
    protected $shortcodes;

    public function __construct()
    {
        if( defined( \PLUGIN_VERSION_VERSION ) ){
            $this->plugin_version = \PLUGIN_VERSION_VERSION;
        }
        else {
            $this->plugin_version = "1.0.0";
        }
        $this->setPlugin_url();
        $this->hooks = new Wp_Motive_Hooks();
        $this->shortcodes = new Wp_Motive_Shortcode();
//        $this->load_resources();
        $this->set_locale();
        $this->load_admin();
        $this->load_public();
    }

    public function run()
    {
    }
    private function set_locale()
    {
        $plugin_i18n = new Wp_Motive_i18n();
        $this->hooks->add_actions("plugins_loaded", $plugin_i18n, "load_plugin_textdomain");
        $this->hooks->load_hooks();
    }
    private function load_admin()
    {
        $wp_motive_admin = new Wp_Motive_Admin(\SLUG, $this->getPlugin_url(), \PLUGIN_VERSION_VERSION);
    }
    private function load_public()
    {
        $wp_motive_public = new Wp_Motive_Public(\SLUG, $this->getPlugin_url(), \PLUGIN_VERSION_VERSION );
    }

    private function setPlugin_url() {
        $this->plugin_url = plugins_url() . "/wp-motive/";
    }

    public function getPlugin_url() {
        return $this->plugin_url;
    }
}
