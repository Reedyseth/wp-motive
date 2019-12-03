<?php
namespace Wp_Motive;
/**
 * This class define the core functionality of the Plugin.
 *
 * @link       http://behstant.com/blog
 * @since      1.0.0
 * @since      29-Nov-2019
 *
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 */

/**
 * @class Wp_Motive
 * @since      1.0.0
 * @package    Wp_Motive
 * @subpackage Wp_Motive/includes
 * @author     Israel Barragan (Reedyseth) <reedyseth@gmail.com>
 */
class Wp_Motive
{
    protected $version;
    protected $plugin_version;
    protected $hooks;
    protected $plugin_url;

    public function __construct()
    {
        if( defined( PLUGIN_NAME_VERSION ) ){
            $this->plugin_version = PLUGIN_NAME_VERSION;
        }
        else {
            $this->plugin_version = "1.0.0";
        }
        $this->setPlugin_url();
        $this->hooks = new Wp_Motive_Hooks();
//        $this->load_resources();
        $this->set_locale();
        $this->load_admin();
        $this->define_public_hooks();
    }

    public function run()
    {
        $logger = new Wp_Motive_Logger();
        $logger->log("Run() function executed.!!\n");
    }

//    private function load_resources()
//    {
//        /**
//         * Enqueue styles according to the page admin|public
//         */
//        $resources = new Wp_Motive_Resources( $this->getPlugin_url(), \VERSION );
//    }
    private function set_locale()
    {
        $plugin_i18n = new Wp_Motive_i18n();
        $this->hooks->add_actions("plugins_loaded", $plugin_i18n, "load_plugin_textdomain");
    }
    private function load_admin()
    {
        $wp_motive_admin = new Wp_Motive_Admin(\SLUG, $this->getPlugin_url(), \VERSION );
    }
    private function define_public_hooks()
    {

    }

    private function setPlugin_url() {
        $this->plugin_url = plugins_url() . "/wp-motive/";
//        $logger = new Wp_Motive_Logger();
//        $logger->log("setPlugin_url() Plugin URL: {$this->plugin_url}\n");
    }

    public function getPlugin_url() {
        return $this->plugin_url;
    }
}